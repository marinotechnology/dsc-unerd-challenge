<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Leaderboard extends Component
{
    use WithPagination;

    /**
     * Active role/category tab: 'Umum', 'Komunitas', 'Profesional', 'CommunityAvg'
     */
    public string $activeRoleTab = 'Umum';

    /**
     * Selected challenge period ID for historical leaderboard
     */
    public ?int $selectedPeriodId = null;

    /**
     * Realtime search query for runner / BIB
     */
    public string $search = '';

    public function mount(): void
    {
        $activePeriod = ChallengePeriod::where('is_active', true)->first()
            ?? ChallengePeriod::orderByDesc('event_date')->first();
        if ($activePeriod) {
            $this->selectedPeriodId = $activePeriod->id;
        }
    }

    /**
     * Switch category tab / dropdown
     */
    public function setRoleTab(string $tab): void
    {
        $this->activeRoleTab = $tab;
        $this->resetPage();
    }

    /**
     * Select period from searchable dropdown
     */
    public function selectPeriod(int|string $periodId): void
    {
        $this->selectedPeriodId = (int) $periodId;
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $periods = ChallengePeriod::orderByDesc('event_date')->get();

        $periodsList = $periods->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'clean_name' => $p->cleanName(),
            'code' => (string) $p->period_code,
            'is_active' => (bool) $p->is_active,
            'date' => $p->event_date?->translatedFormat('d F Y') ?? '',
        ])->values()->all();

        $currentPeriod = null;
        if ($this->selectedPeriodId) {
            $currentPeriod = ChallengePeriod::find($this->selectedPeriodId);
        }
        if (! $currentPeriod) {
            $currentPeriod = ChallengePeriod::where('is_active', true)->first()
                ?? ChallengePeriod::orderByDesc('event_date')->first();
            if ($currentPeriod) {
                $this->selectedPeriodId = $currentPeriod->id;
            }
        }

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();

        // 1. Category-specific individual leaderboard filtered by Period & Search
        $query = ChallengeResult::with(['participant.community', 'challenge', 'period'])
            ->verified()
            ->when($currentPeriod, fn ($q) => $q->where('challenge_period_id', $currentPeriod->id))
            ->orderBy('verified_time_seconds');

        if (in_array($this->activeRoleTab, ['Umum', 'Komunitas', 'Profesional'], true)) {
            $query->whereHas('participant', function ($q) {
                $q->where('participant_category', $this->activeRoleTab);
            });
        }

        if (! empty(trim($this->search))) {
            $keyword = trim($this->search);
            $query->whereHas('participant', function ($q) use ($keyword) {
                $q->where('participant_id', 'like', "%{$keyword}%")
                    ->orWhere('display_name', 'like', "%{$keyword}%")
                    ->orWhere('full_name', 'like', "%{$keyword}%");
            });
        }

        $results = $query->paginate(25);

        // 2. Community Average Ranking (Top 3 finishers avg, min 3 finishers rule)
        $communityRankings = $this->calculateCommunityLeaderboard($currentPeriod?->id);

        if (! empty(trim($this->search))) {
            $keyword = strtolower(trim($this->search));
            $communityRankings = array_values(array_filter($communityRankings, function ($comm) use ($keyword) {
                return str_contains(strtolower($comm['community']->name), $keyword)
                    || str_contains(strtolower($comm['community']->city ?? ''), $keyword);
            }));
        }

        // 3. Participant counts for tabs within current period
        $periodFilter = fn ($q) => $currentPeriod ? $q->where('challenge_period_id', $currentPeriod->id) : $q;

        $countUmum = ChallengeResult::verified()
            ->tap($periodFilter)
            ->whereHas('participant', fn ($q) => $q->where('participant_category', 'Umum'))
            ->count();

        $countKomunitas = ChallengeResult::verified()
            ->tap($periodFilter)
            ->whereHas('participant', fn ($q) => $q->where('participant_category', 'Komunitas'))
            ->count();

        $countProfesional = ChallengeResult::verified()
            ->tap($periodFilter)
            ->whereHas('participant', fn ($q) => $q->where('participant_category', 'Profesional'))
            ->count();

        return view('livewire.leaderboard', [
            'results' => $results,
            'communityRankings' => $communityRankings,
            'countUmum' => $countUmum,
            'countKomunitas' => $countKomunitas,
            'countProfesional' => $countProfesional,
            'activeChallenge' => $activeChallenge,
            'periods' => $periods,
            'periodsList' => $periodsList,
            'currentPeriod' => $currentPeriod,
            'lastUpdated' => now()->format('H:i:s'),
        ]);
    }

    /**
     * Calculate Top 3 finisher average per community for the selected period
     *
     * @return array<int, array<string, mixed>>
     */
    private function calculateCommunityLeaderboard(?int $periodId): array
    {
        $communities = Community::with(['participants.results' => function ($q) use ($periodId) {
            $q->verified();
            if ($periodId) {
                $q->where('challenge_period_id', $periodId);
            }
        }])->get();

        $ranked = [];

        foreach ($communities as $community) {
            $verifiedTimes = [];

            foreach ($community->participants as $participant) {
                foreach ($participant->results as $res) {
                    if ($res->verified_time_seconds) {
                        $verifiedTimes[] = (float) $res->verified_time_seconds;
                    }
                }
            }

            sort($verifiedTimes);
            $finishersCount = count($verifiedTimes);

            // Min 3 finishers to enter ranking per USER_STORY.md
            if ($finishersCount >= 3) {
                $top3 = array_slice($verifiedTimes, 0, 3);
                $avgSeconds = array_sum($top3) / 3;

                $minutes = (int) floor($avgSeconds / 60);
                $remSec = $avgSeconds - ($minutes * 60);
                $formattedTime = str_replace('.', ',', sprintf('%02d:%05.2f', $minutes, $remSec));

                // Pace for 1 KM (1000m) is equal to time in seconds
                $pMin = (int) floor($avgSeconds / 60);
                $pSec = (int) round($avgSeconds % 60);
                $formattedPace = sprintf('%02d:%02d/km', $pMin, $pSec);

                $ranked[] = [
                    'community' => $community,
                    'finishers_count' => $finishersCount,
                    'average_time_seconds' => $avgSeconds,
                    'formatted_avg_time' => $formattedTime,
                    'formatted_avg_pace' => $formattedPace,
                ];
            }
        }

        usort($ranked, fn ($a, $b) => $a['average_time_seconds'] <=> $b['average_time_seconds']);

        foreach ($ranked as $index => &$item) {
            $item['rank'] = $index + 1;
        }

        return $ranked;
    }
}

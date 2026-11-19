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

class Leaderboard extends Component
{
    /**
     * Active role/category tab: 'Umum', 'Komunitas', 'Profesional', 'CommunityAvg'
     */
    public string $activeRoleTab = 'Umum';

    /**
     * Selected challenge period ID for historical leaderboard
     */
    public ?int $selectedPeriodId = null;

    /**
     * Search query for period selector
     */
    public string $periodSearch = '';

    /**
     * Realtime search query for personal record
     */
    public string $search = '';

    public function mount(): void
    {
        $activePeriod = ChallengePeriod::where('is_active', true)->first();
        if ($activePeriod) {
            $this->selectedPeriodId = $activePeriod->id;
        }
    }

    /**
     * Switch category tab
     */
    public function setRoleTab(string $tab): void
    {
        $this->activeRoleTab = $tab;
    }

    public function render(): View
    {
        $periodsQuery = ChallengePeriod::orderByDesc('event_date');
        if ($this->periodSearch !== '') {
            $term = trim($this->periodSearch);
            $periodsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('period_code', 'like', "%{$term}%");
            });
        }
        $periods = $periodsQuery->get();

        $currentPeriod = ChallengePeriod::find($this->selectedPeriodId)
            ?? ChallengePeriod::where('is_active', true)->first();

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();

        // 1. Category-specific individual leaderboard filtered by Period
        $query = ChallengeResult::with(['participant.community', 'challenge', 'period'])
            ->verified()
            ->when($currentPeriod, fn ($q) => $q->where('challenge_period_id', $currentPeriod->id))
            ->orderBy('verified_time_seconds');

        if (in_array($this->activeRoleTab, ['Umum', 'Komunitas', 'Profesional'], true)) {
            $query->whereHas('participant', function ($q) {
                $q->where('participant_category', $this->activeRoleTab);
            });
        }

        $results = $query->paginate(25);

        // 2. Community Average Ranking (Top 3 finishers avg, min 3 finishers rule)
        $communityRankings = $this->calculateCommunityLeaderboard($currentPeriod?->id);

        // 3. Search Personal Record
        $personalResult = null;
        if (! empty(trim($this->search))) {
            $keyword = trim($this->search);
            $personalResult = Participant::with(['latestResult.challenge', 'community'])
                ->where(function ($q) use ($keyword) {
                    $q->where('participant_id', 'like', "%{$keyword}%")
                        ->orWhere('display_name', 'like', "%{$keyword}%")
                        ->orWhere('full_name', 'like', "%{$keyword}%")
                        ->orWhere('whatsapp', 'like', "%{$keyword}%");
                })
                ->first();
        }

        // 4. Participant counts for tabs within current period
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
            'personalResult' => $personalResult,
            'countUmum' => $countUmum,
            'countKomunitas' => $countKomunitas,
            'countProfesional' => $countProfesional,
            'activeChallenge' => $activeChallenge,
            'periods' => $periods,
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

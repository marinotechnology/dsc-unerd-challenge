<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RunnerLiveStatus extends Component
{
    public bool $showLiveStatus = true;

    public bool $showHistory = true;

    public function restartRunInPeriod(): void
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (! $user) {
            return;
        }

        $activePeriod = ChallengePeriod::where('is_active', true)->first();
        if (! $activePeriod || ! $activePeriod->is_open_for_registration) {
            return;
        }

        $participant = Participant::where('email', $user->email)->first();
        if (! $participant) {
            return;
        }

        $result = ChallengeResult::where('participant_id', $participant->id)
            ->where('challenge_period_id', $activePeriod->id)
            ->first();

        if ($result) {
            $result->update([
                'user_id' => $user->id,
                'checkin_status' => 'CHECKED_IN',
                'runner_status' => 'ACTIVE',
                'completion_status' => 'RUNNING',
                'recorded_time_seconds' => null,
                'verified_time_seconds' => null,
                'verification_status' => 'PENDING',
                'rank_in_period' => null,
                'recorded_at' => now(),
            ]);

            $activePeriod->recalculateRanks();
        }
    }

    public function render(): View
    {
        /** @var User|null $user */
        $user = Auth::user();
        $participant = $user ? Participant::where('email', $user->email)->first() : null;

        $activePeriod = ChallengePeriod::where('is_active', true)->first();
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();

        $currentResult = null;
        if ($participant && $activePeriod) {
            $currentResult = ChallengeResult::with(['period', 'challenge'])
                ->where('participant_id', $participant->id)
                ->where('challenge_period_id', $activePeriod->id)
                ->first();
        }

        // History across all periods
        $historyResults = [];
        if ($participant) {
            $historyResults = ChallengeResult::with(['period', 'challenge'])
                ->where('participant_id', $participant->id)
                ->orderByDesc('id')
                ->get();
        }

        return view('livewire.runner-live-status', [
            'user' => $user,
            'participant' => $participant,
            'activePeriod' => $activePeriod,
            'activeChallenge' => $activeChallenge,
            'currentResult' => $currentResult,
            'historyResults' => $historyResults,
        ]);
    }
}

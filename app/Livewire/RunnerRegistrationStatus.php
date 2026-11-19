<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Participant;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RunnerRegistrationStatus extends Component
{
    public int $participantId;

    public function mount(int $participantId): void
    {
        $this->participantId = $participantId;
    }

    public function render(): View
    {
        $participant = Participant::with(['community', 'results.challenge', 'results.period'])->find($this->participantId);

        $activePeriod = ChallengePeriod::where('is_active', true)->first();

        $currentResult = null;
        if ($participant && $activePeriod) {
            $currentResult = ChallengeResult::where('participant_id', $participant->id)
                ->where('challenge_period_id', $activePeriod->id)
                ->first();
        }

        if (! $currentResult && $participant) {
            $currentResult = $participant->latestResult;
        }

        $period = $currentResult?->period ?? $activePeriod;
        $venueLocation = $period?->location ?: 'Gelora Bung Karno, Jakarta';
        $distance = $period?->formattedDistance() ?: '3 KM';

        return view('livewire.runner-registration-status', [
            'participant' => $participant,
            'currentResult' => $currentResult,
            'period' => $period,
            'venueLocation' => $venueLocation,
            'distance' => $distance,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Actions\EverydayLeague;

use App\Models\ActivityEvent;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

final class RegisterRunnerAction
{
    /**
     * Register a runner for the UNERD Everyday League challenge.
     *
     * @param array{
     *     full_name: string,
     *     display_name: string,
     *     whatsapp: string,
     *     email: string,
     *     shoe_size: int,
     *     participant_category: string,
     *     community_id?: int|null,
     *     product_interest?: string|null,
     *     marketing_consent?: bool,
     *     terms_consent?: bool,
     *     acquisition_source?: string|null
     * } $runnerData
     */
    public function execute(array $runnerData): Participant
    {
        return DB::transaction(function () use ($runnerData) {
            $participantId = $this->generateUniqueParticipantId();

            $participant = Participant::create([
                'participant_id' => $participantId,
                'full_name' => trim($runnerData['full_name']),
                'display_name' => trim($runnerData['display_name']),
                'whatsapp' => trim($runnerData['whatsapp']),
                'email' => strtolower(trim($runnerData['email'])),
                'shoe_size' => (int) $runnerData['shoe_size'],
                'participant_category' => $runnerData['participant_category'],
                'community_id' => ! empty($runnerData['community_id']) ? (int) $runnerData['community_id'] : null,
                'product_interest' => $runnerData['product_interest'] ?? 'Belum Menentukan',
                'marketing_consent' => (bool) ($runnerData['marketing_consent'] ?? false),
                'terms_consent' => (bool) ($runnerData['terms_consent'] ?? true),
                'acquisition_source' => $runnerData['acquisition_source'] ?? 'QR_GBK',
            ]);

            // Automatically bind to the active Run Challenge and active Period as REGISTERED (Menunggu Check-in Start di Lokasi GBK)
            $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
            $activePeriod = ChallengePeriod::where('is_active', true)->first();

            if ($activeChallenge) {
                ChallengeResult::create([
                    'participant_id' => $participant->id,
                    'user_id' => $runnerData['user_id'] ?? null,
                    'challenge_id' => $activeChallenge->id,
                    'challenge_period_id' => $activePeriod?->id,
                    'checkin_status' => 'REGISTERED',
                    'runner_status' => 'REGISTERED',
                    'completion_status' => 'NOT_STARTED',
                    'verification_status' => 'PENDING',
                    'recorded_at' => now(),
                ]);
            }

            // Log registration event
            ActivityEvent::create([
                'event_type' => 'registration_completed',
                'participant_id' => $participant->id,
                'acquisition_source' => $runnerData['acquisition_source'] ?? 'QR_GBK',
                'metadata' => [
                    'category' => $participant->participant_category,
                    'shoe_size' => $participant->shoe_size,
                ],
            ]);

            return $participant;
        });
    }

    private function generateUniqueParticipantId(): string
    {
        $lastId = Participant::withTrashed()->max('id') ?? 0;
        $nextNumber = $lastId + 1;

        $candidateId = sprintf('UMS-%04d', $nextNumber);

        while (Participant::where('participant_id', $candidateId)->exists()) {
            $nextNumber++;
            $candidateId = sprintf('UMS-%04d', $nextNumber);
        }

        return $candidateId;
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeResult extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'challenge_results';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'participant_id',
        'user_id',
        'challenge_id',
        'challenge_period_id',
        'checkin_status',
        'runner_status',
        'completion_status',
        'is_massaged',
        'massaged_at',
        'recorded_time_seconds',
        'verified_time_seconds',
        'verification_status',
        'verified_by',
        'rank_in_period',
        'recorded_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_massaged' => 'boolean',
            'massaged_at' => 'datetime',
            'recorded_time_seconds' => 'decimal:2',
            'verified_time_seconds' => 'decimal:2',
            'rank_in_period' => 'integer',
            'recorded_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Participant, ChallengeResult>
     */
    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    /**
     * @return BelongsTo<User, ChallengeResult>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<ChallengePeriod, ChallengeResult>
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(ChallengePeriod::class, 'challenge_period_id');
    }

    /**
     * Check if the runner is currently active on the track
     */
    public function isRunning(): bool
    {
        if ($this->isFinished()) {
            return false;
        }

        return $this->runner_status === 'ACTIVE'
            || $this->completion_status === 'RUNNING';
    }

    /**
     * Check if the runner has registered online and is waiting for on-site check-in to start
     */
    public function isPendingCheckin(): bool
    {
        if ($this->isFinished() || $this->isRunning()) {
            return false;
        }

        return $this->runner_status === 'REGISTERED'
            || $this->runner_status === 'PENDING'
            || $this->checkin_status === 'REGISTERED'
            || $this->completion_status === 'NOT_STARTED';
    }

    /**
     * Check if the runner has finished their run
     */
    public function isFinished(): bool
    {
        return $this->runner_status === 'FINISHED'
            || $this->completion_status === 'COMPLETED'
            || $this->verified_time_seconds !== null;
    }

    /**
     * Resolve prize for this result based on its rank in period
     *
     * @return array<string, mixed>|null
     */
    public function getPrize(): ?array
    {
        if (! $this->rank_in_period || $this->rank_in_period > 10) {
            return null;
        }

        if ($this->relationLoaded('period')) {
            return $this->period?->getPrizeForRank($this->rank_in_period);
        }

        $period = $this->challenge_period_id ? ChallengePeriod::find($this->challenge_period_id) : null;

        return $period?->getPrizeForRank($this->rank_in_period);
    }

    /**
     * @return BelongsTo<Challenge, ChallengeResult>
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    /**
     * @return BelongsTo<User, ChallengeResult>
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * @param  Builder<ChallengeResult>  $query
     * @return Builder<ChallengeResult>
     */
    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verification_status', 'VERIFIED')
            ->whereNotNull('verified_time_seconds');
    }

    /**
     * Format seconds into mm:ss,ms (Indonesian format with comma decimal)
     */
    public function formattedTime(): string
    {
        $seconds = (float) ($this->verified_time_seconds ?? $this->recorded_time_seconds ?? 0);

        return static::formatSecondsToIndonesian($seconds);
    }

    /**
     * Format raw float seconds into mm:ss,ms (Indonesian format with comma).
     */
    public static function formatSecondsToIndonesian(float $seconds): string
    {
        if ($seconds <= 0) {
            return '--:--,--';
        }

        $minutes = (int) floor($seconds / 60);
        $remainingSeconds = $seconds - ($minutes * 60);

        return str_replace('.', ',', sprintf('%02d:%05.2f', $minutes, $remainingSeconds));
    }

    /**
     * Parse raw string or digit input into float seconds.
     * Supports:
     * - Pure digits without punctuation: "032450", "32450", "8450", "0324"
     * - Indonesian comma/colon: "03:24,50", "84,50"
     * - Colon/dot format: "01:24.50", "84.5"
     */
    public static function parseTimeToSeconds(string $timeString): ?float
    {
        $timeString = trim($timeString);

        if ($timeString === '') {
            return null;
        }

        // If string has colon: mm:ss,ms or mm:ss.ms
        if (str_contains($timeString, ':')) {
            $parts = explode(':', $timeString);
            if (count($parts) === 2) {
                $min = (float) str_replace(',', '.', $parts[0]);
                $sec = (float) str_replace(',', '.', $parts[1]);

                return ($min * 60) + $sec;
            }
        }

        // If string contains comma or dot as decimal with reasonable length (e.g. "84,50", "204,50", "84.5")
        if ((str_contains($timeString, ',') || str_contains($timeString, '.')) && strlen($timeString) <= 8) {
            $normalized = str_replace(',', '.', $timeString);
            if (is_numeric($normalized)) {
                return (float) $normalized;
            }
        }

        // Pure digits: strip any non-digit character
        $digits = preg_replace('/\D/', '', $timeString);
        if ($digits !== null && $digits !== '') {
            $len = strlen($digits);

            // 6 digits: MMSSms (e.g. 032450 -> 03 min, 24 sec, 50 ms)
            if ($len === 6) {
                $min = (int) substr($digits, 0, 2);
                $sec = (int) substr($digits, 2, 2);
                $ms = (int) substr($digits, 4, 2);

                return ($min * 60) + $sec + ($ms / 100);
            }

            // 5 digits: MSSms (e.g. 32450 -> 3 min, 24 sec, 50 ms)
            if ($len === 5) {
                $min = (int) substr($digits, 0, 1);
                $sec = (int) substr($digits, 1, 2);
                $ms = (int) substr($digits, 3, 2);

                return ($min * 60) + $sec + ($ms / 100);
            }

            // 4 digits: e.g. 8450 (if first 2 >= 60, treat as sec+ms: 84 sec, 50 ms)
            // or 0324 (if first 2 < 60, treat as 3 min, 24 sec)
            if ($len === 4) {
                $firstTwo = (int) substr($digits, 0, 2);
                $lastTwo = (int) substr($digits, 2, 2);
                if ($firstTwo >= 60) {
                    return $firstTwo + ($lastTwo / 100);
                }

                return ($firstTwo * 60) + $lastTwo;
            }

            // 3 digits: e.g. 324 -> 3 min, 24 sec
            if ($len === 3) {
                $min = (int) substr($digits, 0, 1);
                $sec = (int) substr($digits, 1, 2);

                return ($min * 60) + $sec;
            }

            // 1-2 digits: seconds
            if (is_numeric($digits)) {
                return (float) $digits;
            }
        }

        return null;
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->formattedTime();
    }

    /**
     * Calculate running pace per kilometer (for 1000m distance)
     */
    public function formattedPace(): string
    {
        $seconds = (float) ($this->verified_time_seconds ?? $this->recorded_time_seconds ?? 0);

        if ($seconds <= 0) {
            return '--:--/km';
        }

        $distanceMeter = 1000;
        if ($this->relationLoaded('challenge') && $this->challenge) {
            $distanceMeter = $this->challenge->distance_meter ?? 1000;
        }

        $distanceKm = max(0.1, $distanceMeter / 1000);
        $secondsPerKm = $seconds / $distanceKm;

        $paceMinutes = (int) floor($secondsPerKm / 60);
        $paceSeconds = (int) round($secondsPerKm % 60);

        return sprintf('%02d:%02d/km', $paceMinutes, $paceSeconds);
    }

    public function getFormattedPaceAttribute(): string
    {
        return $this->formattedPace();
    }

    /**
     * Toggle the massage status for the participant in this result.
     */
    public function toggleMassage(): void
    {
        $this->is_massaged = ! $this->is_massaged;
        $this->massaged_at = $this->is_massaged ? now() : null;
        $this->save();
    }
}

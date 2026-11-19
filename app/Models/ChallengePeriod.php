<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChallengePeriod extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'challenge_periods';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'challenge_id',
        'name',
        'period_code',
        'event_date',
        'is_active',
        'is_open_for_registration',
        'prizes_config',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_active' => 'boolean',
            'is_open_for_registration' => 'boolean',
            'prizes_config' => 'array',
        ];
    }

    /**
     * Get clean period name without "Periode X —" prefix
     */
    public function cleanName(): string
    {
        $cleaned = preg_replace('/^Periode\s*\d+\s*[-—–]\s*/i', '', $this->name);

        return trim((string) $cleaned) ?: $this->name;
    }

    /**
     * @return BelongsTo<Challenge, ChallengePeriod>
     */
    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'challenge_id');
    }

    /**
     * @return HasMany<ChallengeResult>
     */
    public function results(): HasMany
    {
        return $this->hasMany(ChallengeResult::class, 'challenge_period_id');
    }

    /**
     * Scope query to active period
     *
     * @param  Builder<ChallengePeriod>  $query
     * @return Builder<ChallengePeriod>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Default prizes structure for rank 1 - 10
     *
     * @return array<int, array<string, mixed>>
     */
    public static function defaultPrizesConfig(): array
    {
        return [
            [
                'rank_from' => 1,
                'rank_to' => 1,
                'type' => 'SEPATU',
                'title' => 'Sepatu UNERD Pilihan + Voucher 10%',
                'voucher_code' => 'MOVE-CHAMPION-10%',
                'description' => 'Sepatu lari UNERD (Performance / Lifestyle) sesuai ukuran kaki pelari.',
            ],
            [
                'rank_from' => 2,
                'rank_to' => 2,
                'type' => 'UANG',
                'title' => 'Uang Tunai Rp 1.500.000 + Voucher 10%',
                'voucher_code' => 'MOVE-PODIUM-10%',
                'description' => 'Uang tunai pembinaan podium 2 dan voucher belanja UNERD 10%.',
            ],
            [
                'rank_from' => 3,
                'rank_to' => 3,
                'type' => 'UANG',
                'title' => 'Uang Tunai Rp 1.000.000 + Voucher 10%',
                'voucher_code' => 'MOVE-PODIUM-10%',
                'description' => 'Uang tunai pembinaan podium 3 dan voucher belanja UNERD 10%.',
            ],
            [
                'rank_from' => 4,
                'rank_to' => 10,
                'type' => 'VOUCHER',
                'title' => 'Voucher Diskon Belanja 10%',
                'voucher_code' => 'MOVE-TOP10-10%',
                'description' => 'Voucher belanja eksklusif 10% untuk Top 10 Finisher.',
            ],
        ];
    }

    /**
     * Resolve prize definition for a specific leaderboard rank (1 - 10)
     *
     * @return array<string, mixed>|null
     */
    public function getPrizeForRank(int $rank): ?array
    {
        if ($rank < 1 || $rank > 10) {
            return null;
        }

        $config = $this->prizes_config ?? static::defaultPrizesConfig();

        foreach ($config as $item) {
            $from = (int) ($item['rank_from'] ?? $item['rank'] ?? 0);
            $to = (int) ($item['rank_to'] ?? $item['rank'] ?? $from);

            if ($rank >= $from && $rank <= $to) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Recalculate and update ranks for all verified results in this period
     */
    public function recalculateRanks(): void
    {
        $results = $this->results()
            ->whereNotNull('verified_time_seconds')
            ->where('verification_status', 'VERIFIED')
            ->orderBy('verified_time_seconds')
            ->get();

        foreach ($results as $index => $result) {
            $result->update([
                'rank_in_period' => $index + 1,
            ]);
        }
    }
}

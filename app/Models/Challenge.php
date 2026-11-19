<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'challenges';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'challenge_type',
        'distance_meter',
        'location',
        'event_date',
        'status',
        'description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'distance_meter' => 'integer',
            'event_date' => 'date',
        ];
    }

    /**
     * Get formatted distance (e.g. "3 KM")
     */
    public function formattedDistance(): string
    {
        $meter = $this->distance_meter ?: 3000;
        $km = $meter / 1000;

        return ($meter % 1000 === 0 ? (string) (int) $km : number_format($km, 1)).' KM';
    }

    /**
     * @return HasMany<ChallengeResult>
     */
    public function results(): HasMany
    {
        return $this->hasMany(ChallengeResult::class, 'challenge_id');
    }

    /**
     * @param  Builder<Challenge>  $query
     * @return Builder<Challenge>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'ACTIVE');
    }
}

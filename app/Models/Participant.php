<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'participants';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'participant_id',
        'full_name',
        'display_name',
        'whatsapp',
        'email',
        'shoe_size',
        'participant_category',
        'community_id',
        'product_interest',
        'marketing_consent',
        'terms_consent',
        'acquisition_source',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'shoe_size' => 'integer',
            'marketing_consent' => 'boolean',
            'terms_consent' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Community, Participant>
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    /**
     * @return HasMany<ChallengeResult>
     */
    public function results(): HasMany
    {
        return $this->hasMany(ChallengeResult::class, 'participant_id');
    }

    /**
     * @return HasOne<ChallengeResult>
     */
    public function latestResult(): HasOne
    {
        return $this->hasOne(ChallengeResult::class, 'participant_id')->latestOfMany();
    }

    /**
     * @param  Builder<Participant>  $query
     * @return Builder<Participant>
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('participant_category', $category);
    }
}

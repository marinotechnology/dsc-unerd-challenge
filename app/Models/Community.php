<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'communities';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'city',
        'description',
    ];

    /**
     * @return HasMany<Participant>
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'community_id');
    }
}

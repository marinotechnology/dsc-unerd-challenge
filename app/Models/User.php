<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'shoe_size',
        'password',
        'role_id',
        'community_id',
        'is_blocked',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'shoe_size' => 'integer',
            'community_id' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Role, User>
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * @return BelongsTo<Community, User>
     */
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_blocked', false);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeBlocked(Builder $query): Builder
    {
        return $query->where('is_blocked', true);
    }

    /**
     * Verify whether the user has a specific role or any role in the given list.
     *
     * @param  string|UserRole|array<string|UserRole>  $roles
     */
    public function hasRole(string|UserRole|array $roles): bool
    {
        if (! $this->relationLoaded('role')) {
            $this->load('role');
        }

        if (! $this->role) {
            return false;
        }

        $allowedSlugs = array_map(
            fn ($item) => $item instanceof UserRole ? $item->value : (string) $item,
            is_array($roles) ? $roles : [$roles]
        );

        return in_array($this->role->slug, $allowedSlugs, true);
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole(['admin', 'administrator', UserRole::ADMIN, UserRole::ADMINISTRATOR]);
    }

    public function isAdmin(): bool
    {
        return $this->isAdministrator();
    }

    public function isUmum(): bool
    {
        return $this->hasRole(['umum', UserRole::UMUM]);
    }

    public function isKomunitas(): bool
    {
        return $this->hasRole(['komunitas', UserRole::KOMUNITAS]);
    }

    public function isProfesional(): bool
    {
        return $this->hasRole(['profesional', UserRole::PROFESIONAL]);
    }

    public function isRunner(): bool
    {
        return $this->isUmum() || $this->isKomunitas() || $this->isProfesional();
    }

    public function isFieldSales(): bool
    {
        return $this->isAdministrator();
    }

    public function isB2bClient(): bool
    {
        return $this->isKomunitas();
    }

    public function isCustomer(): bool
    {
        return $this->isRunner();
    }

    public function isActive(): bool
    {
        return ! $this->is_blocked;
    }

    /**
     * @return HasMany<ChallengeResult>
     */
    public function challengeResults(): HasMany
    {
        return $this->hasMany(ChallengeResult::class, 'user_id');
    }

    /**
     * @return HasOne<Participant>
     */
    public function participant(): HasOne
    {
        return $this->hasOne(Participant::class, 'email', 'email');
    }
}

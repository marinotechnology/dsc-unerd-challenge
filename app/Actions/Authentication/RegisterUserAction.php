<?php

declare(strict_types=1);

namespace App\Actions\Authentication;

use App\Models\Role;
use App\Models\User;
use App\Support\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class RegisterUserAction
{
    /**
     * Register a new user with an assigned runner role and shoe size.
     *
     * @param  array{name: string, email: string, password: string, phone_number?: string|null, shoe_size?: int|null, role_slug?: string|null, community_id?: int|null}  $userData
     */
    public function execute(array $userData): User
    {
        return DB::transaction(function () use ($userData) {
            $roleId = $this->resolveRoleId($userData['role_slug'] ?? null);

            return User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'phone_number' => $userData['phone_number'] ?? null,
                'shoe_size' => isset($userData['shoe_size']) ? (int) $userData['shoe_size'] : 42,
                'role_id' => $roleId,
                'community_id' => ! empty($userData['community_id']) ? (int) $userData['community_id'] : null,
                'password' => Hash::make($userData['password']),
                'is_blocked' => false,
            ]);
        });
    }

    private function resolveRoleId(?string $roleSlug): int
    {
        // Public registration allows: women, umum, community/komunitas, pro/profesional
        $permittedRegistrationSlugs = [
            UserRole::WOMEN->value,
            UserRole::UMUM->value,
            UserRole::KOMUNITAS->value,
            UserRole::PROFESIONAL->value,
            'community',
            'pro',
            'customer',
            'b2b-client',
        ];

        $targetSlug = in_array($roleSlug, $permittedRegistrationSlugs, true)
            ? $roleSlug
            : UserRole::UMUM->value;

        // Map alias slugs
        if ($targetSlug === 'customer') {
            $targetSlug = UserRole::UMUM->value;
        } elseif ($targetSlug === 'community') {
            $targetSlug = UserRole::KOMUNITAS->value;
        } elseif ($targetSlug === 'pro') {
            $targetSlug = UserRole::PROFESIONAL->value;
        }

        $roleNames = [
            UserRole::WOMEN->value => 'Women',
            UserRole::UMUM->value => 'Umum',
            UserRole::KOMUNITAS->value => 'Komunitas',
            UserRole::PROFESIONAL->value => 'Profesional',
            'b2b-client' => 'B2B Client Partner',
        ];

        $role = Role::firstOrCreate(
            ['slug' => $targetSlug],
            [
                'name' => $roleNames[$targetSlug] ?? ucfirst($targetSlug),
                'description' => "Akun pelari kategori {$targetSlug}",
                'is_system_reserved' => true,
            ]
        );

        return $role->id;
    }
}

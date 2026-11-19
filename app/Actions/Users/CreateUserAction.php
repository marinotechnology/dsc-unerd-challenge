<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class CreateUserAction
{
    /**
     * Create a new user with assigned role and status by an administrator.
     *
     * @param  array{name: string, email: string, password: string, role_id: int, phone_number?: string|null, community_id?: int|null, is_blocked?: bool}  $userData
     */
    public function execute(array $userData): User
    {
        return DB::transaction(function () use ($userData) {
            return User::create([
                'name' => trim($userData['name']),
                'email' => strtolower(trim($userData['email'])),
                'phone_number' => isset($userData['phone_number']) ? trim($userData['phone_number']) : null,
                'role_id' => $userData['role_id'],
                'community_id' => isset($userData['community_id']) && $userData['community_id'] ? (int) $userData['community_id'] : null,
                'password' => Hash::make($userData['password']),
                'is_blocked' => $userData['is_blocked'] ?? false,
            ]);
        });
    }
}

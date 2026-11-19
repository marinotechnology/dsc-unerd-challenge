<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Support\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesData = [
            [
                'name' => 'Admin',
                'slug' => UserRole::ADMIN->value,
                'description' => 'Akses penuh administrasi website, data pelari, hasil stopwatch, dan operasional event.',
                'is_system_reserved' => true,
            ],
            [
                'name' => 'Umum',
                'slug' => UserRole::UMUM->value,
                'description' => 'Pelari kategori Umum (Individu / Mandiri).',
                'is_system_reserved' => true,
            ],
            [
                'name' => 'Komunitas',
                'slug' => UserRole::KOMUNITAS->value,
                'description' => 'Pelari yang terafiliasi dengan Komunitas Lari mitra UNERD.',
                'is_system_reserved' => true,
            ],
            [
                'name' => 'Profesional',
                'slug' => UserRole::PROFESIONAL->value,
                'description' => 'Pelari kompetitif, atlet, atau pelari berlisensi profesional.',
                'is_system_reserved' => true,
            ],
        ];

        $persistedRoles = [];
        foreach ($rolesData as $roleItem) {
            $persistedRoles[$roleItem['slug']] = Role::updateOrCreate(
                ['slug' => $roleItem['slug']],
                $roleItem
            );
        }

        // Backwards compatibility for administrator alias
        Role::firstOrCreate(
            ['slug' => 'administrator'],
            [
                'name' => 'Administrator',
                'description' => 'System admin alias',
                'is_system_reserved' => true,
            ]
        );

        $defaultPassword = Hash::make('password');

        $usersData = [
            [
                'name' => 'Admin UNERD',
                'email' => 'admin@unerd.com',
                'phone_number' => '+6281100000001',
                'shoe_size' => 42,
                'role_id' => $persistedRoles[UserRole::ADMIN->value]->id,
                'password' => $defaultPassword,
                'is_blocked' => false,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'umum@unerd.com',
                'phone_number' => '+6281100000002',
                'shoe_size' => 42,
                'role_id' => $persistedRoles[UserRole::UMUM->value]->id,
                'password' => $defaultPassword,
                'is_blocked' => false,
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'komunitas@unerd.com',
                'phone_number' => '+6281100000003',
                'shoe_size' => 39,
                'role_id' => $persistedRoles[UserRole::KOMUNITAS->value]->id,
                'password' => $defaultPassword,
                'is_blocked' => false,
            ],
            [
                'name' => 'Reza Pratama',
                'email' => 'profesional@unerd.com',
                'phone_number' => '+6281100000004',
                'shoe_size' => 43,
                'role_id' => $persistedRoles[UserRole::PROFESIONAL->value]->id,
                'password' => $defaultPassword,
                'is_blocked' => false,
            ],
        ];

        foreach ($usersData as $userItem) {
            User::updateOrCreate(
                ['email' => $userItem['email']],
                $userItem
            );
        }
    }
}

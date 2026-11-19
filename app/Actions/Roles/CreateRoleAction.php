<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

final class CreateRoleAction
{
    /**
     * Create a new custom user role in the system.
     *
     * @param  array{name: string, slug?: string|null, description?: string|null}  $roleData
     */
    public function execute(array $roleData): Role
    {
        return DB::transaction(function () use ($roleData) {
            $formattedSlug = $this->generateUniqueSlug($roleData['name'], $roleData['slug'] ?? null);

            return Role::create([
                'name' => trim($roleData['name']),
                'slug' => $formattedSlug,
                'description' => isset($roleData['description']) ? trim($roleData['description']) : null,
                'is_system_reserved' => false,
            ]);
        });
    }

    private function generateUniqueSlug(string $roleName, ?string $providedSlug): string
    {
        $candidateSlug = ! empty($providedSlug)
            ? Str::slug($providedSlug)
            : Str::slug($roleName);

        if (empty($candidateSlug)) {
            throw new InvalidArgumentException('Role slug cannot be empty.');
        }

        $originalSlug = $candidateSlug;
        $counter = 1;

        while (Role::where('slug', $candidateSlug)->exists()) {
            $candidateSlug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $candidateSlug;
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    /**
     * Search communities by name or city.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));

        $communities = Community::query()
            ->when($query !== '', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('city', 'like', "%{$query}%");
            })
            ->orderBy('name')
            ->limit(15)
            ->get(['id', 'name', 'city']);

        return response()->json($communities);
    }

    /**
     * Store a new community.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:communities,name'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug ?: 'community-'.Str::random(6);
        $counter = 1;
        while (Community::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $community = Community::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'city' => ! empty($validated['city']) ? $validated['city'] : 'Jakarta',
            'description' => 'Komunitas lari terdaftar pada UNERD Move Series',
        ]);

        return response()->json([
            'message' => 'Komunitas berhasil ditambahkan',
            'community' => [
                'id' => $community->id,
                'name' => $community->name,
                'city' => $community->city,
            ],
        ], 201);
    }
}

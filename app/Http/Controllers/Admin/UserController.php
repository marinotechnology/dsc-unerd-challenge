<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Users\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of all users with optional role filtering and search.
     */
    public function index(Request $request): View
    {
        $selectedRoleSlug = $request->query('role');
        $searchQuery = $request->query('search');

        $usersQuery = User::with(['role', 'community'])->latest();

        if ($selectedRoleSlug) {
            $usersQuery->whereHas('role', function ($query) use ($selectedRoleSlug) {
                $query->where('slug', $selectedRoleSlug);
            });
        }

        if ($searchQuery) {
            $usersQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                    ->orWhere('email', 'like', "%{$searchQuery}%")
                    ->orWhere('phone_number', 'like', "%{$searchQuery}%");
            });
        }

        $users = $usersQuery->paginate(12)->withQueryString();
        $roles = Role::orderBy('name')->get();
        $communities = Community::orderBy('name')->get();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => $roles,
            'communities' => $communities,
            'selectedRoleSlug' => $selectedRoleSlug,
            'searchQuery' => $searchQuery,
        ]);
    }

    /**
     * Store a newly created user in storage by an administrator.
     */
    public function store(Request $request, CreateUserAction $createUserAction): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'community_id' => ['nullable', 'integer', 'exists:communities,id'],
            'password' => ['required', Password::defaults()],
        ]);

        $createUserAction->execute([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null,
            'role_id' => (int) $validatedData['role_id'],
            'community_id' => ! empty($validatedData['community_id']) ? (int) $validatedData['community_id'] : null,
            'password' => $validatedData['password'],
            'is_blocked' => false,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Update user details, role, and optional password.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'community_id' => ['nullable', 'integer', 'exists:communities,id'],
            'password' => ['nullable', 'string', Password::defaults()],
        ]);

        $updatePayload = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null,
            'role_id' => (int) $validatedData['role_id'],
            'community_id' => ! empty($validatedData['community_id']) ? (int) $validatedData['community_id'] : null,
        ];

        if (! empty($validatedData['password'])) {
            $updatePayload['password'] = Hash::make($validatedData['password']);
        }

        $user->update($updatePayload);

        return redirect()->route('admin.users.index')->with('status', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Reset or update user password directly by an administrator.
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validatedData = $request->validate([
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.users.index')->with('status', "Kata sandi akun {$user->name} berhasil diperbarui.");
    }

    /**
     * Toggle the active / blocked status of a user.
     */
    public function toggleBlock(Request $request, User $user): RedirectResponse
    {
        // Prevent admin from blocking themselves
        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')->withErrors([
                'error' => 'Anda tidak dapat memblokir akun Anda sendiri.',
            ]);
        }

        $user->update([
            'is_blocked' => ! $user->is_blocked,
        ]);

        $statusText = $user->is_blocked ? 'dinonaktifkan (diblokir)' : 'diaktifkan kembali';

        return redirect()->route('admin.users.index')->with('status', "Akun {$user->name} berhasil {$statusText}.");
    }
}

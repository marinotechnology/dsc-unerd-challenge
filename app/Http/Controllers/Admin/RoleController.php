<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Roles\CreateRoleAction;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of all roles / user types in the system.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')
            ->orderByDesc('is_system_reserved')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.roles.index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created role / user type.
     */
    public function store(Request $request, CreateRoleAction $createRoleAction): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:roles,name'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $createRoleAction->execute([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'] ?? null,
            'description' => $validatedData['description'] ?? null,
        ]);

        return redirect()->route('admin.roles.index')->with('status', 'Tipe pengguna / Role baru berhasil didaftarkan ke sistem.');
    }

    /**
     * Remove the specified custom role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->is_system_reserved) {
            return redirect()->route('admin.roles.index')->withErrors([
                'error' => 'Role bawaan sistem ('.$role->name.') dilindungi dan tidak dapat dihapus.',
            ]);
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->withErrors([
                'error' => 'Tidak dapat menghapus role ini karena masih terdapat '.$role->users()->count().' pengguna yang menggunakan tipe ini.',
            ]);
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('status', 'Tipe role berhasil dihapus dari sistem.');
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Support\Enums\UserRole;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the comprehensive UNERD Administrator HQ Dashboard.
     */
    public function index(): View
    {
        $totalUsersCount = User::count();
        $totalRolesCount = Role::count();

        $fieldSalesCount = User::whereHas('role', function ($query) {
            $query->where('slug', UserRole::FIELD_SALES->value);
        })->count();

        $b2bClientsCount = User::whereHas('role', function ($query) {
            $query->where('slug', UserRole::B2B_CLIENT->value);
        })->count();

        $customersCount = User::whereHas('role', function ($query) {
            $query->where('slug', UserRole::CUSTOMER->value);
        })->count();

        $recentUsers = User::with('role')
            ->latest()
            ->take(6)
            ->get();

        $rolesList = Role::withCount('users')
            ->orderByDesc('is_system_reserved')
            ->orderBy('name')
            ->get();

        return view('admin.dashboard', [
            'totalUsersCount' => $totalUsersCount,
            'totalRolesCount' => $totalRolesCount,
            'fieldSalesCount' => $fieldSalesCount,
            'b2bClientsCount' => $b2bClientsCount,
            'customersCount' => $customersCount,
            'recentUsers' => $recentUsers,
            'rolesList' => $rolesList,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Route the authenticated user to their role-specific dashboard.
     */
    public function index(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $roleSlug = $user->role?->slug;

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($roleSlug === 'field-sales') {
            return redirect()->route('sales.dashboard');
        }

        if ($roleSlug === 'b2b-client') {
            return redirect()->route('portal.dashboard');
        }

        // All runner roles (Umum, Komunitas, Profesional, Customer) share the unified runner dashboard
        return redirect()->route('customer.dashboard');
    }
}

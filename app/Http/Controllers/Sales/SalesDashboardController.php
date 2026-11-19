<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesDashboardController extends Controller
{
    /**
     * Display the Field Sales Representative PWA Dashboard (Pilar #02).
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Sample domain data representing field routes and outlets
        $assignedOutlets = [
            [
                'outlet_name' => 'Sneakers Department Malang',
                'address' => 'Jl. Ijen No. 42, Malang',
                'target_order_nominal' => 15000000.00,
                'status' => 'PENDING_VISIT',
                'geofence_distance_meters' => 28,
            ],
            [
                'outlet_name' => 'Kicks Avenue Galaxy Mall Surabaya',
                'address' => 'Galaxy Mall 3 Lt. 2, Surabaya',
                'target_order_nominal' => 32000000.00,
                'status' => 'CHECKED_IN',
                'geofence_distance_meters' => 14,
            ],
            [
                'outlet_name' => 'Pasuruan Footwear Hub',
                'address' => 'Ruko Soekarno Hatta No. 10, Pasuruan',
                'target_order_nominal' => 22500000.00,
                'status' => 'COMPLETED',
                'geofence_distance_meters' => 8,
            ],
        ];

        return view('sales.dashboard', [
            'user' => $user,
            'assignedOutlets' => $assignedOutlets,
            'dailyTargetNominal' => 69500000.00,
            'achievedNominal' => 22500000.00,
        ]);
    }
}

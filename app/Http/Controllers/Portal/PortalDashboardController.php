<?php

declare(strict_types=1);

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalDashboardController extends Controller
{
    /**
     * Display the B2B Client Wholesale Portal Dashboard (Pilar #03).
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $creditLimitNominal = 75000000.00;
        $outstandingBalanceNominal = 24600000.00;
        $availableCreditNominal = $creditLimitNominal - $outstandingBalanceNominal;

        $recentWholesaleOrders = [
            [
                'order_number' => 'ORD-B2B-2026-0042',
                'order_date' => '2026-11-15',
                'total_amount' => 18450000.00,
                'total_quantity_pairs' => 60,
                'status' => 'IN_PRODUCTION',
                'payment_term' => 'TOP 30 Hari',
            ],
            [
                'order_number' => 'ORD-B2B-2026-0038',
                'order_date' => '2026-11-02',
                'total_amount' => 24600000.00,
                'total_quantity_pairs' => 80,
                'status' => 'DELIVERED',
                'payment_term' => 'TOP 30 Hari',
            ],
        ];

        return view('portal.dashboard', [
            'user' => $user,
            'creditLimitNominal' => $creditLimitNominal,
            'outstandingBalanceNominal' => $outstandingBalanceNominal,
            'availableCreditNominal' => $availableCreditNominal,
            'recentWholesaleOrders' => $recentWholesaleOrders,
        ]);
    }
}

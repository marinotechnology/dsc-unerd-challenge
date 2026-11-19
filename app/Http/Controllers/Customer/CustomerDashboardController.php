<?php

declare(strict_types=1);

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    /**
     * Display the Runner / Customer Hub Dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $participant = Participant::with(['latestResult.challenge', 'community'])
            ->where('email', $user->email)
            ->first();

        $dbProducts = Product::where('is_active', true)->get();

        if ($dbProducts->isNotEmpty()) {
            $featuredFootwearDrops = $dbProducts->map(fn (Product $p) => [
                'name' => $p->name,
                'category' => $p->category,
                'colorway' => $p->subtitle ?? '',
                'retail_price' => (float) $p->retail_price,
                'discounted_price' => (float) ($p->discounted_price ?? round($p->retail_price * 0.9)),
                'badge' => $p->tag ?? strtoupper($p->category),
                'badge_color' => $p->badge_color ?? 'volt',
                'image' => $p->image,
                'shopee_url' => $p->shopee_url ?? '#',
                'is_recovery' => str_contains(strtolower($p->name), 'reco') || str_contains(strtolower($p->category), 'lifestyle') || str_contains(strtolower($p->name), 'sandal'),
            ])->all();
        } else {
            $featuredFootwearDrops = [
                [
                    'name' => 'UNERD Beat Flow Performance',
                    'category' => 'Performance',
                    'colorway' => 'Jogja Nusantara Series',
                    'retail_price' => 469000.00,
                    'discounted_price' => 422100.00,
                    'badge' => 'PERFORMANCE',
                    'badge_color' => 'volt',
                    'image' => 'images/products/unerd-beat-flow-performance.jpg',
                    'shopee_url' => 'https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a',
                    'is_recovery' => false,
                ],
                [
                    'name' => 'UNERD Women Swift Move',
                    'category' => 'Women',
                    'colorway' => 'Radiant Lotus Edition',
                    'retail_price' => 459000.00,
                    'discounted_price' => 413100.00,
                    'badge' => 'WOMEN MOVE',
                    'badge_color' => 'volt',
                    'image' => 'images/products/unerd-women-swift-move.jpg',
                    'shopee_url' => 'https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b',
                    'is_recovery' => false,
                ],
                [
                    'name' => 'UNERD Thera Reco Lifestyle',
                    'category' => 'Lifestyle',
                    'colorway' => 'Ergonomic Sandal Sepatu',
                    'retail_price' => 299000.00,
                    'discounted_price' => 269100.00,
                    'badge' => 'RECOVERY & LIFESTYLE',
                    'badge_color' => 'cobalt',
                    'image' => 'images/products/unerd-thera-reco-lifestyle.jpg',
                    'shopee_url' => 'https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86',
                    'is_recovery' => true,
                ],
            ];
        }

        $recoveryFootwear = array_values(array_filter($featuredFootwearDrops, fn ($d) => ! empty($d['is_recovery'])));
        $runningFootwear = array_values(array_filter($featuredFootwearDrops, fn ($d) => empty($d['is_recovery'])));

        return view('customer.dashboard', [
            'user' => $user,
            'participant' => $participant,
            'featuredFootwearDrops' => $featuredFootwearDrops,
            'recoveryFootwear' => $recoveryFootwear,
            'runningFootwear' => $runningFootwear,
        ]);
    }
}

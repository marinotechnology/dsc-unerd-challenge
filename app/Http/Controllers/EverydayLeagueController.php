<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\EverydayLeague\RegisterRunnerAction;
use App\Models\ActivityEvent;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EverydayLeagueController extends Controller
{
    /**
     * Display the UNERD Everyday League campaign landing page.
     */
    public function index(Request $request): View
    {
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $activePeriod = ChallengePeriod::where('is_active', true)->first();

        // Top 3 runners preview for hero section
        $topRunners = ChallengeResult::with(['participant.community', 'challenge'])
            ->verified()
            ->orderBy('verified_time_seconds')
            ->take(3)
            ->get();

        // Products from database with fallback
        $dbProducts = Product::where('is_active', true)->get();

        if ($dbProducts->isNotEmpty()) {
            $featuredFootwear = $dbProducts->map(fn (Product $p) => [
                'name' => $p->name,
                'subtitle' => $p->subtitle ?? '',
                'category' => $p->category,
                'description' => $p->description ?? '',
                'price' => $p->price,
                'retail_price' => $p->retail_price,
                'discounted_price' => $p->discounted_price,
                'tag' => $p->tag ?? strtoupper($p->category),
                'color' => $p->badge_color ?? 'volt',
                'image' => $p->image,
                'slug' => $p->slug,
                'shopee_url' => $p->shopee_url,
            ])->all();
        } else {
            $featuredFootwear = [
                [
                    'name' => 'UNERD Beat Flow Performance',
                    'subtitle' => 'Nusantara Edition - Road & Sprint 1 KM',
                    'category' => 'Performance',
                    'description' => 'Bantalan responsif dengan stabilitas pijakan optimal untuk akselerasi sprint 1 KM maupun long run di lintasan aspal.',
                    'price' => 469000,
                    'retail_price' => 469000,
                    'discounted_price' => 422100,
                    'tag' => 'PERFORMANCE',
                    'color' => 'volt',
                    'image' => 'images/products/unerd-beat-flow-performance.jpg',
                    'slug' => 'unerd-beat-flow-performance',
                    'shopee_url' => 'https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a',
                ],
                [
                    'name' => 'UNERD Women Swift Move',
                    'subtitle' => 'Radiant Lotus - Sport Casual & Active Style',
                    'category' => 'Women',
                    'description' => 'Siluet dinamis dan ringan khusus rancangan anatomi wanita, fleksibel untuk pemanasan lari santai hingga mobilitas harian.',
                    'price' => 459000,
                    'retail_price' => 459000,
                    'discounted_price' => 413100,
                    'tag' => 'WOMEN MOVE',
                    'color' => 'volt',
                    'image' => 'images/products/unerd-women-swift-move.jpg',
                    'slug' => 'unerd-women-swift-move',
                    'shopee_url' => 'https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b',
                ],
                [
                    'name' => 'UNERD Thera Reco Lifestyle',
                    'subtitle' => 'Sandal Sepatu Recovery & Casual Comfort',
                    'category' => 'Lifestyle',
                    'description' => 'Footwear pemulihan pasca lari dengan footbed ergonomis empuk yang merelaksasi telapak kaki setelah latihan lari intensif.',
                    'price' => 299000,
                    'retail_price' => 299000,
                    'discounted_price' => 269100,
                    'tag' => 'RECOVERY & LIFESTYLE',
                    'color' => 'cobalt',
                    'image' => 'images/products/unerd-thera-reco-lifestyle.jpg',
                    'slug' => 'unerd-thera-reco-lifestyle',
                    'shopee_url' => 'https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86',
                ],
            ];
        }

        // Log campaign view
        ActivityEvent::create([
            'event_type' => 'campaign_view',
            'acquisition_source' => $request->query('ref', 'Direct'),
            'ip_address' => $request->ip(),
        ]);

        return view('everyday-league.index', [
            'activeChallenge' => $activeChallenge,
            'activePeriod' => $activePeriod,
            'topRunners' => $topRunners,
            'featuredFootwear' => $featuredFootwear,
        ]);
    }

    /**
     * Display the challenge selection view for authenticated runners.
     */
    public function registerView(Request $request): View
    {
        $user = $request->user();
        $challenges = Challenge::orderBy('id')->get();
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $activePeriod = ChallengePeriod::where('is_active', true)->first();
        $communities = Community::orderBy('name')->get();

        // Check if user already has a participant record
        $existingParticipant = $user ? Participant::where('email', $user->email)->first() : null;
        $existingResultInPeriod = null;
        if ($existingParticipant && $activePeriod) {
            $existingResultInPeriod = ChallengeResult::where('participant_id', $existingParticipant->id)
                ->where('challenge_period_id', $activePeriod->id)
                ->first();
        }

        // Determine user's role category
        $roleCategory = match ($user?->role?->slug) {
            'komunitas' => 'Komunitas',
            'profesional' => 'Profesional',
            default => 'Umum',
        };

        $isOpenForRegistration = $activePeriod ? $activePeriod->is_open_for_registration : false;

        return view('everyday-league.register', [
            'user' => $user,
            'challenges' => $challenges,
            'activeChallenge' => $activeChallenge,
            'activePeriod' => $activePeriod,
            'isOpenForRegistration' => $isOpenForRegistration,
            'communities' => $communities,
            'existingParticipant' => $existingParticipant,
            'existingResultInPeriod' => $existingResultInPeriod,
            'roleCategory' => $roleCategory,
        ]);
    }

    /**
     * Handle the challenge selection submission (Uses user profile data).
     */
    public function storeRegistration(Request $request, RegisterRunnerAction $registerRunnerAction): RedirectResponse
    {
        $user = $request->user();
        $activePeriod = ChallengePeriod::where('is_active', true)->first();

        if (! $activePeriod) {
            return back()->withErrors(['period' => 'Saat ini belum ada periode tantangan atau event yang sedang aktif. Pendaftaran ditutup.']);
        }

        if (! $activePeriod->is_open_for_registration) {
            return back()->withErrors(['period' => 'Pendaftaran untuk periode tantangan ini sedang ditutup oleh panitia.']);
        }

        // Automatically resolve runner data from authenticated user (no re-typing needed)
        $fullName = $user?->name ?? $request->input('full_name', 'Runner');
        $displayName = $user?->name ?? $request->input('display_name', $fullName);
        $email = $user?->email ?? $request->input('email');
        $whatsapp = $user?->phone_number ?? $request->input('whatsapp', '081234567890');
        $shoeSize = $user?->shoe_size ?? $request->input('shoe_size', 42);

        $roleCategory = match ($user?->role?->slug) {
            'komunitas' => 'Komunitas',
            'profesional' => 'Profesional',
            default => $request->input('participant_category', 'Umum'),
        };

        $validatedData = $request->validate([
            'challenge_slug' => ['nullable', 'string'],
            'community_id' => ['nullable', 'integer', 'exists:communities,id'],
            'product_interest' => ['nullable', 'string', 'in:Performance,Lifestyle,Belum Menentukan'],
            'terms_consent' => ['nullable'],
        ]);

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $existing = Participant::where('email', $email)->first();

        // If participant already exists in system
        if ($existing) {
            // Check if result already exists for the active period
            $existingResult = $activePeriod
                ? ChallengeResult::where('participant_id', $existing->id)
                    ->where('challenge_period_id', $activePeriod->id)
                    ->first()
                : $existing->latestResult;

            if ($existingResult) {
                if ($existingResult->isRunning()) {
                    return redirect()->route('customer.dashboard')
                        ->with('status', 'Status Anda saat ini sedang aktif lari di lintasan Time Attack Challenge GBK.');
                }

                if ($existingResult->isPendingCheckin()) {
                    return redirect()->route('customer.dashboard')
                        ->with('status', 'Anda sudah terdaftar di Time Attack Challenge. Silakan konfirmasi start ke admin di booth GBK.');
                }

                return redirect()->route('customer.dashboard')
                    ->with('status', 'Anda sudah mencatat hasil lari  di periode ini. Setiap pelari memiliki 1 kesempatan  per periode.');
            }

            // Create new result for this period
            if ($activeChallenge) {
                ChallengeResult::create([
                    'participant_id' => $existing->id,
                    'user_id' => $user?->id,
                    'challenge_id' => $activeChallenge->id,
                    'challenge_period_id' => $activePeriod?->id,
                    'checkin_status' => 'REGISTERED',
                    'runner_status' => 'REGISTERED',
                    'completion_status' => 'NOT_STARTED',
                    'verification_status' => 'PENDING',
                    'recorded_at' => now(),
                ]);
            }

            return redirect()->route('everyday-league.success', $existing->participant_id);
        }

        $participant = $registerRunnerAction->execute([
            'user_id' => $user?->id,
            'full_name' => $fullName,
            'display_name' => $displayName,
            'whatsapp' => $whatsapp,
            'email' => $email,
            'shoe_size' => (int) $shoeSize,
            'participant_category' => $roleCategory,
            'community_id' => ! empty($validatedData['community_id']) ? (int) $validatedData['community_id'] : null,
            'product_interest' => 'Performance',
            'marketing_consent' => true,
            'terms_consent' => true,
            'acquisition_source' => 'WEB_LEAGUE',
        ]);

        if ($user && ! empty($validatedData['community_id'])) {
            $user->update(['community_id' => (int) $validatedData['community_id']]);
        }

        return redirect()->route('everyday-league.success', $participant->participant_id);
    }

    /**
     * Display registration confirmation and digital BIB card.
     */
    public function success(Participant $participant): View
    {
        $participant->load('community');
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();

        return view('everyday-league.success', [
            'participant' => $participant,
            'activeChallenge' => $activeChallenge,
        ]);
    }

    /**
     * Display the 3-in-1 Leaderboard: Individual, Community, & Personal Record.
     */
    public function leaderboard(Request $request): View
    {
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $selectedCategory = $request->query('category');
        $searchParticipant = $request->query('search');

        // 1. Individual Leaderboard (Verified 500m runners, sorted by fastest time)
        $individualQuery = ChallengeResult::with(['participant.community', 'challenge'])
            ->verified()
            ->orderBy('verified_time_seconds');

        if ($selectedCategory && in_array($selectedCategory, ['Umum', 'Komunitas', 'Pekerja'], true)) {
            $individualQuery->whereHas('participant', function ($q) use ($selectedCategory) {
                $q->where('participant_category', $selectedCategory);
            });
        }

        $individualLeaderboard = $individualQuery->paginate(20)->withQueryString();

        // 2. Community Leaderboard (Average time of top 3 finishers, min 3 finishers per USER_STORY.md)
        $communityLeaderboard = $this->calculateCommunityLeaderboard();

        // 3. Personal Record Search (if requested)
        $personalRecord = null;
        if ($searchParticipant) {
            $personalRecord = Participant::with(['latestResult.challenge', 'community'])
                ->where('participant_id', 'like', "%{$searchParticipant}%")
                ->orWhere('display_name', 'like', "%{$searchParticipant}%")
                ->orWhere('full_name', 'like', "%{$searchParticipant}%")
                ->first();
        }

        // Log leaderboard view
        ActivityEvent::create([
            'event_type' => 'leaderboard_view',
            'ip_address' => $request->ip(),
        ]);

        return view('everyday-league.leaderboard', [
            'activeChallenge' => $activeChallenge,
            'individualLeaderboard' => $individualLeaderboard,
            'communityLeaderboard' => $communityLeaderboard,
            'personalRecord' => $personalRecord,
            'selectedCategory' => $selectedCategory,
            'searchParticipant' => $searchParticipant,
        ]);
    }

    /**
     * Display the shareable "My Result" card for a runner.
     */
    public function result(Request $request, Participant $participant): View
    {
        $result = null;
        if ($request->has('result_id')) {
            $result = ChallengeResult::with(['period', 'challenge'])
                ->where('participant_id', $participant->id)
                ->find($request->query('result_id'));
        } elseif ($request->has('period_id')) {
            $result = ChallengeResult::with(['period', 'challenge'])
                ->where('participant_id', $participant->id)
                ->where('challenge_period_id', $request->query('period_id'))
                ->first();
        }

        if (! $result) {
            $participant->load(['latestResult.challenge', 'latestResult.period', 'community']);
            $result = $participant->latestResult;
        } else {
            $participant->load('community');
        }

        // Calculate runner's rank in period if verified
        $overallRank = null;
        if ($result && $result->verified_time_seconds) {
            $overallRank = $result->rank_in_period ?? (
                ChallengeResult::verified()
                    ->when($result->challenge_period_id, fn ($q) => $q->where('challenge_period_id', $result->challenge_period_id))
                    ->where('verified_time_seconds', '<', $result->verified_time_seconds)
                    ->count() + 1
            );
        }

        $prize = $result?->getPrize();
        $voucherCode = ! empty($prize['voucher_code']) ? $prize['voucher_code'] : 'MOVE-GBK-10%';

        // Log result view & share event
        ActivityEvent::create([
            'event_type' => 'result_view',
            'participant_id' => $participant->id,
        ]);

        return view('everyday-league.result', [
            'participant' => $participant,
            'result' => $result,
            'overallRank' => $overallRank,
            'rank' => $overallRank ?? 1,
            'prize' => $prize,
            'voucherCode' => $voucherCode,
        ]);
    }

    /**
     * Track product click events from runners exploring UNERD footwear.
     */
    public function trackProductClick(Request $request): RedirectResponse
    {
        $productSlug = $request->input('product', $request->query('product', 'astral-speed'));
        $participantId = $request->input('participant', $request->query('participant', $request->query('pid')));

        $participant = $participantId ? Participant::where('participant_id', $participantId)->first() : null;

        ActivityEvent::create([
            'event_type' => 'product_click',
            'participant_id' => $participant?->id,
            'metadata' => [
                'product_slug' => $productSlug,
                'shoe_size' => $participant?->shoe_size,
            ],
            'ip_address' => $request->ip(),
        ]);

        $shopeeUrls = [
            'unerd-beat-flow-performance' => 'https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a',
            'unerd-women-swift-move' => 'https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b',
            'unerd-thera-reco-lifestyle' => 'https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86',
            'UNERD Beat Flow Performance' => 'https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a',
            'UNERD Women Swift Move' => 'https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b',
            'UNERD Thera Reco Lifestyle' => 'https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86',
        ];

        if (isset($shopeeUrls[$productSlug])) {
            return redirect()->away($shopeeUrls[$productSlug]);
        }

        $voucher = 'MOVE-GBK-10%';
        $size = $participant?->shoe_size ?? 42;
        $targetUrl = "https://unerd.com/products/{$productSlug}?promo=".urlencode($voucher)."&size={$size}";

        return redirect()->away($targetUrl);
    }

    /**
     * Compute Community Leaderboard based on average of top 3 finishers (min 3 finishers rule).
     *
     * @return array<int, array{
     *     rank: int,
     *     community: Community,
     *     finishers_count: int,
     *     average_time_seconds: float,
     *     formatted_average_time: string,
     *     formatted_average_pace: string
     * }>
     */
    private function calculateCommunityLeaderboard(): array
    {
        $communities = Community::with(['participants.results' => function ($query) {
            $query->verified()->orderBy('verified_time_seconds');
        }])->get();

        $ranked = [];

        foreach ($communities as $community) {
            $verifiedTimes = [];

            foreach ($community->participants as $participant) {
                foreach ($participant->results as $res) {
                    if ($res->verified_time_seconds) {
                        $verifiedTimes[] = (float) $res->verified_time_seconds;
                    }
                }
            }

            sort($verifiedTimes);
            $finishersCount = count($verifiedTimes);

            // Rule in USER_STORY.md: must have at least 3 finishers to enter competitive ranking
            if ($finishersCount >= 3) {
                $top3 = array_slice($verifiedTimes, 0, 3);
                $avgSeconds = array_sum($top3) / 3;

                $minutes = (int) floor($avgSeconds / 60);
                $remSec = $avgSeconds - ($minutes * 60);
                $formattedTime = str_replace('.', ',', sprintf('%02d:%05.2f', $minutes, $remSec));

                // Pace for 500m
                $paceSec = $avgSeconds * 2;
                $pMin = (int) floor($paceSec / 60);
                $pSec = (int) round($paceSec % 60);
                $formattedPace = sprintf('%02d:%02d/km', $pMin, $pSec);

                $ranked[] = [
                    'community' => $community,
                    'finishers_count' => $finishersCount,
                    'average_time_seconds' => $avgSeconds,
                    'formatted_average_time' => $formattedTime,
                    'formatted_average_pace' => $formattedPace,
                ];
            }
        }

        // Sort by fastest average time
        usort($ranked, fn ($a, $b) => $a['average_time_seconds'] <=> $b['average_time_seconds']);

        // Assign ranks
        foreach ($ranked as $index => &$item) {
            $item['rank'] = $index + 1;
        }

        return $ranked;
    }
}

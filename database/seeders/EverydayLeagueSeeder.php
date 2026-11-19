<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Database\Seeder;

class EverydayLeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Communities
        $communitiesData = [
            ['name' => 'Run by Five', 'slug' => 'run-by-five', 'city' => 'Jakarta', 'description' => 'Komunitas lari sub-5 pagi GBK Senayan'],
            ['name' => 'GBK Night Runners', 'slug' => 'gbk-night-runners', 'city' => 'Jakarta', 'description' => 'Komunitas pegiat lari malam lingkaran luar GBK'],
            ['name' => 'SCBD Morning Crew', 'slug' => 'scbd-morning-crew', 'city' => 'Jakarta', 'description' => 'Komunitas lari pagi kawasan SCBD & Sudirman'],
            ['name' => 'Bandung Striders', 'slug' => 'bandung-striders', 'city' => 'Bandung', 'description' => 'Komunitas lari Gasibu & Saparua Bandung'],
        ];

        $communities = [];
        foreach ($communitiesData as $c) {
            $communities[$c['slug']] = Community::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 2. Challenges: 1 KM Run Challenge
        $runChallenge = Challenge::updateOrCreate(['slug' => 'unerd-run-challenge'], [
            'name' => 'Unerd Time Attack',
            'slug' => 'unerd-run-challenge',
            'challenge_type' => 'RUN',
            'distance_meter' => 1000,
            'location' => 'Gelora Bung Karno, Jakarta',
            'event_date' => '2026-11-21',
            'status' => 'ACTIVE',
            'description' => 'Time attack 1 KM di lintasan  GBK. Catat waktu terbaikmu dan puncaki leaderboard!',
        ]);

        Challenge::updateOrCreate(['slug' => 'unerd-step-challenge'], [
            'name' => 'UNERD Step Battle',
            'slug' => 'unerd-step-challenge',
            'challenge_type' => 'STEP',
            'distance_meter' => 0,
            'location' => 'Everywhere',
            'event_date' => null,
            'status' => 'COMING_SOON',
            'description' => 'Tantangan akumulasi langkah harian dari rumah, kantor, kampus, dan perjalanan harian.',
        ]);

        Challenge::updateOrCreate(['slug' => 'unerd-on-my-feet'], [
            'name' => 'UNERD On My Feet',
            'slug' => 'unerd-on-my-feet',
            'challenge_type' => 'ON_MY_FEET',
            'distance_meter' => 0,
            'location' => 'Social Media',
            'event_date' => null,
            'status' => 'COMING_SOON',
            'description' => 'Tantangan khusus pemilik sepatu UNERD untuk pamer foto aktivitas dan cerita harian.',
        ]);

        // 2b. Challenge Periods (Periode Mingguan / Event)
        $activePeriod = ChallengePeriod::updateOrCreate(['period_code' => 'P1-GBK-20261121'], [
            'challenge_id' => $runChallenge->id,
            'name' => 'Periode 1 — Pilot GBK 21 Nov 2026',
            'period_code' => 'P1-GBK-20261121',
            'event_date' => '2026-11-21',
            'is_active' => true,
            'is_open_for_registration' => true,
            'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
        ]);

        ChallengePeriod::updateOrCreate(['period_code' => 'P2-GBK-20261128'], [
            'challenge_id' => $runChallenge->id,
            'name' => 'Periode 2 — GBK Series 28 Nov 2026',
            'period_code' => 'P2-GBK-20261128',
            'event_date' => '2026-11-28',
            'is_active' => false,
            'is_open_for_registration' => false,
            'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
        ]);

        $adminUser = User::first();

        // 3. Realistic Demo Participants with Verified 1 KM Results
        $participantsData = [
            // --- KATEGORI PROFESIONAL (Elite Runners 1 KM) ---
            [
                'participant_id' => 'UMS-0001',
                'full_name' => 'Agus Prayogo',
                'display_name' => 'Agus Prayogo (Pro)',
                'whatsapp' => '081211110001',
                'email' => 'agus@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 164.20, // 02:44.20
            ],
            [
                'participant_id' => 'UMS-0002',
                'full_name' => 'Robi Syianturi',
                'display_name' => 'Robi Syianturi',
                'whatsapp' => '081211110002',
                'email' => 'robi@atlet.id',
                'shoe_size' => 43,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 171.50, // 02:51.50
            ],
            [
                'participant_id' => 'UMS-0003',
                'full_name' => 'Triyaningsih',
                'display_name' => 'Triyaningsih (Pro)',
                'whatsapp' => '081211110003',
                'email' => 'triyaningsih@atlet.id',
                'shoe_size' => 38,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 182.10, // 03:02.10
            ],

            // --- KATEGORI KOMUNITAS (Community Runners 1 KM) ---
            // Run by Five
            [
                'participant_id' => 'UMS-0004',
                'full_name' => 'Kevin Sanjaya',
                'display_name' => 'Kevin "The Flash"',
                'whatsapp' => '081211110004',
                'email' => 'kevin@runbyfive.club',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 202.40, // 03:22.40
            ],
            [
                'participant_id' => 'UMS-0005',
                'full_name' => 'Bima Perkasa',
                'display_name' => 'Bima P',
                'whatsapp' => '081211110005',
                'email' => 'bima@runbyfive.club',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 214.10, // 03:34.10
            ],
            [
                'participant_id' => 'UMS-0006',
                'full_name' => 'Nadia Safitri',
                'display_name' => 'Nadia Runner',
                'whatsapp' => '081211110006',
                'email' => 'nadia@runbyfive.club',
                'shoe_size' => 39,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 228.50, // 03:48.50
            ],
            // GBK Night Runners
            [
                'participant_id' => 'UMS-0007',
                'full_name' => 'Rian Kurniawan',
                'display_name' => 'Rian K',
                'whatsapp' => '081211110007',
                'email' => 'rian@gbknight.id',
                'shoe_size' => 41,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 209.80, // 03:29.80
            ],
            [
                'participant_id' => 'UMS-0008',
                'full_name' => 'Fajar Alfian',
                'display_name' => 'Fajar A',
                'whatsapp' => '081211110008',
                'email' => 'fajar@gbknight.id',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 219.40, // 03:39.40
            ],
            [
                'participant_id' => 'UMS-0009',
                'full_name' => 'Siti Rahma',
                'display_name' => 'Rahma S',
                'whatsapp' => '081211110009',
                'email' => 'rahma@gbknight.id',
                'shoe_size' => 38,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 232.30, // 03:52.30
            ],

            // --- KATEGORI UMUM (Individual Runners 1 KM) ---
            [
                'participant_id' => 'UMS-0010',
                'full_name' => 'Hendro Wijaya',
                'display_name' => 'Hendro W',
                'whatsapp' => '081211110010',
                'email' => 'hendro@gmail.com',
                'shoe_size' => 44,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 252.30, // 04:12.30
            ],
            [
                'participant_id' => 'UMS-0011',
                'full_name' => 'Dimas Santoso',
                'display_name' => 'Dimas Runner',
                'whatsapp' => '081211110011',
                'email' => 'dimas@gmail.com',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 262.50, // 04:22.50
            ],
            [
                'participant_id' => 'UMS-0012',
                'full_name' => 'Clara Shinta',
                'display_name' => 'Clara S',
                'whatsapp' => '081211110012',
                'email' => 'clara@gmail.com',
                'shoe_size' => 39,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 275.80, // 04:35.80
            ],
        ];

        foreach ($participantsData as $p) {
            $communityId = isset($p['community_slug']) && isset($communities[$p['community_slug']])
                ? $communities[$p['community_slug']]->id
                : null;

            $participant = Participant::updateOrCreate(
                ['participant_id' => $p['participant_id']],
                [
                    'full_name' => $p['full_name'],
                    'display_name' => $p['display_name'],
                    'whatsapp' => $p['whatsapp'],
                    'email' => $p['email'],
                    'shoe_size' => $p['shoe_size'],
                    'participant_category' => $p['participant_category'],
                    'community_id' => $communityId,
                    'product_interest' => 'Performance',
                    'marketing_consent' => true,
                    'terms_consent' => true,
                    'acquisition_source' => 'QR_GBK',
                ]
            );

            // Create verified 1 KM result
            ChallengeResult::updateOrCreate(
                [
                    'participant_id' => $participant->id,
                    'challenge_id' => $runChallenge->id,
                    'challenge_period_id' => $activePeriod->id,
                ],
                [
                    'checkin_status' => 'CHECKED_IN',
                    'runner_status' => 'FINISHED',
                    'completion_status' => 'COMPLETED',
                    'recorded_time_seconds' => $p['time'],
                    'verified_time_seconds' => $p['time'],
                    'verification_status' => 'VERIFIED',
                    'verified_by' => $adminUser?->id,
                    'recorded_at' => now()->subHours(rand(1, 6)),
                ]
            );
        }

        // 4. Seed active runners (Currently on track running right now)
        $activeRunnersData = [
            [
                'participant_id' => 'UMS-0098',
                'full_name' => 'Fahri Hidayat',
                'display_name' => 'Fahri H',
                'whatsapp' => '081299990098',
                'email' => 'fahri@gmail.com',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
            ],
            [
                'participant_id' => 'UMS-0099',
                'full_name' => 'Dewi Lestari',
                'display_name' => 'Dewi L',
                'whatsapp' => '081299990099',
                'email' => 'dewi.lestari@gmail.com',
                'shoe_size' => 38,
                'participant_category' => 'Komunitas',
            ],
        ];

        foreach ($activeRunnersData as $ar) {
            $runnerPart = Participant::updateOrCreate(
                ['participant_id' => $ar['participant_id']],
                [
                    'full_name' => $ar['full_name'],
                    'display_name' => $ar['display_name'],
                    'whatsapp' => $ar['whatsapp'],
                    'email' => $ar['email'],
                    'shoe_size' => $ar['shoe_size'],
                    'participant_category' => $ar['participant_category'],
                    'product_interest' => 'Performance',
                    'marketing_consent' => true,
                    'terms_consent' => true,
                    'acquisition_source' => 'QR_GBK',
                ]
            );

            ChallengeResult::updateOrCreate(
                [
                    'participant_id' => $runnerPart->id,
                    'challenge_id' => $runChallenge->id,
                    'challenge_period_id' => $activePeriod->id,
                ],
                [
                    'checkin_status' => 'CHECKED_IN',
                    'runner_status' => 'ACTIVE',
                    'completion_status' => 'RUNNING',
                    'recorded_time_seconds' => null,
                    'verified_time_seconds' => null,
                    'verification_status' => 'PENDING',
                    'recorded_at' => now(),
                ]
            );
        }
    }
}

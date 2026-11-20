<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // 2. Challenges: 3 KM Run Challenge
        $runChallenge = Challenge::updateOrCreate(['slug' => 'unerd-run-challenge'], [
            'name' => 'Unerd Time Attack',
            'slug' => 'unerd-run-challenge',
            'challenge_type' => 'RUN',
            'distance_meter' => 3000,
            'location' => 'Gelora Bung Karno, Jakarta',
            'event_date' => '2026-11-21',
            'status' => 'ACTIVE',
            'description' => 'Time attack 3 KM di lintasan resmi. Catat waktu terbaikmu dan puncaki leaderboard!',
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
        $existingActive = ChallengePeriod::where('is_active', true)->first();

        $defaultPeriod = ChallengePeriod::updateOrCreate(['period_code' => 'P1-GBK-20261121'], [
            'challenge_id' => $runChallenge->id,
            'name' => 'Periode 1 — Pilot GBK 21 Nov 2026',
            'location' => 'Gelora Bung Karno, Jakarta',
            'distance_meter' => 3000,
            'duration_minutes' => 60,
            'banner_image' => '/images/campaigns/gbk-track.jpg',
            'period_code' => 'P1-GBK-20261121',
            'event_date' => '2026-11-21',
            'start_time' => '06:00',
            'end_time' => '09:00',
            'is_active' => $existingActive ? false : true,
            'is_open_for_registration' => true,
            'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
        ]);

        ChallengePeriod::updateOrCreate(['period_code' => 'P2-GBK-20261128'], [
            'challenge_id' => $runChallenge->id,
            'name' => 'Periode 2 — GBK Series 28 Nov 2026',
            'location' => 'Gelora Bung Karno, Jakarta',
            'distance_meter' => 3000,
            'duration_minutes' => 60,
            'banner_image' => '/images/campaigns/gbk-track.jpg',
            'period_code' => 'P2-GBK-20261128',
            'event_date' => '2026-11-28',
            'start_time' => '06:00',
            'end_time' => '09:00',
            'is_active' => false,
            'is_open_for_registration' => false,
            'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
        ]);

        // Target periods for seeded results: include all active periods AND default period
        $targetPeriods = ChallengePeriod::where('is_active', true)->get();
        if (! $targetPeriods->contains('id', $defaultPeriod->id)) {
            $targetPeriods->push($defaultPeriod);
        }

        $adminUser = User::first();
        $defaultPassword = Hash::make('password');

        // 3. Realistic Demo Participants with Verified 3 KM Results (60 Runners: 15 Women, 15 Umum, 15 Komunitas, 15 Profesional)
        $participantsData = [
            // ==============================================================
            // --- KATEGORI 1: WOMEN (15 Pelari Wanita) ---
            // ==============================================================
            [
                'participant_id' => 'UMS-W01',
                'full_name' => 'Triyaningsih Santoso',
                'display_name' => 'Triyaningsih',
                'whatsapp' => '081220010001',
                'email' => 'triyaningsih@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 675.40, // 11:15,40
            ],
            [
                'participant_id' => 'UMS-W02',
                'full_name' => 'Odekta Elvina Naibaho',
                'display_name' => 'Odekta E',
                'whatsapp' => '081220010002',
                'email' => 'odekta@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 688.20, // 11:28,20
            ],
            [
                'participant_id' => 'UMS-W03',
                'full_name' => 'Rini Budiarti',
                'display_name' => 'Rini B',
                'whatsapp' => '081220010003',
                'email' => 'rini@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 702.80, // 11:42,80
            ],
            [
                'participant_id' => 'UMS-W04',
                'full_name' => 'Dwi Tiansi Anggraini',
                'display_name' => 'Dwi Tiansi',
                'whatsapp' => '081220010004',
                'email' => 'dwitiansi@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 725.10, // 12:05,10
            ],
            [
                'participant_id' => 'UMS-W05',
                'full_name' => 'Pretty Sihite',
                'display_name' => 'Pretty S',
                'whatsapp' => '081220010005',
                'email' => 'pretty@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 738.50, // 12:18,50
            ],
            [
                'participant_id' => 'UMS-W06',
                'full_name' => 'Westi Indah',
                'display_name' => 'Westi I',
                'whatsapp' => '081220010006',
                'email' => 'westi@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 755.70, // 12:35,70
            ],
            [
                'participant_id' => 'UMS-W07',
                'full_name' => 'Fitri Rahmawati',
                'display_name' => 'Fitri R',
                'whatsapp' => '081220010007',
                'email' => 'fitri@women.unerd.id',
                'shoe_size' => 40,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 774.30, // 12:54,30
            ],
            [
                'participant_id' => 'UMS-W08',
                'full_name' => 'Cynthia Amanda',
                'display_name' => 'Cynthia A',
                'whatsapp' => '081220010008',
                'email' => 'cynthia@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 792.60, // 13:12,60
            ],
            [
                'participant_id' => 'UMS-W09',
                'full_name' => 'Nadia Safitri',
                'display_name' => 'Nadia S',
                'whatsapp' => '081220010009',
                'email' => 'nadias@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 810.20, // 13:30,20
            ],
            [
                'participant_id' => 'UMS-W10',
                'full_name' => 'Maya Anggraini',
                'display_name' => 'Maya A',
                'whatsapp' => '081220010010',
                'email' => 'maya@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 828.90, // 13:48,90
            ],
            [
                'participant_id' => 'UMS-W11',
                'full_name' => 'Jessica Pratama',
                'display_name' => 'Jessica P',
                'whatsapp' => '081220010011',
                'email' => 'jessica@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 850.40, // 14:10,40
            ],
            [
                'participant_id' => 'UMS-W12',
                'full_name' => 'Sarah Wulandari',
                'display_name' => 'Sarah W',
                'whatsapp' => '081220010012',
                'email' => 'sarah@women.unerd.id',
                'shoe_size' => 40,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 872.10, // 14:32,10
            ],
            [
                'participant_id' => 'UMS-W13',
                'full_name' => 'Gita Prameswari',
                'display_name' => 'Gita P',
                'whatsapp' => '081220010013',
                'email' => 'gita@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 895.80, // 14:55,80
            ],
            [
                'participant_id' => 'UMS-W14',
                'full_name' => 'Vanessa Kirana',
                'display_name' => 'Vanessa K',
                'whatsapp' => '081220010014',
                'email' => 'vanessa@women.unerd.id',
                'shoe_size' => 38,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 920.50, // 15:20,50
            ],
            [
                'participant_id' => 'UMS-W15',
                'full_name' => 'Karina Salsabila',
                'display_name' => 'Karina S',
                'whatsapp' => '081220010015',
                'email' => 'karina@women.unerd.id',
                'shoe_size' => 39,
                'participant_category' => 'Women',
                'community_slug' => null,
                'time' => 945.20, // 15:45,20
            ],

            // ==============================================================
            // --- KATEGORI 2: UMUM (15 Pelari Individu Mandiri) ---
            // ==============================================================
            [
                'participant_id' => 'UMS-U01',
                'full_name' => 'Hendro Wijaya',
                'display_name' => 'Hendro W',
                'whatsapp' => '081230010001',
                'email' => 'hendro@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 725.80, // 12:05,80
            ],
            [
                'participant_id' => 'UMS-U02',
                'full_name' => 'Dimas Santoso',
                'display_name' => 'Dimas S',
                'whatsapp' => '081230010002',
                'email' => 'dimas@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 742.40, // 12:22,40
            ],
            [
                'participant_id' => 'UMS-U03',
                'full_name' => 'Aditya Pratama',
                'display_name' => 'Adit P',
                'whatsapp' => '081230010003',
                'email' => 'aditya@runner.unerd.id',
                'shoe_size' => 43,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 758.90, // 12:38,90
            ],
            [
                'participant_id' => 'UMS-U04',
                'full_name' => 'Bayu Setiawan',
                'display_name' => 'Bayu S',
                'whatsapp' => '081230010004',
                'email' => 'bayu@runner.unerd.id',
                'shoe_size' => 41,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 775.20, // 12:55,20
            ],
            [
                'participant_id' => 'UMS-U05',
                'full_name' => 'Christian Wicaksono',
                'display_name' => 'Tian W',
                'whatsapp' => '081230010005',
                'email' => 'christian@runner.unerd.id',
                'shoe_size' => 44,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 794.60, // 13:14,60
            ],
            [
                'participant_id' => 'UMS-U06',
                'full_name' => 'David Gunawan',
                'display_name' => 'David G',
                'whatsapp' => '081230010006',
                'email' => 'david@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 812.10, // 13:32,10
            ],
            [
                'participant_id' => 'UMS-U07',
                'full_name' => 'Eko Prasetyo',
                'display_name' => 'Eko P',
                'whatsapp' => '081230010007',
                'email' => 'eko@runner.unerd.id',
                'shoe_size' => 43,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 831.50, // 13:51,50
            ],
            [
                'participant_id' => 'UMS-U08',
                'full_name' => 'Farhan Ramadhan',
                'display_name' => 'Farhan R',
                'whatsapp' => '081230010008',
                'email' => 'farhan@runner.unerd.id',
                'shoe_size' => 41,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 852.80, // 14:12,80
            ],
            [
                'participant_id' => 'UMS-U09',
                'full_name' => 'Gilang Anugrah',
                'display_name' => 'Gilang A',
                'whatsapp' => '081230010009',
                'email' => 'gilang@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 875.30, // 14:35,30
            ],
            [
                'participant_id' => 'UMS-U10',
                'full_name' => 'Hidayat Arifin',
                'display_name' => 'Hidayat A',
                'whatsapp' => '081230010010',
                'email' => 'hidayat@runner.unerd.id',
                'shoe_size' => 43,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 898.70, // 14:58,70
            ],
            [
                'participant_id' => 'UMS-U11',
                'full_name' => 'Indra Kusuma',
                'display_name' => 'Indra K',
                'whatsapp' => '081230010011',
                'email' => 'indra@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 922.20, // 15:22,20
            ],
            [
                'participant_id' => 'UMS-U12',
                'full_name' => 'Joko Susilo',
                'display_name' => 'Joko S',
                'whatsapp' => '081230010012',
                'email' => 'joko@runner.unerd.id',
                'shoe_size' => 44,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 946.90, // 15:46,90
            ],
            [
                'participant_id' => 'UMS-U13',
                'full_name' => 'Kevin Andrea',
                'display_name' => 'Kevin A',
                'whatsapp' => '081230010013',
                'email' => 'kevin.andrea@runner.unerd.id',
                'shoe_size' => 41,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 975.40, // 16:15,40
            ],
            [
                'participant_id' => 'UMS-U14',
                'full_name' => 'Lukman Hakim',
                'display_name' => 'Lukman H',
                'whatsapp' => '081230010014',
                'email' => 'lukman@runner.unerd.id',
                'shoe_size' => 42,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 1004.80, // 16:44,80
            ],
            [
                'participant_id' => 'UMS-U15',
                'full_name' => 'Maulana Malik',
                'display_name' => 'Malik M',
                'whatsapp' => '081230010015',
                'email' => 'malik@runner.unerd.id',
                'shoe_size' => 43,
                'participant_category' => 'Umum',
                'community_slug' => null,
                'time' => 1035.60, // 17:15,60
            ],

            // ==============================================================
            // --- KATEGORI 3: KOMUNITAS (15 Pelari Afiliasi Klub Mitra) ---
            // ==============================================================
            // Run by Five (4 Pelari)
            [
                'participant_id' => 'UMS-C01',
                'full_name' => 'Kevin Sanjaya',
                'display_name' => 'Kevin "Speed"',
                'whatsapp' => '081240010001',
                'email' => 'kevin@runbyfive.club',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 612.30, // 10:12,30
            ],
            [
                'participant_id' => 'UMS-C02',
                'full_name' => 'Bima Perkasa',
                'display_name' => 'Bima P',
                'whatsapp' => '081240010002',
                'email' => 'bima@runbyfive.club',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 628.50, // 10:28,50
            ],
            [
                'participant_id' => 'UMS-C03',
                'full_name' => 'Reza Pahlevi',
                'display_name' => 'Reza P',
                'whatsapp' => '081240010003',
                'email' => 'reza@runbyfive.club',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 645.10, // 10:45,10
            ],
            [
                'participant_id' => 'UMS-C04',
                'full_name' => 'Rio Dewanto',
                'display_name' => 'Rio D',
                'whatsapp' => '081240010004',
                'email' => 'rio@runbyfive.club',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'run-by-five',
                'time' => 662.80, // 11:02,80
            ],
            // GBK Night Runners (4 Pelari)
            [
                'participant_id' => 'UMS-C05',
                'full_name' => 'Rian Kurniawan',
                'display_name' => 'Rian K',
                'whatsapp' => '081240010005',
                'email' => 'rian@gbknight.id',
                'shoe_size' => 41,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 635.40, // 10:35,40
            ],
            [
                'participant_id' => 'UMS-C06',
                'full_name' => 'Fajar Alfian',
                'display_name' => 'Fajar A',
                'whatsapp' => '081240010006',
                'email' => 'fajar@gbknight.id',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 652.90, // 10:52,90
            ],
            [
                'participant_id' => 'UMS-C07',
                'full_name' => 'Dimas Danang',
                'display_name' => 'Danang D',
                'whatsapp' => '081240010007',
                'email' => 'danang@gbknight.id',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 675.20, // 11:15,20
            ],
            [
                'participant_id' => 'UMS-C08',
                'full_name' => 'Surya Insomnia',
                'display_name' => 'Surya I',
                'whatsapp' => '081240010008',
                'email' => 'surya@gbknight.id',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'gbk-night-runners',
                'time' => 698.60, // 11:38,60
            ],
            // SCBD Morning Crew (4 Pelari)
            [
                'participant_id' => 'UMS-C09',
                'full_name' => 'Denny Sumargo',
                'display_name' => 'Densu',
                'whatsapp' => '081240010009',
                'email' => 'densu@scbdcrew.id',
                'shoe_size' => 44,
                'participant_category' => 'Komunitas',
                'community_slug' => 'scbd-morning-crew',
                'time' => 648.70, // 10:48,70
            ],
            [
                'participant_id' => 'UMS-C10',
                'full_name' => 'Raffi Ahmad',
                'display_name' => 'Raffi A',
                'whatsapp' => '081240010010',
                'email' => 'raffi@scbdcrew.id',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'scbd-morning-crew',
                'time' => 668.40, // 11:08,40
            ],
            [
                'participant_id' => 'UMS-C11',
                'full_name' => 'Desta Mahendra',
                'display_name' => 'Desta M',
                'whatsapp' => '081240010011',
                'email' => 'desta@scbdcrew.id',
                'shoe_size' => 41,
                'participant_category' => 'Komunitas',
                'community_slug' => 'scbd-morning-crew',
                'time' => 689.20, // 11:29,20
            ],
            [
                'participant_id' => 'UMS-C12',
                'full_name' => 'Vincent Rompies',
                'display_name' => 'Vincent R',
                'whatsapp' => '081240010012',
                'email' => 'vincent@scbdcrew.id',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'scbd-morning-crew',
                'time' => 712.50, // 11:52,50
            ],
            // Bandung Striders (3 Pelari)
            [
                'participant_id' => 'UMS-C13',
                'full_name' => 'Taufik Hidayat',
                'display_name' => 'Taufik H',
                'whatsapp' => '081240010013',
                'email' => 'taufik@bandungstriders.id',
                'shoe_size' => 42,
                'participant_category' => 'Komunitas',
                'community_slug' => 'bandung-striders',
                'time' => 658.60, // 10:58,60
            ],
            [
                'participant_id' => 'UMS-C14',
                'full_name' => 'Ariel Nazril',
                'display_name' => 'Ariel N',
                'whatsapp' => '081240010014',
                'email' => 'ariel@bandungstriders.id',
                'shoe_size' => 41,
                'participant_category' => 'Komunitas',
                'community_slug' => 'bandung-striders',
                'time' => 682.30, // 11:22,30
            ],
            [
                'participant_id' => 'UMS-C15',
                'full_name' => 'Gading Marten',
                'display_name' => 'Gading M',
                'whatsapp' => '081240010015',
                'email' => 'gading@bandungstriders.id',
                'shoe_size' => 43,
                'participant_category' => 'Komunitas',
                'community_slug' => 'bandung-striders',
                'time' => 705.90, // 11:45,90
            ],

            // ==============================================================
            // --- KATEGORI 4: PROFESIONAL (15 Pelari Atlet / Pro) ---
            // ==============================================================
            [
                'participant_id' => 'UMS-P01',
                'full_name' => 'Agus Prayogo',
                'display_name' => 'Agus P',
                'whatsapp' => '081250010001',
                'email' => 'agus@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 515.20, // 08:35,20
            ],
            [
                'participant_id' => 'UMS-P02',
                'full_name' => 'Robi Syianturi',
                'display_name' => 'Robi S',
                'whatsapp' => '081250010002',
                'email' => 'robi@atlet.id',
                'shoe_size' => 43,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 528.50, // 08:48,50
            ],
            [
                'participant_id' => 'UMS-P03',
                'full_name' => 'Rikki Marthin Simbolon',
                'display_name' => 'Rikki S',
                'whatsapp' => '081250010003',
                'email' => 'rikki@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 539.10, // 08:59,10
            ],
            [
                'participant_id' => 'UMS-P04',
                'full_name' => 'Atjong Tio Purwanto',
                'display_name' => 'Atjong T',
                'whatsapp' => '081250010004',
                'email' => 'atjong@atlet.id',
                'shoe_size' => 41,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 552.40, // 09:12,40
            ],
            [
                'participant_id' => 'UMS-P05',
                'full_name' => 'Welman Pasaribu',
                'display_name' => 'Welman P',
                'whatsapp' => '081250010005',
                'email' => 'welman@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 564.80, // 09:24,80
            ],
            [
                'participant_id' => 'UMS-P06',
                'full_name' => 'Hamdan Sayuti',
                'display_name' => 'Hamdan S',
                'whatsapp' => '081250010006',
                'email' => 'hamdan@atlet.id',
                'shoe_size' => 43,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 576.20, // 09:36,20
            ],
            [
                'participant_id' => 'UMS-P07',
                'full_name' => 'Betmen Manurung',
                'display_name' => 'Betmen M',
                'whatsapp' => '081250010007',
                'email' => 'betmen@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 587.60, // 09:47,60
            ],
            [
                'participant_id' => 'UMS-P08',
                'full_name' => 'Hendro Yap',
                'display_name' => 'Hendro Y',
                'whatsapp' => '081250010008',
                'email' => 'hendroyap@atlet.id',
                'shoe_size' => 41,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 598.90, // 09:58,90
            ],
            [
                'participant_id' => 'UMS-P09',
                'full_name' => 'Jauhari Johan',
                'display_name' => 'Jauhari J',
                'whatsapp' => '081250010009',
                'email' => 'jauhari@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 611.30, // 10:11,30
            ],
            [
                'participant_id' => 'UMS-P10',
                'full_name' => 'Marwan Pulungan',
                'display_name' => 'Marwan P',
                'whatsapp' => '081250010010',
                'email' => 'marwan@atlet.id',
                'shoe_size' => 43,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 622.70, // 10:22,70
            ],
            [
                'participant_id' => 'UMS-P11',
                'full_name' => 'Guntur Wijaya',
                'display_name' => 'Guntur W',
                'whatsapp' => '081250010011',
                'email' => 'guntur@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 634.50, // 10:34,50
            ],
            [
                'participant_id' => 'UMS-P12',
                'full_name' => 'Syamsuddin Massa',
                'display_name' => 'Syamsuddin M',
                'whatsapp' => '081250010012',
                'email' => 'syamsuddin@atlet.id',
                'shoe_size' => 41,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 646.20, // 10:46,20
            ],
            [
                'participant_id' => 'UMS-P13',
                'full_name' => 'Nurshodiq',
                'display_name' => 'Nurshodiq',
                'whatsapp' => '081250010013',
                'email' => 'nurshodiq@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 658.10, // 10:58,10
            ],
            [
                'participant_id' => 'UMS-P14',
                'full_name' => 'Rudi Febriade',
                'display_name' => 'Rudi F',
                'whatsapp' => '081250010014',
                'email' => 'rudi@atlet.id',
                'shoe_size' => 43,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 670.40, // 11:10,40
            ],
            [
                'participant_id' => 'UMS-P15',
                'full_name' => 'Asmara Bara',
                'display_name' => 'Asmara B',
                'whatsapp' => '081250010015',
                'email' => 'asmara@atlet.id',
                'shoe_size' => 42,
                'participant_category' => 'Profesional',
                'community_slug' => null,
                'time' => 682.80, // 11:22,80
            ],
        ];

        foreach ($participantsData as $p) {
            $communityId = isset($p['community_slug']) && isset($communities[$p['community_slug']])
                ? $communities[$p['community_slug']]->id
                : null;

            $roleSlug = match ($p['participant_category']) {
                'Women' => 'women',
                'Komunitas' => 'komunitas',
                'Profesional' => 'profesional',
                default => 'umum',
            };

            $role = Role::firstOrCreate(
                ['slug' => $roleSlug],
                ['name' => $p['participant_category'], 'is_system_reserved' => true]
            );

            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['full_name'],
                    'phone_number' => $p['whatsapp'],
                    'shoe_size' => $p['shoe_size'],
                    'role_id' => $role->id,
                    'community_id' => $communityId,
                    'password' => $defaultPassword,
                    'is_blocked' => false,
                ]
            );

            $roleSlug = match ($p['participant_category']) {
                'Women' => 'women',
                'Komunitas' => 'komunitas',
                'Profesional' => 'profesional',
                default => 'umum',
            };

            $role = Role::firstOrCreate(
                ['slug' => $roleSlug],
                ['name' => $p['participant_category'], 'is_system_reserved' => true]
            );

            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['full_name'],
                    'phone_number' => $p['whatsapp'],
                    'shoe_size' => $p['shoe_size'],
                    'role_id' => $role->id,
                    'community_id' => $communityId,
                    'password' => $defaultPassword,
                    'is_blocked' => false,
                ]
            );

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

            // Create verified 3 KM result across target periods (including current active period)
            foreach ($targetPeriods as $tPeriod) {
                ChallengeResult::updateOrCreate(
                    [
                        'participant_id' => $participant->id,
                        'challenge_id' => $runChallenge->id,
                        'challenge_period_id' => $tPeriod->id,
                    ],
                    [
                        'user_id' => $user->id,
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

        foreach ($targetPeriods as $tPeriod) {
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
                        'challenge_period_id' => $tPeriod->id,
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

            // Recalculate rank for all finished participants in this period
            $tPeriod->recalculateRanks();
        }
    }
}

<?php

use App\Livewire\EventOperations;
use App\Livewire\Leaderboard;
use App\Livewire\RunnerLiveStatus;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    // Seed initial roles and active challenge
    Role::firstOrCreate(['slug' => 'administrator'], ['name' => 'Administrator', 'description' => 'System admin']);
    Role::firstOrCreate(['slug' => 'field-sales'], ['name' => 'Field Sales', 'description' => 'Field crew']);
    Role::firstOrCreate(['slug' => 'umum'], ['name' => 'Umum', 'description' => 'Pelari Umum']);
    Role::firstOrCreate(['slug' => 'komunitas'], ['name' => 'Komunitas', 'description' => 'Pelari Komunitas']);
    Role::firstOrCreate(['slug' => 'profesional'], ['name' => 'Profesional', 'description' => 'Pelari Profesional']);

    $challenge = Challenge::firstOrCreate(
        ['slug' => 'run-challenge-gbk'],
        [
            'name' => 'UNERD Move Series: 1 KM Run Challenge',
            'challenge_type' => 'RUN',
            'status' => 'ACTIVE',
            'location' => 'Gelora Bung Karno, Jakarta',
            'distance_meter' => 1000,
            'event_date' => '2026-11-21',
            'description' => 'Sprint 1 KM di GBK Senayan.',
        ]
    );

    ChallengePeriod::firstOrCreate(
        ['period_code' => 'P1-GBK-20261121'],
        [
            'challenge_id' => $challenge->id,
            'name' => 'Periode 1 — Pilot GBK 21 Nov 2026',
            'event_date' => '2026-11-21',
            'is_active' => true,
            'is_open_for_registration' => true,
            'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
        ]
    );

    Community::firstOrCreate(
        ['slug' => 'run-by-five'],
        [
            'name' => 'Run by Five',
            'city' => 'Jakarta',
            'description' => 'Running community in South Jakarta',
        ]
    );
});

test('public homepage displays everyday league activation', function () {
    $response = $this->get(route('everyday-league.index'));

    $response->assertStatus(200);
    $response->assertSee('EVERY WEEK');
    $response->assertSee('COUNTS');
    $response->assertSee('UNERD Move Series');
});

test('guest is redirected to login when accessing challenge selection page', function () {
    $response = $this->get(route('everyday-league.register'));

    $response->assertRedirect(route('login'));
});

test('authenticated runner can view challenge selection page with prefilled profile', function () {
    $umumRole = Role::firstOrCreate(['slug' => 'umum'], ['name' => 'Umum', 'description' => 'Pelari Umum']);
    $user = User::factory()->create([
        'name' => 'Dimas Pratama',
        'email' => 'dimas@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 42,
    ]);

    $response = $this->actingAs($user)->get(route('everyday-league.register'));

    $response->assertStatus(200);
    $response->assertSee('Dimas Pratama');
    $response->assertSee('EU 42');
});

test('authenticated runner can join challenge without re-entering personal data', function () {
    $komunitasRole = Role::firstOrCreate(['slug' => 'komunitas'], ['name' => 'Komunitas', 'description' => 'Pelari Komunitas']);
    $community = Community::first();

    $user = User::factory()->create([
        'name' => 'Reza Pahlevi',
        'email' => 'reza@example.com',
        'phone_number' => '081299998888',
        'role_id' => $komunitasRole->id,
        'shoe_size' => 43,
    ]);

    $response = $this->actingAs($user)->post(route('everyday-league.store'), [
        'challenge_slug' => 'run-challenge-gbk',
        'community_id' => $community->id,
        'product_interest' => 'Performance',
        'terms_consent' => '1',
    ]);

    $participant = Participant::where('email', 'reza@example.com')->first();

    expect($participant)->not->toBeNull();
    expect($participant->participant_id)->toStartWith('UMS-');
    expect($participant->full_name)->toBe('Reza Pahlevi');
    expect($participant->shoe_size)->toBe(43);
    expect($participant->participant_category)->toBe('Komunitas');
    expect($participant->community_id)->toBe($community->id);

    $response->assertRedirect(route('everyday-league.success', $participant->participant_id));
});

test('runner can view registration success page and digital  card', function () {
    $participant = Participant::create([
        'participant_id' => 'UMS-9901',
        'full_name' => 'Siti Rahma',
        'display_name' => 'Siti R',
        'whatsapp' => '081211112222',
        'email' => 'siti@example.com',
        'shoe_size' => 39,
        'participant_category' => 'Umum',
        'product_interest' => 'Performance',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $response = $this->get(route('everyday-league.success', $participant->participant_id));

    $response->assertStatus(200);
    $response->assertSee('UMS-9901');
    $response->assertSee('Siti R');
    $response->assertSee('EU 39');
});

test('leaderboard displays livewire component with role tabs', function () {
    $response = $this->get(route('everyday-league.leaderboard'));
    $response->assertStatus(200);
    $response->assertSee('Leaderboard');
    $response->assertSee('Pelari Umum');
    $response->assertSee('Pelari Komunitas');
    $response->assertSee('Pelari Profesional');
});

test('admin can access event crew operations and check in runner', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $adminUser = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $participant = Participant::create([
        'participant_id' => 'UMS-9902',
        'full_name' => 'Andi Wijaya',
        'display_name' => 'Andi W',
        'whatsapp' => '081233334444',
        'email' => 'andi@example.com',
        'shoe_size' => 43,
        'participant_category' => 'Pekerja',
        'product_interest' => 'Lifestyle',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $response = $this->actingAs($adminUser)->get(route('admin.event.index'));
    $response->assertStatus(200);
    $response->assertSee('Operasional Event GBK');

    // Check-in action
    $checkInResponse = $this->actingAs($adminUser)->post(route('admin.event.check-in', $participant));
    $checkInResponse->assertRedirect();

    $checkedInResult = $participant->results()->first();
    expect($checkedInResult)->not->toBeNull();
    expect($checkedInResult->checkin_status)->toBe('CHECKED_IN');

    // Record time action (01:24.50)
    $recordTimeResponse = $this->actingAs($adminUser)->post(route('admin.event.record-time', $participant), [
        'time_input' => '01:24.50',
    ]);
    $recordTimeResponse->assertRedirect();

    $result = $participant->results()->first();
    expect($result)->not->toBeNull();
    expect((float) $result->verified_time_seconds)->toBe(84.5);
    expect($result->verification_status)->toBe('VERIFIED');
});

test('runner can view result page with verified time and voucher discount', function () {
    $participant = Participant::create([
        'participant_id' => 'UMS-9903',
        'full_name' => 'Fajar Nugraha',
        'display_name' => 'Fajar N',
        'whatsapp' => '081244445555',
        'email' => 'fajar@example.com',
        'shoe_size' => 42,
        'participant_category' => 'Umum',
        'product_interest' => 'Performance',
        'terms_consent' => true,
    ]);

    $challenge = Challenge::first();

    $participant->results()->create([
        'challenge_id' => $challenge->id,
        'checkin_status' => 'CHECKED_IN',
        'completion_status' => 'COMPLETED',
        'recorded_time_seconds' => 88.2,
        'verified_time_seconds' => 88.2,
        'verification_status' => 'VERIFIED',
    ]);

    $response = $this->get(route('everyday-league.result', $participant->participant_id));

    $response->assertStatus(200);
    $response->assertSee('UMS-9903');
    $response->assertSee('Fajar N');
    $response->assertSee('01:28,20');
    $response->assertSee('MOVE-CHAMPION-10%');
    $response->assertSee('EU 42');
});

test('runner clicking product recommendation tracks event and redirects to store', function () {
    $participant = Participant::create([
        'participant_id' => 'UMS-9904',
        'full_name' => 'Rian Kurnia',
        'display_name' => 'Rian K',
        'whatsapp' => '081255556666',
        'email' => 'rian@example.com',
        'shoe_size' => 41,
        'participant_category' => 'Pekerja',
        'product_interest' => 'Lifestyle',
        'terms_consent' => true,
    ]);

    $response = $this->get(route('everyday-league.track-product', [
        'participant' => $participant->participant_id,
        'product' => 'astral-speed',
    ]));

    $response->assertRedirect('https://unerd.com/products/astral-speed?promo=MOVE-CHAMPION-10%25&size=41');

    $this->assertDatabaseHas('activity_events', [
        'event_type' => 'product_click',
        'participant_id' => $participant->id,
    ]);
});

test('livewire leaderboard component can switch role tabs and poll realtime', function () {
    Livewire::test(Leaderboard::class)
        ->assertStatus(200)
        ->assertSet('activeRoleTab', 'Umum')
        ->assertSee('Pelari Umum')
        ->assertSee('Pelari Komunitas')
        ->assertSee('Pelari Profesional')
        ->call('setRoleTab', 'Komunitas')
        ->assertSet('activeRoleTab', 'Komunitas')
        ->call('setRoleTab', 'Profesional')
        ->assertSet('activeRoleTab', 'Profesional');
});

test('livewire leaderboard component can select period and search runners directly', function () {
    $period = ChallengePeriod::first();

    Livewire::test(Leaderboard::class)
        ->assertStatus(200)
        ->assertSet('selectedPeriodId', $period->id)
        ->call('selectPeriod', $period->id)
        ->assertSet('selectedPeriodId', $period->id)
        ->set('search', 'UMS-0001')
        ->assertSet('search', 'UMS-0001');
});

test('user can register with shoe size and runner role', function () {
    $response = $this->post('/register', [
        'name' => 'Bayu Pratama',
        'email' => 'bayu.runner@example.com',
        'shoe_size' => 43,
        'role_slug' => 'profesional',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $user = User::where('email', 'bayu.runner@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->shoe_size)->toBe(43);
    expect($user->role->slug)->toBe('profesional');
});

test('challenge result parses time accurately for pure digits, comma and colon formats', function () {
    // 6 digits pure numbers: 032450 -> 03:24,50 (204.5s)
    expect(ChallengeResult::parseTimeToSeconds('032450'))->toBe(204.5);
    expect(ChallengeResult::formatSecondsToIndonesian(204.5))->toBe('03:24,50');

    // 5 digits pure numbers: 32450 -> 03:24,50 (204.5s)
    expect(ChallengeResult::parseTimeToSeconds('32450'))->toBe(204.5);

    // 6 digits: 012450 -> 01:24,50 (84.5s)
    expect(ChallengeResult::parseTimeToSeconds('012450'))->toBe(84.5);
    expect(ChallengeResult::formatSecondsToIndonesian(84.5))->toBe('01:24,50');

    // 4 digits: 8450 -> 84.50s (01:24,50)
    expect(ChallengeResult::parseTimeToSeconds('8450'))->toBe(84.5);

    // 4 digits: 0324 -> 3 min 24 sec (204s)
    expect(ChallengeResult::parseTimeToSeconds('0324'))->toBe(204.0);

    // Indonesian comma format: 03:24,50
    expect(ChallengeResult::parseTimeToSeconds('03:24,50'))->toBe(204.5);

    // Indonesian seconds comma: 84,50
    expect(ChallengeResult::parseTimeToSeconds('84,50'))->toBe(84.5);

    // Standard colon dot: 01:24.50
    expect(ChallengeResult::parseTimeToSeconds('01:24.50'))->toBe(84.5);
});

test('admin can record time using pure numeric input without colons or commas', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $adminUser = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $participant = Participant::create([
        'participant_id' => 'UMS-7701',
        'full_name' => 'Teguh Saputra',
        'display_name' => 'Teguh S',
        'whatsapp' => '081277778888',
        'email' => 'teguh@example.com',
        'shoe_size' => 42,
        'participant_category' => 'Umum',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    // Submit pure digits '032450' (no colons, no commas)
    $response = $this->actingAs($adminUser)->post(route('admin.event.record-time', $participant), [
        'time_input' => '032450',
    ]);

    $response->assertRedirect();

    $result = $participant->results()->first();
    expect($result)->not->toBeNull();
    expect((float) $result->verified_time_seconds)->toBe(204.5);
    expect($result->formattedTime())->toBe('03:24,50');
});

test('livewire event operations component supports instant live search and fast stopwatch timing', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $adminUser = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $period = ChallengePeriod::where('is_active', true)->first();
    $challenge = Challenge::first();

    $participant = Participant::create([
        'participant_id' => 'UMS-8801',
        'full_name' => 'Budi Santoso',
        'display_name' => 'Budi S',
        'whatsapp' => '081288889999',
        'email' => 'budi.santoso@example.com',
        'shoe_size' => 43,
        'participant_category' => 'Profesional',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $participant->results()->create([
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'ACTIVE',
        'completion_status' => 'RUNNING',
    ]);

    Livewire::actingAs($adminUser)
        ->test(EventOperations::class)
        ->assertStatus(200)
        ->assertSee('UMS-8801')
        ->assertSee('Budi Santoso')
        // Live search without Enter
        ->set('search', 'UMS-8801')
        ->assertSee('Budi Santoso')
        ->set('search', 'NonExistentParticipant')
        ->assertSee('Tidak ada data peserta yang cocok')
        ->set('search', '')
        // Test check-in
        ->call('checkIn', $participant->id)
        ->assertSee('berhasil di-check-in')
        // Test timing modal with pure digits
        ->call('openTimeModal', $participant->id)
        ->assertSet('showTimeModal', true)
        ->set('timeInput', '032450')
        ->assertSet('timePreview', '03:24,50')
        ->call('saveTime')
        ->assertSet('showTimeModal', false)
        ->assertSee('03:24,50');

    $savedResult = $participant->results()->first();
    expect($savedResult)->not->toBeNull();
    expect((float) $savedResult->verified_time_seconds)->toBe(204.5);
    expect($savedResult->formattedTime())->toBe('03:24,50');
});

test('runner can register online for challenge and admin activates run on site', function () {
    $umumRole = Role::where('slug', 'umum')->first();
    $user = User::factory()->create([
        'name' => 'Adit Nugroho',
        'email' => 'adit@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 42,
    ]);

    $response = $this->actingAs($user)->post(route('everyday-league.store'), [
        'product_interest' => 'Performance',
    ]);

    $response->assertRedirect();

    $participant = Participant::where('email', 'adit@example.com')->first();
    expect($participant)->not->toBeNull();

    $result = $participant->results()->first();
    expect($result)->not->toBeNull();
    expect($result->runner_status)->toBe('REGISTERED');
    expect($result->isPendingCheckin())->toBeTrue();

    // Admin / Crew activates runner on-site at GBK
    $admin = User::factory()->create(['role_id' => Role::where('slug', 'administrator')->first()->id]);
    Livewire::actingAs($admin)
        ->test(EventOperations::class)
        ->call('checkIn', $participant->id);

    $result->refresh();
    expect($result->runner_status)->toBe('ACTIVE');
    expect($result->completion_status)->toBe('RUNNING');
    expect($result->isRunning())->toBeTrue();
});

test('runner cannot join challenge when registration is closed by admin', function () {
    $activePeriod = ChallengePeriod::where('is_active', true)->first();
    $activePeriod->update(['is_open_for_registration' => false]);

    $umumRole = Role::where('slug', 'umum')->first();
    $user = User::factory()->create([
        'name' => 'Kiki Pratama',
        'email' => 'kiki@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 41,
    ]);

    $response = $this->actingAs($user)->post(route('everyday-league.store'), [
        'product_interest' => 'Performance',
    ]);

    $response->assertSessionHasErrors(['period']);

    // Re-open for following tests
    $activePeriod->update(['is_open_for_registration' => true]);
});

test('runner in same period does not create duplicate record but replaces previous attempt', function () {
    $activePeriod = ChallengePeriod::where('is_active', true)->first();
    $challenge = Challenge::first();

    $umumRole = Role::where('slug', 'umum')->first();
    $user = User::factory()->create([
        'name' => 'Gita Savitri',
        'email' => 'gita@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 38,
    ]);

    $participant = Participant::create([
        'participant_id' => 'UMS-5501',
        'full_name' => 'Gita Savitri',
        'display_name' => 'Gita S',
        'whatsapp' => '081255554444',
        'email' => 'gita@example.com',
        'shoe_size' => 38,
        'participant_category' => 'Umum',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $initialResult = $participant->results()->create([
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $activePeriod->id,
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'FINISHED',
        'completion_status' => 'COMPLETED',
        'verified_time_seconds' => 300.0,
        'verification_status' => 'VERIFIED',
    ]);

    // Re-attempting via registration in same period: should redirect to dashboard and prevent starting run without resetting
    $response = $this->actingAs($user)->post(route('everyday-league.store'), [
        'product_interest' => 'Performance',
    ]);

    $response->assertRedirect(route('customer.dashboard'));

    // Confirm only 1 result exists in this period
    $totalResults = $participant->results()->where('challenge_period_id', $activePeriod->id)->count();
    expect($totalResults)->toBe(1);

    // Now test resetting explicitly from runner dashboard via Livewire component
    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->call('restartRunInPeriod');

    $reloadedResult = $participant->results()->where('challenge_period_id', $activePeriod->id)->first();
    expect($reloadedResult->runner_status)->toBe('ACTIVE');
    expect($reloadedResult->verified_time_seconds)->toBeNull();
});

test('livewire runner live status updates and shows verified result, rank, and top 10 prize', function () {
    $activePeriod = ChallengePeriod::where('is_active', true)->first();
    $challenge = Challenge::first();

    $umumRole = Role::where('slug', 'umum')->first();
    $user = User::factory()->create([
        'name' => 'Hendro Salim',
        'email' => 'hendro@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 42,
    ]);

    $participant = Participant::create([
        'participant_id' => 'UMS-6601',
        'full_name' => 'Hendro Salim',
        'display_name' => 'Hendro S',
        'whatsapp' => '081266667777',
        'email' => 'hendro@example.com',
        'shoe_size' => 42,
        'participant_category' => 'Umum',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    // Currently running
    $participant->results()->create([
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $activePeriod->id,
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'ACTIVE',
        'completion_status' => 'RUNNING',
    ]);

    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->assertStatus(200)
        ->assertSee('SILAKAN MULAI LARI!');

    // Kru finishes runner with 1st place time (03:15,00 = 195s)
    $result = $participant->results()->first();
    $result->update([
        'runner_status' => 'FINISHED',
        'completion_status' => 'COMPLETED',
        'verified_time_seconds' => 195.0,
        'verification_status' => 'VERIFIED',
    ]);
    $activePeriod->recalculateRanks();

    // Runner live dashboard immediately reflects completion and rank 1 shoe prize
    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->assertStatus(200)
        ->assertSee('SELESAI LARI (FINISHER)')
        ->assertSee('03:15,00')
        ->assertSee('HADIAH  TOP 10');
});

test('admin can export csv filtered by period and export user directory csv', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $adminUser = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $period = ChallengePeriod::where('is_active', true)->first();

    $responsePeriod = $this->actingAs($adminUser)->get(route('admin.event.export-csv', ['period_id' => $period->id]));
    $responsePeriod->assertStatus(200);
    $responsePeriod->assertHeader('content-type', 'text/csv; charset=UTF-8');

    $responseUsers = $this->actingAs($adminUser)->get(route('admin.event.export-users-csv'));
    $responseUsers->assertStatus(200);
    $responseUsers->assertHeader('content-type', 'text/csv; charset=UTF-8');
});

test('admin can manage challenge periods CRUD and search periods via livewire event operations', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $adminUser = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $component = Livewire::actingAs($adminUser)
        ->test(EventOperations::class)
        ->call('openManagePeriodModal')
        ->set('periodFormName', 'Periode 2 — GBK Night Sprint')
        ->set('periodFormCode', 'PERIODE-2026-11-28')
        ->set('periodFormDate', '2026-11-28')
        ->set('periodFormIsActive', true)
        ->set('periodFormIsOpen', true)
        ->call('savePeriod')
        ->assertHasNoErrors();

    $newPeriod = ChallengePeriod::where('period_code', 'PERIODE-2026-11-28')->first();
    expect($newPeriod)->not->toBeNull();
    expect($newPeriod->name)->toBe('Periode 2 — GBK Night Sprint');
    expect($newPeriod->is_active)->toBeTrue();

    // Test Search period
    $component->set('periodSearch', 'Night Sprint')
        ->assertSee('Periode 2 — GBK Night Sprint');

    // Test Edit period
    $component->call('editPeriod', $newPeriod->id)
        ->set('periodFormName', 'Periode 2 — GBK Updated')
        ->call('savePeriod');

    expect($newPeriod->fresh()->name)->toBe('Periode 2 — GBK Updated');

    // Test setActivePeriod and togglePeriodActive (can deactivate all events)
    $component->call('setActivePeriod', $newPeriod->id);
    expect($newPeriod->fresh()->is_active)->toBeFalse(); // Toggled off because it was already active

    $component->call('setActivePeriod', $newPeriod->id);
    expect($newPeriod->fresh()->is_active)->toBeTrue(); // Toggled back on

    $component->call('deactivateAllPeriods');
    expect(ChallengePeriod::where('is_active', true)->exists())->toBeFalse();
    expect(Challenge::where('status', 'ACTIVE')->exists())->toBeFalse();

    // Test Delete period (allowed because it has no results)
    $component->call('deletePeriod', $newPeriod->id);
    expect(ChallengePeriod::find($newPeriod->id))->toBeNull();

    // Restore first period as active for subsequent tests
    $firstPeriod = ChallengePeriod::first();
    if ($firstPeriod) {
        $firstPeriod->update(['is_active' => true]);
        Challenge::first()?->update(['status' => 'ACTIVE']);
    }
});

test('runner live status displays on-site check-in instruction and closed period history without replay button', function () {
    $period = ChallengePeriod::where('is_active', true)->first();
    $challenge = Challenge::first();

    $umumRole = Role::where('slug', 'umum')->first();
    $user = User::factory()->create([
        'name' => 'Dimas Anggara',
        'email' => 'dimas@example.com',
        'role_id' => $umumRole->id,
        'shoe_size' => 42,
    ]);

    $participant = Participant::create([
        'participant_id' => 'UMS-9901',
        'full_name' => 'Dimas Anggara',
        'display_name' => 'Dimas A',
        'whatsapp' => '081299998888',
        'email' => 'dimas@example.com',
        'shoe_size' => 42,
        'participant_category' => 'Umum',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    // Stage 1: Registered online (waiting for on-site check-in start)
    $result = $participant->results()->create([
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'REGISTERED',
        'runner_status' => 'REGISTERED',
        'completion_status' => 'NOT_STARTED',
        'verification_status' => 'PENDING',
    ]);

    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->assertSee('MENUNGGU START DI VENUE')
        ->assertSee('Kak, ini saya sudah daftar, saya mau lari')
        ->assertDontSee('Mulai Lari Ulang (Perbaiki Waktu Periode Ini)');

    // Stage 2: Finished run with recorded time
    $result->update([
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'FINISHED',
        'completion_status' => 'COMPLETED',
        'verified_time_seconds' => 125.5,
        'verification_status' => 'VERIFIED',
    ]);

    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->assertSee('SELESAI LARI (FINISHER)')
        ->assertSee('02:05,50')
        ->assertDontSee('Mulai Lari Ulang (Perbaiki Waktu Periode Ini)');

    // Stage 3: Closed period
    $period->update(['is_open_for_registration' => false]);

    Livewire::actingAs($user)
        ->test(RunnerLiveStatus::class)
        ->assertSee('PENDAFTARAN TUTUP')
        ->assertSee('Pendaftaran dan Sesi Lari')
        ->assertSee('Telah Ditutup')
        ->assertSee('Lintasan 3 KM')
        ->assertDontSee('SELESAI LARI (FINISHER)')
        ->assertDontSee('Mulai Lari Ulang (Perbaiki Waktu Periode Ini)');

    // Restore period registration status for succeeding tests
    $period->update(['is_open_for_registration' => true]);
});

test('runner cannot register when no challenge period is active', function () {
    // Deactivate all periods and challenges
    ChallengePeriod::query()->update(['is_active' => false]);
    Challenge::query()->update(['status' => 'INACTIVE']);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('everyday-league.register'));
    $response->assertStatus(200);
    $response->assertSee('Belum Ada Event Aktif');

    $postResponse = $this->actingAs($user)->post(route('everyday-league.store'), [
        'full_name' => 'John Doe',
        'display_name' => 'John',
        'whatsapp' => '081234567890',
        'email' => $user->email,
        'shoe_size' => 42,
    ]);

    $postResponse->assertSessionHasErrors(['period']);

    // Restore period
    ChallengePeriod::first()?->update(['is_active' => true, 'is_open_for_registration' => true]);
    Challenge::first()?->update(['status' => 'ACTIVE']);
});

test('users can search and create communities dynamically', function () {
    $community = Community::create([
        'name' => 'Senayan Morning Striders',
        'slug' => 'senayan-morning-striders',
        'city' => 'Jakarta Pusat',
    ]);

    // Search existing community
    $response = $this->getJson(route('communities.search', ['q' => 'Morning']));
    $response->assertStatus(200);
    $response->assertJsonFragment(['name' => 'Senayan Morning Striders']);

    // Create a new community
    $createResponse = $this->postJson(route('communities.store'), [
        'name' => 'Kebayoran Runners Club',
        'city' => 'Jakarta Selatan',
    ]);
    $createResponse->assertStatus(201);
    $createResponse->assertJsonPath('community.name', 'Kebayoran Runners Club');

    expect(Community::where('name', 'Kebayoran Runners Club')->exists())->toBeTrue();
});

test('user registration saves community affiliation', function () {
    $community = Community::create([
        'name' => 'Tangerang Pace Crew',
        'slug' => 'tangerang-pace-crew',
        'city' => 'Tangerang',
    ]);

    $response = $this->post(route('register'), [
        'name' => 'Budi Runner',
        'email' => 'budi.runner@example.com',
        'phone_number' => '081298765432',
        'shoe_size' => 43,
        'role_slug' => 'komunitas',
        'community_id' => $community->id,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'budi.runner@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->community_id)->toBe($community->id);
    expect($user->community?->name)->toBe('Tangerang Pace Crew');
});

test('user registration with join_challenge automatically joins active period and preserves community', function () {
    $community = Community::create([
        'name' => 'Senayan Runners Club',
        'slug' => 'senayan-runners-club',
        'city' => 'Jakarta Pusat',
    ]);

    $response = $this->post(route('register'), [
        'name' => 'Dewi Runner',
        'email' => 'dewi.runner@example.com',
        'phone_number' => '081299998888',
        'shoe_size' => 39,
        'role_slug' => 'komunitas',
        'community_id' => $community->id,
        'password' => 'password123',
        'join_challenge' => 1,
    ]);

    $participant = Participant::where('email', 'dewi.runner@example.com')->first();
    expect($participant)->not->toBeNull();
    expect($participant->community_id)->toBe($community->id);
    expect($participant->participant_category)->toBe('Komunitas');

    $response->assertRedirect(route('everyday-league.success', $participant->participant_id));
});

test('admin can toggle free massage status for runner in event operations', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $challenge = Challenge::where('status', 'ACTIVE')->first();
    $period = ChallengePeriod::where('is_active', true)->first();

    $user = User::factory()->create();
    $participant = Participant::create([
        'participant_id' => 'UMS-TEST-MASSAGE',
        'user_id' => $user->id,
        'full_name' => 'Budi Pijat',
        'display_name' => 'Budi',
        'email' => 'budipijat@example.com',
        'whatsapp' => '081234567899',
        'participant_category' => 'Umum',
        'shoe_size' => '42',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $result = ChallengeResult::create([
        'participant_id' => $participant->id,
        'user_id' => $user->id,
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'REGISTERED',
        'runner_status' => 'PENDING',
        'completion_status' => 'NOT_STARTED',
        'is_massaged' => false,
    ]);

    Livewire::actingAs($admin)
        ->test(EventOperations::class)
        ->call('setRunnerMode', 'PENDING')
        ->assertSee('Belum Pijat')
        ->call('toggleMassage', $participant->id)
        ->assertSee('Sudah Pijat')
        ->assertSee('SUDAH PIJAT GRATIS');

    $result->refresh();
    expect($result->is_massaged)->toBeTrue();
    expect($result->massaged_at)->not->toBeNull();

    // Toggle back
    Livewire::actingAs($admin)
        ->test(EventOperations::class)
        ->call('setRunnerMode', 'PENDING')
        ->call('toggleMassage', $participant->id)
        ->assertSee('BELUM PIJAT');

    $result->refresh();
    expect($result->is_massaged)->toBeFalse();
    expect($result->massaged_at)->toBeNull();
});

test('admin can directly record stopwatch time without starting the runner first', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $challenge = Challenge::where('status', 'ACTIVE')->first();
    $period = ChallengePeriod::where('is_active', true)->first();

    $user = User::factory()->create();
    $participant = Participant::create([
        'participant_id' => 'UMS-DIRECT-TIME',
        'user_id' => $user->id,
        'full_name' => 'Direct Runner',
        'display_name' => 'Direct',
        'email' => 'directrunner@example.com',
        'whatsapp' => '081234567888',
        'participant_category' => 'Umum',
        'shoe_size' => '41',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    // Pelari baru terdaftar tanpa start lari lebih dulu
    $result = ChallengeResult::create([
        'participant_id' => $participant->id,
        'user_id' => $user->id,
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'REGISTERED',
        'runner_status' => 'PENDING',
        'completion_status' => 'NOT_STARTED',
    ]);

    Livewire::actingAs($admin)
        ->test(EventOperations::class)
        ->call('setRunnerMode', 'PENDING')
        ->assertSee('Catat Waktu')
        ->call('openTimeModal', $participant->id)
        ->assertSet('showTimeModal', true)
        ->set('timeInput', '032045') // 03:20,45
        ->call('saveTime')
        ->assertSet('showTimeModal', false);

    $result->refresh();
    expect($result->runner_status)->toBe('FINISHED');
    expect($result->completion_status)->toBe('COMPLETED');
    expect((float) $result->verified_time_seconds)->toBe(200.45);
});

test('user can register with women role and joins challenge in women category', function () {
    $response = $this->post(route('register'), [
        'name' => 'Maya Runner',
        'email' => 'maya.women@example.com',
        'phone_number' => '081233445566',
        'shoe_size' => 38,
        'role_slug' => 'women',
        'password' => 'password123',
        'join_challenge' => 1,
    ]);

    $user = User::where('email', 'maya.women@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role?->slug)->toBe('women');

    $participant = Participant::where('email', 'maya.women@example.com')->first();
    expect($participant)->not->toBeNull();
    expect($participant->participant_category)->toBe('Women');

    $response->assertRedirect(route('everyday-league.success', $participant->participant_id));
});

test('leaderboard displays women category and filters women runners correctly', function () {
    $challenge = Challenge::where('status', 'ACTIVE')->first();
    $period = ChallengePeriod::where('is_active', true)->first();

    $user = User::factory()->create();
    $participant = Participant::create([
        'participant_id' => 'UMS-WOMEN-01',
        'user_id' => $user->id,
        'full_name' => 'Rina Srikandi',
        'display_name' => 'Rina S',
        'email' => 'rina.srikandi@example.com',
        'whatsapp' => '081233332222',
        'participant_category' => 'Women',
        'shoe_size' => '38',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $result = ChallengeResult::create([
        'participant_id' => $participant->id,
        'user_id' => $user->id,
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'FINISHED',
        'completion_status' => 'COMPLETED',
        'verified_time_seconds' => 180.50,
        'verification_status' => 'VERIFIED',
    ]);

    Livewire::test(Leaderboard::class)
        ->call('setRoleTab', 'Women')
        ->assertSet('activeRoleTab', 'Women')
        ->assertSee('Rina S')
        ->assertSee('UMS-WOMEN-01')
        ->assertSee('03:00,50');
});

test('voucher code is dynamically resolved from period prize config for any configured rank up to 200', function () {
    $period = ChallengePeriod::where('is_active', true)->first();
    $period->update([
        'prizes_config' => [
            [
                'rank_from' => 1,
                'rank_to' => 3,
                'type' => 'SEPATU',
                'title' => 'Sepatu UNERD Juara',
                'voucher_code' => 'MOVE-PODIUM-VOUCHER',
                'description' => 'Sepatu juara podium',
            ],
            [
                'rank_from' => 4,
                'rank_to' => 200,
                'type' => 'VOUCHER',
                'title' => 'Voucher Hadiah Top 200',
                'voucher_code' => 'MOVE-TOP200-SPECIAL',
                'description' => 'Voucher spesial diskon belanja untuk 200 finisher pertama.',
            ],
        ],
    ]);

    $prizeRank50 = $period->getPrizeForRank(50);
    expect($prizeRank50)->not->toBeNull();
    expect($prizeRank50['voucher_code'])->toBe('MOVE-TOP200-SPECIAL');

    $prizeRank1 = $period->getPrizeForRank(1);
    expect($prizeRank1)->not->toBeNull();
    expect($prizeRank1['voucher_code'])->toBe('MOVE-PODIUM-VOUCHER');

    // Rank outside defined range (201) returns null
    $prizeRank201 = $period->getPrizeForRank(201);
    expect($prizeRank201)->toBeNull();
});

test('voucher is disabled and codes disappear when period or challenge is deactivated', function () {
    $period = ChallengePeriod::where('is_active', true)->first();
    $period->update([
        'is_active' => false,
    ]);

    expect($period->getPrizeForRank(1))->toBeNull();

    $role = Role::whereIn('slug', ['umum', 'customer'])->first();
    $user = User::factory()->create([
        'email' => 'runner.voucher.test@example.com',
        'role_id' => $role?->id,
    ]);

    $response = $this->actingAs($user)->get(route('customer.rewards'));
    $response->assertStatus(200);
    $response->assertSee('TANTANGAN NON-AKTIF / DITUTUP');
    $response->assertSee('KODE TIDAK AKTIF');
    $response->assertDontSee('MOVE-CHAMPION-10%');
});

test('crew can reset runner race time to null and runner is removed from leaderboard', function () {
    $adminRole = Role::where('slug', 'administrator')->first();
    $crew = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $period = ChallengePeriod::where('is_active', true)->first();
    $challenge = Challenge::where('status', 'ACTIVE')->first();

    $participant = Participant::create([
        'participant_id' => 'UMS-RESET-01',
        'full_name' => 'Budi Reset',
        'display_name' => 'Budi R',
        'email' => 'budi.reset@example.com',
        'whatsapp' => '081299990000',
        'participant_category' => 'Umum',
        'shoe_size' => '42',
        'consent_health' => true,
        'consent_terms' => true,
    ]);

    $result = ChallengeResult::create([
        'participant_id' => $participant->id,
        'challenge_id' => $challenge->id,
        'challenge_period_id' => $period->id,
        'checkin_status' => 'CHECKED_IN',
        'runner_status' => 'FINISHED',
        'completion_status' => 'COMPLETED',
        'recorded_time_seconds' => 190.0,
        'verified_time_seconds' => 190.0,
        'verification_status' => 'VERIFIED',
    ]);
    $period->recalculateRanks();

    // Verify runner initially appears on leaderboard
    Livewire::test(Leaderboard::class)
        ->assertSee('Budi R')
        ->assertSee('UMS-RESET-01');

    // Crew triggers resetTime via Livewire EventOperations
    Livewire::actingAs($crew)
        ->test(EventOperations::class)
        ->call('resetTime', $participant->id)
        ->assertSee('berhasil di-reset menjadi kosong (null)');

    $result->refresh();
    expect($result->recorded_time_seconds)->toBeNull();
    expect($result->verified_time_seconds)->toBeNull();
    expect($result->verification_status)->toBe('PENDING');
    expect($result->rank_in_period)->toBeNull();

    // Verify runner no longer appears in leaderboard
    Livewire::test(Leaderboard::class)
        ->assertDontSee('UMS-RESET-01');
});

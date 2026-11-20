<?php

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Participant;

test('registration screen can be rendered with favicon and title', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
    $response->assertSee('UNERD Move');
    $response->assertSee('icon-light.png');
});

test('new user can register as umum and access dashboard without 403', function () {
    $response = $this->post('/register', [
        'name' => 'Runner Umum',
        'email' => 'runner.umum@example.com',
        'shoe_size' => 42,
        'role_slug' => 'umum',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    // Follow redirect to dashboard and customer hub
    $dashboardResponse = $this->get(route('dashboard'));
    $dashboardResponse->assertRedirect(route('customer.dashboard'));

    $hubResponse = $this->get(route('customer.dashboard'));
    $hubResponse->assertStatus(200);
    $hubResponse->assertSee('Dashboard Pelari Umum');
    $hubResponse->assertSee('EU 42');
});

test('new user can register as komunitas and access dashboard without 403', function () {
    $response = $this->post('/register', [
        'name' => 'Runner Komunitas',
        'email' => 'runner.komunitas@example.com',
        'shoe_size' => 40,
        'role_slug' => 'komunitas',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $hubResponse = $this->get(route('customer.dashboard'));
    $hubResponse->assertStatus(200);
    $hubResponse->assertSee('Dashboard Pelari Komunitas');
});

test('new user can register as profesional and access dashboard without 403', function () {
    $response = $this->post('/register', [
        'name' => 'Runner Pro',
        'email' => 'runner.pro@example.com',
        'shoe_size' => 43,
        'role_slug' => 'profesional',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $this->assertAuthenticated();
    $hubResponse = $this->get(route('customer.dashboard'));
    $hubResponse->assertStatus(200);
    $hubResponse->assertSee('Dashboard Pelari Profesional');
});

test('new user can register with single password without confirmation field', function () {
    $response = $this->post('/register', [
        'name' => 'Runner Single Password',
        'email' => 'runner.single@example.com',
        'shoe_size' => 41,
        'role_slug' => 'umum',
        'password' => 'password123',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('new user registration with active challenge automatically enrolls runner and redirects to challenge success card', function () {
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

    $period = ChallengePeriod::firstOrCreate(
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

    $response = $this->post('/register', [
        'name' => 'Fast Runner GBK',
        'email' => 'fast.runner@example.com',
        'phone_number' => '081234567899',
        'shoe_size' => 42,
        'role_slug' => 'umum',
        'password' => 'password123',
        'join_challenge' => 1,
    ]);

    $this->assertAuthenticated();

    $participant = Participant::where('email', 'fast.runner@example.com')->first();
    expect($participant)->not->toBeNull();
    expect($participant->shoe_size)->toBe(42);

    $result = ChallengeResult::where('participant_id', $participant->id)
        ->where('challenge_period_id', $period->id)
        ->first();
    expect($result)->not->toBeNull();
    expect($result->checkin_status)->toBe('REGISTERED');

    $response->assertRedirect(route('everyday-league.success', $participant->participant_id));
});

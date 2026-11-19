<?php

declare(strict_types=1);

use App\Livewire\Admin\CommunityManager;
use App\Livewire\EventOperations;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\Community;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('guest cannot access admin communities page', function () {
    $response = $this->get(route('admin.communities.index'));
    $response->assertRedirect(route('login'));
});

test('admin can access community management page', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $community = Community::create([
        'name' => 'Jakarta Morning Runners',
        'slug' => 'jakarta-morning-runners',
        'city' => 'Jakarta',
        'description' => 'Komunitas lari sub-5 pagi GBK Senayan',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.communities.index'));
    $response->assertStatus(200);
    $response->assertSee('Manajemen Komunitas Lari');
    $response->assertSee('Jakarta Morning Runners');
});

test('admin can create, update, and delete community via livewire component', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    Livewire::actingAs($admin)
        ->test(CommunityManager::class)
        ->set('name', 'Bandung Track Club')
        ->set('slug', 'bandung-track-club')
        ->set('city', 'Bandung')
        ->set('description', 'Komunitas lari lintasan Gasibu')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSee('Bandung Track Club');

    $community = Community::where('slug', 'bandung-track-club')->first();
    expect($community)->not->toBeNull()
        ->and($community->city)->toBe('Bandung');

    // Update
    Livewire::actingAs($admin)
        ->test(CommunityManager::class)
        ->call('editCommunity', $community->id)
        ->set('name', 'Bandung Track Club Pro')
        ->set('city', 'Bandung Kota')
        ->call('save')
        ->assertHasNoErrors();

    expect($community->fresh()->name)->toBe('Bandung Track Club Pro')
        ->and($community->fresh()->city)->toBe('Bandung Kota');

    // Delete
    Livewire::actingAs($admin)
        ->test(CommunityManager::class)
        ->call('deleteCommunity', $community->id);

    expect(Community::find($community->id))->toBeNull();
});

test('admin can create and update user with community_id', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $komunitasRole = Role::firstOrCreate(['slug' => 'komunitas'], [
        'name' => 'Komunitas',
        'hierarchy_level' => 3,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $community = Community::create([
        'name' => 'Surabaya Runners Hub',
        'slug' => 'surabaya-runners-hub',
        'city' => 'Surabaya',
    ]);

    // Create user with community_id
    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@example.com',
        'phone_number' => '081234567890',
        'role_id' => $komunitasRole->id,
        'community_id' => $community->id,
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.users.index'));

    $user = User::where('email', 'budi.santoso@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->community_id)->toBe($community->id)
        ->and($user->community->name)->toBe('Surabaya Runners Hub');

    // Update user community_id
    $community2 = Community::create([
        'name' => 'Malang Striders',
        'slug' => 'malang-striders',
        'city' => 'Malang',
    ]);

    $updateResponse = $this->actingAs($admin)->put(route('admin.users.update', $user), [
        'name' => 'Budi Santoso Edit',
        'email' => 'budi.santoso@example.com',
        'phone_number' => '081234567890',
        'role_id' => $komunitasRole->id,
        'community_id' => $community2->id,
    ]);

    $updateResponse->assertRedirect(route('admin.users.index'));
    expect($user->fresh()->community_id)->toBe($community2->id);
});

test('admin can upload period image file and save storage url in event operations', function () {
    Storage::fake('public');

    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $challenge = Challenge::firstOrCreate(['slug' => 'challenge-upload-test'], [
        'name' => 'Time Attack Challenge',
        'slug' => 'challenge-upload-test',
        'challenge_type' => 'RUN',
        'distance_meter' => 3000,
        'status' => 'ACTIVE',
    ]);

    $file = UploadedFile::fake()->image('venue-banner.jpg', 800, 600);

    Livewire::actingAs($admin)
        ->test(EventOperations::class)
        ->call('openManagePeriodModal')
        ->set('periodFormName', 'Periode Upload Image Test')
        ->set('periodFormCode', 'PERIODE-IMG-TEST')
        ->set('periodFormLocation', 'Gelora Bung Karno, Jakarta')
        ->set('periodFormDistance', 3000)
        ->set('periodFormDuration', 60)
        ->set('periodFormDate', '2026-12-01')
        ->set('periodFormImageFile', $file)
        ->call('savePeriod')
        ->assertHasNoErrors();

    $period = ChallengePeriod::where('period_code', 'PERIODE-IMG-TEST')->first();
    expect($period)->not->toBeNull()
        ->and($period->banner_image)->toContain('/storage/periods/');

    $storedPath = str_replace('/storage/', '', $period->banner_image);
    Storage::disk('public')->assertExists($storedPath);
});

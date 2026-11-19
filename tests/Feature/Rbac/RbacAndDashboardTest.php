<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use App\Support\Enums\UserRole;

beforeEach(function () {
    // Seed core roles for test environment
    Role::firstOrCreate(['slug' => UserRole::ADMINISTRATOR->value], [
        'name' => 'Administrator',
        'is_system_reserved' => true,
    ]);

    Role::firstOrCreate(['slug' => UserRole::FIELD_SALES->value], [
        'name' => 'Field Sales Representative',
        'is_system_reserved' => true,
    ]);

    Role::firstOrCreate(['slug' => UserRole::B2B_CLIENT->value], [
        'name' => 'B2B Client Partner',
        'is_system_reserved' => true,
    ]);

    Role::firstOrCreate(['slug' => UserRole::CUSTOMER->value], [
        'name' => 'Retail Customer',
        'is_system_reserved' => true,
    ]);
});

test('administrator can access admin dashboard and role management', function () {
    $adminRole = Role::where('slug', UserRole::ADMINISTRATOR->value)->first();
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $response = $this->actingAs($admin)->get('/admin/dashboard');
    $response->assertStatus(200);

    $rolesResponse = $this->actingAs($admin)->get('/admin/roles');
    $rolesResponse->assertStatus(200);

    $usersResponse = $this->actingAs($admin)->get('/admin/users');
    $usersResponse->assertStatus(200);
});

test('administrator can create a new custom role type', function () {
    $adminRole = Role::where('slug', UserRole::ADMINISTRATOR->value)->first();
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $response = $this->actingAs($admin)->post('/admin/roles', [
        'name' => 'Warehouse Supervisor',
        'slug' => 'warehouse-supervisor',
        'description' => 'Supervises stock intake and outbound dispatch from Pasuruan factory',
    ]);

    $response->assertRedirect(route('admin.roles.index'));
    $this->assertDatabaseHas('roles', [
        'name' => 'Warehouse Supervisor',
        'slug' => 'warehouse-supervisor',
        'is_system_reserved' => false,
    ]);
});

test('system reserved roles cannot be deleted', function () {
    $adminRole = Role::where('slug', UserRole::ADMINISTRATOR->value)->first();
    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.roles.destroy', $adminRole));

    $response->assertSessionHasErrors(['error']);
    $this->assertDatabaseHas('roles', [
        'id' => $adminRole->id,
    ]);
});

test('field sales representative can access sales dashboard but is forbidden from admin dashboard', function () {
    $salesRole = Role::where('slug', UserRole::FIELD_SALES->value)->first();
    $salesUser = User::factory()->create([
        'role_id' => $salesRole->id,
    ]);

    $salesResponse = $this->actingAs($salesUser)->get('/sales/dashboard');
    $salesResponse->assertStatus(200);

    $forbiddenResponse = $this->actingAs($salesUser)->get('/admin/dashboard');
    $forbiddenResponse->assertStatus(403);
});

test('b2b client can access wholesale portal but is forbidden from admin dashboard', function () {
    $b2bRole = Role::where('slug', UserRole::B2B_CLIENT->value)->first();
    $b2bUser = User::factory()->create([
        'role_id' => $b2bRole->id,
    ]);

    $portalResponse = $this->actingAs($b2bUser)->get('/portal/dashboard');
    $portalResponse->assertStatus(200);

    $forbiddenResponse = $this->actingAs($b2bUser)->get('/admin/dashboard');
    $forbiddenResponse->assertStatus(403);
});

test('retail customer can access customer dashboard and central /dashboard routes to customer dashboard', function () {
    $customerRole = Role::where('slug', UserRole::CUSTOMER->value)->first();
    $customer = User::factory()->create([
        'role_id' => $customerRole->id,
    ]);

    $customerResponse = $this->actingAs($customer)->get('/customer/dashboard');
    $customerResponse->assertStatus(200);

    $centralDashboard = $this->actingAs($customer)->get('/dashboard');
    $centralDashboard->assertRedirect(route('customer.dashboard'));
});

test('customer can access separate history and rewards pages', function () {
    $customerRole = Role::where('slug', UserRole::CUSTOMER->value)->first();
    $customer = User::factory()->create([
        'role_id' => $customerRole->id,
    ]);

    $historyResponse = $this->actingAs($customer)->get('/customer/history');
    $historyResponse->assertStatus(200);
    $historyResponse->assertSee('Riwayat Perlombaan');

    $rewardsResponse = $this->actingAs($customer)->get('/customer/rewards');
    $rewardsResponse->assertStatus(200);
    $rewardsResponse->assertSee('MOVE-GBK-10%');
});

test('blocked user is deactivated and rejected by role middleware', function () {
    $salesRole = Role::where('slug', UserRole::FIELD_SALES->value)->first();
    $blockedSalesUser = User::factory()->create([
        'role_id' => $salesRole->id,
        'is_blocked' => true,
    ]);

    $response = $this->actingAs($blockedSalesUser)->get('/sales/dashboard');
    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('registration supports registering as b2b client partner', function () {
    $response = $this->post('/register', [
        'name' => 'Bandung Footwear Boutique',
        'email' => 'bandung.kicks@example.com',
        'phone_number' => '081299998888',
        'role_slug' => 'b2b-client',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'bandung.kicks@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->role->slug)->toBe(UserRole::B2B_CLIENT->value);
});

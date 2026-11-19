<?php

declare(strict_types=1);

use App\Livewire\Admin\ProductManager;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;

test('guest cannot access admin products page', function () {
    $response = $this->get(route('admin.products.index'));
    $response->assertRedirect(route('login'));
});

test('admin can access product management page and see products', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $product = Product::create([
        'name' => 'UNERD Fast Move Test',
        'slug' => 'unerd-fast-move-test',
        'category' => 'Performance',
        'price' => 500000,
        'retail_price' => 500000,
        'discounted_price' => 450000,
        'tag' => 'PERFORMANCE',
        'image' => 'images/products/unerd-beat-flow-performance.jpg',
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.products.index'));
    $response->assertStatus(200);
    $response->assertSee('Manajemen Produk');
    $response->assertSee('UNERD Fast Move Test');
});

test('admin can create, update, toggle and delete product via livewire component', function () {
    $adminRole = Role::firstOrCreate(['slug' => 'administrator'], [
        'name' => 'Administrator',
        'hierarchy_level' => 1,
    ]);

    $admin = User::factory()->create([
        'role_id' => $adminRole->id,
        'is_blocked' => false,
    ]);

    $this->actingAs($admin);

    Livewire::test(ProductManager::class)
        ->set('name', 'UNERD Stride Lifestyle')
        ->set('category', 'Lifestyle')
        ->set('retailPrice', 400000)
        ->set('discountedPrice', 360000)
        ->set('image', 'images/products/unerd-thera-reco-lifestyle.jpg')
        ->call('saveProduct')
        ->assertHasNoErrors();

    $product = Product::where('name', 'UNERD Stride Lifestyle')->first();
    expect($product)->not->toBeNull();
    expect($product->category)->toBe('Lifestyle');
    expect($product->badge_color)->toBe('cobalt');
    expect($product->is_active)->toBeTrue();

    // Test toggle status
    Livewire::test(ProductManager::class)
        ->call('toggleStatus', $product->id);

    expect($product->fresh()->is_active)->toBeFalse();

    // Test delete
    Livewire::test(ProductManager::class)
        ->call('deleteProduct', $product->id);

    expect(Product::find($product->id))->toBeNull();
});

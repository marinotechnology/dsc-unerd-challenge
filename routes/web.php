<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EventOperationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EverydayLeagueController;
use App\Http\Controllers\Portal\PortalDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sales\SalesDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| UNERD EVERYDAY LEAGUE — Public Runner Experience (Mobile-First)
|--------------------------------------------------------------------------
*/

Route::get('/', [EverydayLeagueController::class, 'index'])->name('home');
Route::get('/everyday-league', [EverydayLeagueController::class, 'index'])->name('everyday-league.index');
Route::get('/everyday-league/register', [EverydayLeagueController::class, 'registerView'])->middleware('auth')->name('everyday-league.register');
Route::post('/everyday-league/register', [EverydayLeagueController::class, 'storeRegistration'])->middleware('auth')->name('everyday-league.store');
Route::get('/everyday-league/success/{participant:participant_id}', [EverydayLeagueController::class, 'success'])->name('everyday-league.success');
Route::get('/everyday-league/leaderboard', [EverydayLeagueController::class, 'leaderboard'])->name('everyday-league.leaderboard');
Route::get('/everyday-league/result/{participant:participant_id}', [EverydayLeagueController::class, 'result'])->name('everyday-league.result');
Route::match(['get', 'post'], '/everyday-league/track-product', [EverydayLeagueController::class, 'trackProductClick'])->name('everyday-league.track-product');
Route::get('/communities/search', [CommunityController::class, 'search'])->name('communities.search');
Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');

/*
|--------------------------------------------------------------------------
| Authenticated User Central Routing
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Administrator & Event Crew Operations (Protected RBAC)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,administrator,field-sales'])->prefix('admin')->name('admin.')->group(function () {
    // Event Operations: GBK Check-In, Stopwatch Timing, & CSV Export
    Route::get('/event', [EventOperationController::class, 'index'])->name('event.index');
    Route::post('/event/check-in/{participant}', [EventOperationController::class, 'checkIn'])->name('event.check-in');
    Route::post('/event/record-time/{participant}', [EventOperationController::class, 'recordTime'])->name('event.record-time');
    Route::get('/event/export-csv', [EventOperationController::class, 'exportCsv'])->name('event.export-csv');
    Route::get('/event/export-users-csv', [EventOperationController::class, 'exportUsersCsv'])->name('event.export-users-csv');
});

Route::middleware(['auth', 'role:admin,administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Role / User Type Management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // User Directory
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block');

    // Product Catalog (CRUD)
    Route::get('/products', fn () => view('admin.products.index'))->name('products.index');

    // Community Management (CRUD)
    Route::get('/communities', fn () => view('admin.communities.index'))->name('communities.index');
});

// Crew Lapangan Routes (Pilar #02 PWA)
Route::middleware(['auth', 'role:field-sales,admin,administrator'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [SalesDashboardController::class, 'index'])->name('dashboard');
});

// Komunitas Mitra Portal Routes (Pilar #03)
Route::middleware(['auth', 'role:komunitas,b2b-client,admin,administrator'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [PortalDashboardController::class, 'index'])->name('dashboard');
});

// Peserta Lari Account Routes (Pelari Women, Umum, Komunitas, Profesional, Customer)
Route::middleware(['auth', 'role:women,umum,komunitas,profesional,customer,admin,administrator'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/history', [CustomerDashboardController::class, 'history'])->name('history');
    Route::get('/rewards', [CustomerDashboardController::class, 'rewards'])->name('rewards');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

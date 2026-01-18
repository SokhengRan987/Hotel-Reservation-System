<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\User; // For type hint in redirect
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PaymentWebhookController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;

/*
|--------------------------------------------------------------------------
| ROLE-BASED REDIRECT AFTER LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {
    /** @var User|null $user */
    $user = auth()->user();

    if ($user && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('home');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Home page / room listing
Route::get('/', [RoomController::class, 'index'])->name('home');

// Room details
Route::prefix('rooms')->name('customer.rooms.')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/{room}', [RoomController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard for normal users (optional)
    Route::get('/dashboard', function () {
        return view('dashboard'); // create resources/views/dashboard.blade.php
    })->name('dashboard');

    // Booking routes
    Route::get('/bookings/create', [BookingController::class, 'create'])
        ->name('customer.bookings.create');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('customer.bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('customer.bookings.show');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (AUTH + ADMIN MIDDLEWARE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Room management
        Route::resource('rooms', AdminRoomController::class);

        // Booking management
        Route::resource('bookings', AdminBookingController::class);

        // Payment management
        Route::resource('payments', AdminPaymentController::class);
});

/*
|--------------------------------------------------------------------------
| STRIPE WEBHOOK (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/stripe', [PaymentWebhookController::class, 'handle']);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze / Fortify)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

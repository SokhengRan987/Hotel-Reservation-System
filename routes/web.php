<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PaymentWebhookController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| ROLE REDIRECT
|--------------------------------------------------------------------------
*/
Route::get('/redirect', function () {
    /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if ($user && $user->isAdmin()) {

                return redirect()->route('admin.dashboard');
            }

    return redirect()->route('customer.rooms.index');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
// ...existing code...
Route::get('/', [RoomController::class, 'index']) ->name('home')   
->name('customer.rooms.index');
Route::get('/', [RoomController::class, 'index'])
   ->name('home');
 
 Route::prefix('rooms')
     ->name('customer.rooms.')
     ->group(function () {
       // index route so route('customer.rooms.index') exists
      Route::get('/', [RoomController::class, 'index'])->name('index');
         Route::get('/{room}', [RoomController::class, 'show'])
             ->name('show');
         Route::get('/{room}/disabled-dates', [RoomController::class, 'getDisabledDates'])
             ->name('disabled-dates');
     });
 
/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('dashboard'))
            ->name('dashboard');

        // BOOKINGS
        Route::post('/bookings', [BookingController::class, 'store'])
            ->name('bookings.store');

        // Protected booking routes - ensure user owns the booking
        Route::middleware('own_booking')->group(function () {
            Route::get('/bookings/{booking}', [BookingController::class, 'show'])
                ->name('bookings.show');

            Route::get('/bookings/{booking}/success', function ($booking) {
                // Fetch the actual Booking model if only ID was passed
                if (is_string($booking)) {
                    $booking = \App\Models\Booking::findOrFail($booking);
                }
                return view('customer.bookings.success', compact('booking'));
            })->name('bookings.success');
        });

        // PROFILE
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

    /*
|--------------------------------------------------------------------------
| PUBLIC PROFILE ROUTES (for admin/navigation and other layouts)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('rooms', AdminRoomController::class);
        Route::resource('bookings', AdminBookingController::class);
        Route::resource('payments', AdminPaymentController::class);
       
    });

/*
|--------------------------------------------------------------------------
| STRIPE WEBHOOK (PUBLIC, NO CSRF)
|
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/stripe', [PaymentWebhookController::class, 'handle'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\RoomController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Webhooks\PaymentWebhookController;
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
    /** @var \App\Models\User $user */
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
Route::get('/', [RoomController::class, 'index'])->name('home');

Route::prefix('rooms')
    ->name('customer.rooms.')
    ->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index');
        Route::get('/{room}', [RoomController::class, 'show'])->name('show');
        Route::get('/{room}/disabled-dates', [RoomController::class, 'getDisabledDates'])->name('disabled-dates');
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

        Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

        /*
        BOOKING FLOW: Step 1 - Create Booking
        */
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

        /*
        PROTECTED BOOKING ROUTES
        */
        Route::middleware('own_booking')->group(function () {

            Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

            /*
            PAYMENT FLOW:  Select Payment Method
            User selects PayPal, Card, or ABA QR
            */
            Route::get('/bookings/{booking}/pay', [BookingController::class, 'payMethodForm'])
                ->name('bookings.pay.form');
            
            Route::post('/bookings/{booking}/pay', [BookingController::class, 'payMethodSubmit'])
                ->name('bookings.pay.submit');

            /*
            PAYMENT FLOW:- Process Payment by Method
            */
            Route::prefix('payment')
                ->name('payment.')
                ->group(function () {
                    
                    // Credit Card Payment (Stripe)
                    Route::post('/bookings/{booking}/card', [PaymentController::class, 'processCard'])
                        ->name('process.card');
                    Route::get('/bookings/{booking}/card/success', [PaymentController::class, 'cardSuccess'])
                        ->name('card.success');
                    Route::get('/bookings/{booking}/card/cancel', [PaymentController::class, 'cardCancel'])
                        ->name('card.cancel');

                    // PayPal Payment
                    Route::post('/bookings/{booking}/paypal', [PaymentController::class, 'processPaypal'])
                        ->name('process.paypal');
                    Route::get('/bookings/{booking}/paypal/success', [PaymentController::class, 'paypalSuccess'])
                        ->name('paypal.success');
                    Route::get('/bookings/{booking}/paypal/cancel', [PaymentController::class, 'paypalCancel'])
                        ->name('paypal.cancel');

                    // ABA QR Payment
                    Route::post('/bookings/{booking}/aba-qr', [PaymentController::class, 'processAbaQr'])
                        ->name('process.aba_qr');
                    Route::get('/bookings/{booking}/aba-qr/show', [PaymentController::class, 'abaQrShow'])
                        ->name('aba_qr.show');

                    // Cash Payment
                    Route::post('/bookings/{booking}/cash', [PaymentController::class, 'processCash'])
                        ->name('process.cash');
                });

            /*
            PAYMENT FLOW: Step 4 - Success Page
            */
            Route::get('/bookings/{booking}/success', function ($booking) {
                if (is_string($booking)) {
                    $booking = \App\Models\Booking::findOrFail($booking);
                }
                return view('customer.bookings.success', compact('booking'));
            })->name('bookings.success');

            /*
            BOOKING HISTORY - View all user bookings
            */
            Route::get('/bookings', [BookingController::class, 'index'])
                ->name('bookings.index');
        });

        /*
        PROFILE ROUTES
        */
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('rooms', AdminRoomController::class);
       
        Route::resource('bookings', AdminBookingController::class);
        Route::resource('payments', AdminPaymentController::class);
    });

/*
|--------------------------------------------------------------------------
| WEBHOOKS (PUBLIC - Payment Provider Callbacks)
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/stripe', [PaymentWebhookController::class, 'handleStripe'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.stripe');

Route::post('/webhooks/paypal', [PaymentWebhookController::class, 'handlePaypal'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.paypal');

Route::post('/webhooks/aba', [PaymentWebhookController::class, 'handleAba'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.aba');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
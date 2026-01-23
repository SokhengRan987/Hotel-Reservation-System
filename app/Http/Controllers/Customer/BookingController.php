<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request)
    {
        $user = $request->user();
        $room = Room::findOrFail($request->room_id);

        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);

        // Prevent zero-night booking
        if ($start->gte($end)) {
            return response()->json([
                'error' => 'Invalid booking dates'
            ], 422);
        }

        // Check overlapping bookings
        $conflict = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<', $end)
                  ->where('end_date', '>', $start);
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'error' => 'Room is not available for selected dates'
            ], 422);
        }

        $nights = $start->diffInDays($end);
        $total  = $nights * $room->price;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id'      => $user->id,
                'room_id'      => $room->id,
                'start_date'   => $start,
                'end_date'     => $end,
                'guest_count'  => $request->guest_count ?? 1,
                'status'       => 'pending',
                'total_amount'=> $total,
            ]);

            $payment = Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'stripe',
                'amount'     => $total,
                'status'     => 'pending',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Could not create booking: ' . $e->getMessage()
            ], 500);
        }

        // Stripe Checkout
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Check if valid Stripe key is configured
            if (!config('services.stripe.secret') || config('services.stripe.secret') === 'sk_test_xxx') {
                throw new \Exception('Stripe API key not properly configured. Please set STRIPE_SECRET in .env file.');
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'unit_amount' => (int) ($total * 100),
                        'product_data' => [
                            'name' => "Room {$room->number} - {$room->type}"
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'client_reference_id' => $booking->id,
                'success_url' => route('customer.bookings.success', $booking->id),
                'cancel_url'  => route('customer.rooms.show', $room->id) . '?payment=cancel',
            ]);

            $payment->update([
                'provider_payment_id' => $session->id
            ]);

            return response()->json([
                'checkout_url' => $session->url
            ]);
        } catch (\Throwable $e) {
            // Log the error for debugging
            Log::error('Stripe Error: ' . $e->getMessage());
            
            // For development/testing, allow booking without Stripe
            return response()->json([
                'checkout_url' => route('customer.bookings.success', $booking->id),
                'message' => 'Booking created successfully! Payment processing is currently unavailable.'
            ]);
        }
    }

    /**
     * Show booking details
     */
    public function show(Booking $booking)
    {
        return view('customer.bookings.show', compact('booking'));
    }
}

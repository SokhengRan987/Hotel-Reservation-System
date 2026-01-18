<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request)
    {
        $user = $request->user();
        $room = Room::findOrFail($request->room_id);
        $start = $request->start_date;
        $end = $request->end_date;

        // overlap check
        $conflict = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<', $end)->where('end_date', '>', $start);
            })->exists();

        if ($conflict) {
            return response()->json(['error' => 'Room not available'], 422);
        }

        $nights = (new \Carbon\Carbon($start))->diffInDays(new \Carbon\Carbon($end));
        $total = $nights * $room->price;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $start,
                'end_date' => $end,
                'guest_count' => $request->guest_count ?? 1,
                'status' => 'pending',
                'total_amount' => $total,
            ]);
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'provider' => 'stripe',
                'amount' => $total,
                'status' => 'pending'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Could not create booking'], 500);
        }

        // Create Stripe Session
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => intval($total * 100),
                    'product_data' => ['name' => "Room {$room->number} - {$room->type}"],
                ],
                'quantity' => 1
            ]],
            'mode' => 'payment',
            'client_reference_id' => $booking->id,
            'success_url' => route('customer.rooms.show', $room->id) . '?payment=success',
            'cancel_url' => route('customer.rooms.show', $room->id) . '?payment=cancel',
        ]);

        $payment->update(['provider_payment_id' => $session->id]);
        return response()->json(['checkout_url' => $session->url]);
    }
}

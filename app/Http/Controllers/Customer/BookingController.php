<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ✅ FIX 1: This method was MISSING — caused the 401 error
    public function index()
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    public function payMethodForm($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        return view('customer.bookings.pay', compact('booking'));
    }

    public function store(StoreBookingRequest $request)
    {
        $user  = $request->user();
        $room  = Room::findOrFail($request->room_id);
        $start = Carbon::parse($request->start_date);
        $end   = Carbon::parse($request->end_date);

        if ($start->gte($end)) {
            return response()->json(['error' => 'Invalid booking dates'], 422);
        }

        $conflict = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->where(fn($q) => $q->where('start_date', '<', $end)->where('end_date', '>', $start))
            ->exists();

        if ($conflict) {
            return response()->json(['error' => 'Room is not available for selected dates'], 422);
        }

        $nights = $start->diffInDays($end);
        $total  = $nights * $room->price;

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'user_id'     => $user->id,
                'room_id'     => $room->id,
                'start_date'  => $start,
                'end_date'    => $end,
                'guest_count' => $request->guest_count,
                'status'      => 'pending',
                'total_amount'=> $total,
                'full_name'   => $request->full_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'pending',  
                'amount'     => $total,
                'status'     => 'pending',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Could not create booking: ' . $e->getMessage()], 500);
        }

        $redirectUrl = route('customer.bookings.pay.form', $booking->id);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['redirect' => $redirectUrl]);
        }
        return redirect($redirectUrl);
    }

    public function show(Booking $booking)
    {
        return view('customer.bookings.show', compact('booking'));
    }
}
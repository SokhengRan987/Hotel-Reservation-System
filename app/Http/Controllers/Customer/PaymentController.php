<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function processCard(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);

        $request->validate([
            'card_name'   => 'required|string|max:100',
            'card_number' => 'required|string|min:13|max:19',
            'card_expiry' => 'required|string',
            'card_cvv'    => 'required|string|min:3|max:4',
        ]);

        $payment = $booking->payment;
        if (!$payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'credit_card',
                'amount'     => $booking->total_amount,
                'status'     => 'paid',  // ✅ fixed: was 'completed'
            ]);
        } else {
            $payment->update(['provider' => 'credit_card', 'status' => 'paid']);  // ✅ fixed
        }

        $booking->update(['status' => 'confirmed']);
        return redirect()->route('customer.bookings.success', $booking->id);
    }

    public function cardSuccess($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        return redirect()->route('customer.bookings.success', $booking->id);
    }

    public function cardCancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        return redirect()->route('customer.bookings.pay.form', $booking->id)
            ->with('error', 'Payment was cancelled. Please try again.');
    }

    public function processPaypal(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);

        $payment = $booking->payment;
        if (!$payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'paypal',
                'amount'     => $booking->total_amount,
                'status'     => 'paid',  // ✅ fixed: was 'pending' then updated separately
            ]);
        } else {
            $payment->update(['provider' => 'paypal', 'status' => 'paid']);  // ✅ fixed
        }

        $booking->update(['status' => 'confirmed']);
        return redirect()->route('customer.bookings.success', $booking->id);
    }

    public function paypalSuccess($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        if ($booking->payment) {
            $booking->payment->update(['status' => 'paid']);  // ✅ fixed: was 'completed'
        }
        $booking->update(['status' => 'confirmed']);
        return redirect()->route('customer.bookings.success', $booking->id);
    }

    public function paypalCancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        return redirect()->route('customer.bookings.pay.form', $booking->id)
            ->with('error', 'PayPal payment was cancelled. Please try again.');
    }

    public function processAbaQr(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);

        $payment = $booking->payment;
        if (!$payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'aba_qr',
                'amount'     => $booking->total_amount,
                'status'     => 'pending',
            ]);
        } else {
            $payment->update(['provider' => 'aba_qr', 'status' => 'pending']);
        }

        $booking->update(['status' => 'confirmed']);
        return redirect()->route('customer.bookings.success', $booking->id);
    }

    public function abaQrShow($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);
        return view('customer.bookings.pay', compact('booking'));
    }

    public function processCash(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if (auth()->id() !== $booking->user_id) abort(403);

        $payment = $booking->payment;
        if (!$payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'provider'   => 'cash',
                'amount'     => $booking->total_amount,
                'status'     => 'pending',
            ]);
        } else {
            $payment->update(['provider' => 'cash', 'status' => 'pending']);
        }

        $booking->update(['status' => 'confirmed']);
        return redirect()->route('customer.bookings.success', $booking->id);
    }
}
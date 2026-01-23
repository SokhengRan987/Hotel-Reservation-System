<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Booking;

class EnsureUserOwnBooking
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Get the booking ID from the route parameter
        $bookingParam = $request->route('booking');
        
        // Handle both string IDs and model instances
        $bookingId = is_string($bookingParam) ? $bookingParam : ($bookingParam?->id ?? null);

        if ($bookingId) {
            $booking = Booking::find($bookingId);

            // Check if booking exists and belongs to the authenticated user
            if (!$booking || $booking->user_id !== $user->id) {
                abort(403, 'Unauthorized access to this booking.');
            }
        }

        return $next($request);
    }
}

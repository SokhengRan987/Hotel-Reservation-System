@extends('layouts.customer')

@section('content')
<div style="background: linear-gradient(135deg, #e3f2fd 0%, #fff3e0 100%); padding: 80px 0; min-height: 100vh; display: flex; align-items: center;">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Success Card -->
                <div style="background: white; border-radius: 20px; padding: 50px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); text-align: center;">

                    <!-- Success Icon -->
                    <div style="margin-bottom: 30px;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #4caf50, #66bb6a); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; animation: scaleIn 0.6s ease-out;">
                            <i class="fas fa-check" style="font-size: 60px; color: white;"></i>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h1 style="color: #1e3c72; font-weight: 800; margin-bottom: 15px; font-size: 2.5rem;">
                        Booking Confirmed! 🎉
                    </h1>
                    <p style="color: #666; font-size: 1.1rem; margin-bottom: 40px;">
                        Your hotel reservation has been successfully confirmed.
                    </p>

                    <!-- Booking Details -->
                    <div style="background: #f8f9fa; padding: 30px; border-radius: 15px; margin-bottom: 30px; text-align: left;">
                        <h4 style="color: #1e3c72; margin-bottom: 20px; font-weight: 700;">Booking Details</h4>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <!-- Left Column -->
                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">BOOKING ID</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.2rem; margin: 0;">
                                    #{{ $booking->id }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">STATUS</p>
                                <p style="margin: 0;">
                                    <span style="background: #fff3cd; color: #856404; padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">ROOM NUMBER</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.2rem; margin: 0;">
                                    Room #{{ $booking->room->number }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">ROOM TYPE</p>
                                <p style="color: #1e3c72; font-weight: 600; margin: 0;">
                                    {{ $booking->room->type }}
                                </p>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">CHECK-IN DATE</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->start_date->format('M d, Y') }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">CHECK-OUT DATE</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->end_date->format('M d, Y') }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">NUMBER OF NIGHTS</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->start_date->diffInDays($booking->end_date) }} night(s)
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">GUESTS</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->guest_count }}
                                </p>
                            </div>
                        </div>

                        <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">

                        <!-- Total Amount -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                Total Amount
                            </p>
                            <p style="color: #ff9800; font-weight: 800; font-size: 1.8rem; margin: 0;">
                                ${{ number_format($booking->total_amount, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div style="background: #e3f2fd; padding: 20px; border-left: 4px solid #1976d2; border-radius: 8px; margin-bottom: 30px; text-align: left;">
                        <p style="color: #0d47a1; margin: 0; font-weight: 600;">
                            ℹ️ A confirmation email has been sent to your registered email address with all booking details.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 15px; justify-content: center;">
                        <a href="{{ route('customer.rooms.index') }}" 
                           style="display: inline-block; background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                            <i class="fas fa-home"></i> Continue Shopping
                        </a>

                        <a href="{{ route('customer.bookings.show', $booking->id) }}" 
                           style="display: inline-block; background: #f8f9fa; color: #1e3c72; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; border: 2px solid #1e3c72; transition: all 0.3s ease;">
                            <i class="fas fa-eye"></i> View Booking
                        </a>
                    </div>

                    <!-- Footer Info -->
                    <p style="color: #999; font-size: 0.9rem; margin-top: 30px; margin-bottom: 0;">
                        Need help? Contact our support team at <strong>support@hotelreservation.com</strong>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
@endsection

@extends('layouts.customer')

@section('content')
<div style="background: linear-gradient(135deg, #e3f2fd 0%, #fff3e0 100%); padding: 60px 0; min-height: 100vh;">
    <div class="container">

        <!-- Back Button -->
        <a href="{{ route('customer.rooms.index') }}" style="display: inline-block; color: #1e3c72; font-weight: 600; margin-bottom: 30px;">
            <i class="fas fa-arrow-left"></i> Back to Rooms
        </a>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Booking Card -->
                <div style="background: white; border-radius: 20px; padding: 50px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">

                    <h1 style="color: #1e3c72; font-weight: 800; margin-bottom: 10px;">Booking Details</h1>
                    <p style="color: #888; margin-bottom: 30px;">Booking ID: <strong>#{{ $booking->id }}</strong></p>

                    <!-- Status Badge -->
                    <div style="margin-bottom: 30px;">
                        <span style="background: #fff3cd; color: #856404; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                            Status: {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <!-- Room Details -->
                    <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                        <h4 style="color: #1e3c72; margin-bottom: 20px; font-weight: 700;">Room Information</h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">ROOM NUMBER</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.2rem; margin: 0;">
                                    #{{ $booking->room->number }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">ROOM TYPE</p>
                                <p style="color: #1e3c72; font-weight: 600; margin: 0;">
                                    {{ $booking->room->type }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">PRICE PER NIGHT</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.2rem; margin: 0;">
                                    ${{ number_format($booking->room->price, 2) }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">MAX GUESTS</p>
                                <p style="color: #1e3c72; font-weight: 600; margin: 0;">
                                    {{ $booking->room->max_adults }} guests
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Dates -->
                    <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                        <h4 style="color: #1e3c72; margin-bottom: 20px; font-weight: 700;">Booking Dates</h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">CHECK-IN</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->start_date->format('M d, Y') }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">CHECK-OUT</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->end_date->format('M d, Y') }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">NUMBER OF NIGHTS</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->start_date->diffInDays($booking->end_date) }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">GUESTS</p>
                                <p style="color: #1e3c72; font-weight: 700; font-size: 1.1rem; margin: 0;">
                                    {{ $booking->guest_count }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div style="background: linear-gradient(135deg, #e3f2fd, #f3e5f5); padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                        <h4 style="color: #1e3c72; margin-bottom: 20px; font-weight: 700;">Price Summary</h4>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="color: #666;">
                                {{ $booking->start_date->diffInDays($booking->end_date) }} nights × ${{ number_format($booking->room->price, 2) }}
                            </span>
                            <span style="color: #1e3c72; font-weight: 600;">
                                ${{ number_format($booking->start_date->diffInDays($booking->end_date) * $booking->room->price, 2) }}
                            </span>
                        </div>

                        <hr style="border: none; border-top: 1px solid #ddd; margin: 15px 0;">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #1e3c72; font-weight: 700; font-size: 1.1rem;">Total Amount</span>
                            <span style="color: #ff9800; font-weight: 800; font-size: 1.8rem;">
                                ${{ number_format($booking->total_amount, 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    @if($booking->payment)
                    <div style="background: #f8f9fa; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
                        <h4 style="color: #1e3c72; margin-bottom: 20px; font-weight: 700;">Payment Information</h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">PROVIDER</p>
                                <p style="color: #1e3c72; font-weight: 600; margin: 0;">
                                    {{ ucfirst($booking->payment->provider) }}
                                </p>
                            </div>

                            <div>
                                <p style="color: #888; font-size: 0.9rem; margin: 0 0 5px 0;">STATUS</p>
                                <p style="margin: 0;">
                                    @php
                                        $statusBg = $booking->payment->status === 'completed' ? '#d4edda' : '#fff3cd';
                                        $statusColor = $booking->payment->status === 'completed' ? '#155724' : '#856404';
                                        $statusText = ucfirst($booking->payment->status);
                                    @endphp
                                    <span style="background-color: {{ $statusBg }}; color: {{ $statusColor }}; padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 0.9rem; display: inline-block;">{{ $statusText }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Button -->
                    <a href="{{ route('customer.rooms.index') }}" 
                       style="display: inline-block; width: 100%; background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 15px; border-radius: 10px; text-decoration: none; font-weight: 600; text-align: center; transition: all 0.3s ease;">
                        <i class="fas fa-home"></i> Continue Browsing
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

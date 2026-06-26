@extends('layouts.customer')

@section('content')
<div style="background:#06122d; padding: 60px 0; min-height: 100vh;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="color:rgb(204, 206, 212); font-weight:600; font-size:1.5rem;">My Bookings</h1>
            <a href="{{ route('customer.rooms.index') }}"
               style="background:#1e3c72; color:white; padding:10px 24px; border-radius:10px; text-decoration:none; font-weight:600;">
                + Book a Room
            </a>
        </div>

        @if($bookings->isEmpty())
            <div style="background:white; border-radius:20px; padding:60px; text-align:center; box-shadow:0 15px 50px rgba(0,0,0,0.08);">
                <div style="font-size:5rem; margin-bottom:16px;">🏨</div>
                <h3 style="color:#1e3c72; font-weight:700;">No bookings yet</h3>
                <p style="color:#888;">You haven't made any reservations yet.</p>
                <a href="{{ route('customer.rooms.index') }}"
                   style="display:inline-block; margin-top:16px; background:#ff9800; color:white; padding:12px 30px; border-radius:10px; text-decoration:none; font-weight:600;">
                    Browse Rooms
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($bookings as $booking)
                    @php
                        $colors = [
                            'pending'     => ['#fff3cd', '#856404'],
                            'confirmed'   => ['#d4edda', '#155724'],
                            'checked_in'  => ['#cce5ff', '#004085'],
                            'checked_out' => ['#e2e3e5', '#383d41'],
                            'cancelled'   => ['#f8d7da', '#721c24'],
                        ];
                        [$bg, $text] = $colors[$booking->status] ?? ['#eee', '#333'];
                    @endphp
                    <div class="col-md-6">
                        <div style="background:white; border-radius:20px; padding:28px; box-shadow:0 8px 30px rgba(0,0,0,0.07); height:100%;">

                            {{-- Header --}}
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div style="font-weight:700; color:#1e3c72; font-size:1.1rem;">
                                        {{ $booking->room->type ?? 'Room' }}
                                        <span style="color:#aaa; font-weight:400; font-size:0.9rem;">#{{ $booking->room->number ?? '' }}</span>
                                    </div>
                                    <div style="color:#bbb; font-size:0.8rem;">Booking #{{ $booking->id }}</div>

                                    <div style="color:#6b7280; font-size:0.85rem; margin-top:6px;">
                                        <strong>Guest:</strong> {{ $booking->full_name ?? $booking->user->name }} ·
                                        <strong>Email:</strong> {{ $booking->email ?? $booking->user->email }} ·
                                        <strong>Phone:</strong> {{ $booking->phone ?? '—' }}
                                    </div>
                                </div>
                                <span style="background:{{ $bg }}; color:{{ $text }}; padding:5px 14px; border-radius:20px; font-size:0.82rem; font-weight:600; white-space:nowrap;">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </div>

                            {{-- Dates Grid --}}
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; background:#f8f9fa; border-radius:12px; padding:14px; margin-bottom:16px;">
                                <div>
                                    <div style="color:#aaa; font-size:0.72rem; font-weight:600; text-transform:uppercase;">Check-in</div>
                                    <div style="color:#1e3c72; font-weight:700;">{{ $booking->start_date->format('M d, Y') }}</div>
                                </div>
                                <div>
                                    <div style="color:#aaa; font-size:0.72rem; font-weight:600; text-transform:uppercase;">Check-out</div>
                                    <div style="color:#1e3c72; font-weight:700;">{{ $booking->end_date->format('M d, Y') }}</div>
                                </div>
                                <div>
                                    <div style="color:#aaa; font-size:0.72rem; font-weight:600; text-transform:uppercase;">Nights</div>
                                    <div style="color:#1e3c72; font-weight:700;">{{ $booking->nights }}</div>
                                </div>
                                <div>
                                    <div style="color:#aaa; font-size:0.72rem; font-weight:600; text-transform:uppercase;">Guests</div>
                                    <div style="color:#1e3c72; font-weight:700;">{{ $booking->guest_count }}</div>
                                </div>
                            </div>

                            {{-- Payment Status --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span style="font-size:0.85rem; color:#666;">
                                    @if($booking->payment)
                                        {{ ucfirst(str_replace('_', ' ', $booking->payment->provider)) }}
                                        @if($booking->payment->status === 'completed')
                                            <span style="color:#28a745;"> ✓ Paid</span>
                                        @else
                                            <span style="color:#ffc107;"> · Pending</span>
                                        @endif
                                    @else
                                        <span style="color:#ffc107;">No payment yet</span>
                                    @endif
                                </span>
                                <span style="color:#ff9800; font-weight:800; font-size:1.2rem;">
                                    ${{ number_format($booking->total_amount, 2) }}
                                </span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}"
                                   style="flex:1; text-align:center; background:#f0f4ff; color:#1e3c72; padding:10px; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem;">
                                    View Details
                                </a>
                                @if($booking->status === 'pending' && (!$booking->payment || $booking->payment->provider === 'pending'))
                                    <a href="{{ route('customer.bookings.pay.form', $booking->id) }}"
                                       style="flex:1; text-align:center; background:#ff9800; color:white; padding:10px; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem;">
                                        Pay Now
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
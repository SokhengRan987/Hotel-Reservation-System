@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- ── Stats ── --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value">{{ $totalBookings }}</div>
            <div class="stat-change positive">All time bookings</div>
        </div>

        <div class="stat-card stat-card-success">
            <div class="stat-label">Available Rooms</div>
            <div class="stat-value">{{ $availableRooms }}</div>
            <div class="stat-change positive">Out of {{ $totalRooms }} total rooms</div>
        </div>

        <div class="stat-card stat-card-warning">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">${{ number_format($revenue, 0) }}</div>
            <div class="stat-change positive">From paid bookings</div>
        </div>

        <div class="stat-card stat-card-danger">
            <div class="stat-label">Pending Payments</div>
            <div class="stat-value">${{ number_format($pendingPayments, 0) }}</div>
            <div class="stat-change negative">Awaiting payment</div>
        </div>
    </div>

    {{-- ── Recent Bookings ── --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Recent Bookings</h2>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">View All</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    @php
                        $badgeClass = match($booking->status) {
                            'confirmed'   => 'badge-success',
                            'pending'     => 'badge-warning',
                            'cancelled'   => 'badge-danger',
                            'checked_in'  => 'badge-success',
                            'checked_out' => 'badge-secondary',
                            default       => 'badge-warning',
                        };
                    @endphp
                    <tr>
                        <td>{{ $booking->user->name ?? '—' }}</td>
                        <td>Room #{{ $booking->room->number ?? '—' }}</td>
                        <td>{{ $booking->start_date->format('M d, Y') }}</td>
                        <td>{{ $booking->end_date->format('M d, Y') }}</td>
                        <td>${{ number_format($booking->total_amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                               class="btn btn-secondary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; color:#9ca3af; padding:40px;">
                            No bookings yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Room Status ── --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Room Status</h2>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Manage Rooms</a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px;">
            <div style="padding:16px; background:#f0fdf4; border-radius:8px; border-left:4px solid #10b981;">
                <div style="font-size:12px; color:#065f46; text-transform:uppercase; font-weight:600; margin-bottom:8px;">Booked</div>
                <div style="font-size:28px; font-weight:700; color:#10b981;">{{ $bookedRooms }}</div>
                <div style="font-size:12px; color:#059669; margin-top:4px;">Rooms currently occupied</div>
            </div>

            <div style="padding:16px; background:#dbeafe; border-radius:8px; border-left:4px solid #2563eb;">
                <div style="font-size:12px; color:#1e40af; text-transform:uppercase; font-weight:600; margin-bottom:8px;">Available</div>
                <div style="font-size:28px; font-weight:700; color:#2563eb;">{{ $availableRooms }}</div>
                <div style="font-size:12px; color:#1d4ed8; margin-top:4px;">Ready for booking</div>
            </div>

            <div style="padding:16px; background:#f3f4f6; border-radius:8px; border-left:4px solid #6b7280;">
                <div style="font-size:12px; color:#374151; text-transform:uppercase; font-weight:600; margin-bottom:8px;">Total Rooms</div>
                <div style="font-size:28px; font-weight:700; color:#374151;">{{ $totalRooms }}</div>
                <div style="font-size:12px; color:#6b7280; margin-top:4px;">In the system</div>
            </div>
        </div>
    </div>

    {{-- ── Quick Actions ── --}}
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Quick Actions</h2>
        </div>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:12px;">
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary" style="justify-content:center; padding:16px;">
                + Add Room
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary" style="justify-content:center; padding:16px;">
                📋 All Bookings
            </a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-primary" style="justify-content:center; padding:16px;">
                💳 Payments
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary" style="justify-content:center; padding:16px;">
                🏨 Manage Rooms
            </a>
        </div>
    </div>

@endsection
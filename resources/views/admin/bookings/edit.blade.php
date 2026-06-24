
@extends('layouts.admin')

@section('content')
<div style="max-width:880px; margin:0 auto; padding:24px 16px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:18px; margin-bottom:24px; flex-wrap:wrap;">
        <div>
            <h1 style="font-size:1.8rem; font-weight:800; color:#1e3a8a; margin:0;">Edit Booking Status</h1>
            <p style="color:#6b7280; margin:6px 0 0;">Update this booking to match the current reservation workflow.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" style="background:#f3f4f6; color:#374151; padding:10px 20px; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.95rem;">← Back to Bookings</a>
    </div>

    @if ($errors->any())
        <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:16px 18px; border-radius:12px; margin-bottom:20px;">
            <strong>Please fix these errors:</strong>
            <ul style="margin:8px 0 0 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background:#fffaf8; border-radius:16px; box-shadow:0 2px 15px rgba(30,58,138,0.07); border:1px solid #eae6f6; padding:24px; margin-bottom:20px;">
        <h2 style="font-size:1.1rem; font-weight:700; color:#1e3a8a; margin-bottom:18px;">Booking Details</h2>
        <div style="display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px;">
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Guest Name</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">{{ $booking->full_name ?? $booking->user->name }}</p>
            </div>
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Email</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">{{ $booking->email ?? $booking->user->email }}</p>
            </div>
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Phone</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">{{ $booking->phone ?? '—' }}</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">Room {{ $booking->room->number }}</p>
            </div>
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Total Amount</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">${{ number_format($booking->total_amount, 2) }}</p>
            </div>
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Check-In</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">{{ $booking->start_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p style="font-size:0.85rem; color:#6b7280; margin-bottom:6px;">Check-Out</p>
                <p style="font-size:1rem; font-weight:700; color:#111827;">{{ $booking->end_date->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <div style="background:#fffaf8; border-radius:16px; box-shadow:0 2px 15px rgba(30,58,138,0.07); border:1px solid #eae6f6; padding:24px;">
        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom:18px;">
                <label for="status" style="display:block; margin-bottom:8px; font-weight:600; color:#374151;">Booking Status</label>
                <select name="status" id="status" style="width:100%; padding:12px 14px; border:1px solid #d1d5db; border-radius:12px; font-size:0.95rem; outline:none; background:white;">
                    <option value="pending" @selected($booking->status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>
                    <option value="checked_in" @selected($booking->status === 'checked_in')>Checked In</option>
                    <option value="checked_out" @selected($booking->status === 'checked_out')>Checked Out</option>
                    <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end; flex-wrap:wrap;">
                <a href="{{ route('admin.bookings.index') }}" style="padding:12px 24px; background:#f3f4f6; color:#374151; border-radius:10px; text-decoration:none; font-weight:700;">Cancel</a>
                <button type="submit" style="padding:12px 24px; background:linear-gradient(135deg,#1e3a8a,#2563eb); color:white; border:none; border-radius:10px; font-weight:700; cursor:pointer;">Update Status</button>
            </div>
        </form>
    </div>
</div>
@endsection

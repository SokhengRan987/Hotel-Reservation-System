@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Booking Status</h1>

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-700">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-lg bg-white shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Booking Details</h2>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-sm text-gray-600">Guest Name</p>
                <p class="text-lg font-semibold text-gray-800">{{ $booking->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Email</p>
                <p class="text-lg font-semibold text-gray-800">{{ $booking->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Room</p>
                <p class="text-lg font-semibold text-gray-800">Room {{ $booking->room->number }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Amount</p>
                <p class="text-lg font-semibold text-gray-800">${{ number_format($booking->total_amount, 2) }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Check-In</p>
                <p class="text-lg font-semibold text-gray-800">{{ $booking->start_date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Check-Out</p>
                <p class="text-lg font-semibold text-gray-800">{{ $booking->end_date->format('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-lg bg-white shadow p-6">
        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Booking Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="pending" @selected($booking->status === 'pending')>Pending</option>
                    <option value="confirmed" @selected($booking->status === 'confirmed')>Confirmed</option>
                    <option value="checked_in" @selected($booking->status === 'checked_in')>Checked In</option>
                    <option value="checked_out" @selected($booking->status === 'checked_out')>Checked Out</option>
                    <option value="cancelled" @selected($booking->status === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Update Status
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

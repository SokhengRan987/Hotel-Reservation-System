@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Bookings Management</h1>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-lg bg-white shadow">
        <table class="w-full">
            <thead>
                <tr class="border-b bg-gray-50">
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Guest Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Room</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Check-In</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Check-Out</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Payment</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">Room {{ $booking->room->number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->start_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->end_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-semibold">${{ number_format($booking->total_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-800
                                @elseif($booking->status === 'checked_out') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->payment?->status === 'completed') bg-green-100 text-green-800
                                @elseif($booking->payment?->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->payment?->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('page-title', 'Rooms')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 style="font-size:20px;">Rooms</h2>
    <a href="{{ route('admin.rooms.create') }}" class="btn-small">+ Add Room</a>
</div>

@if(session('success'))
    <div style="margin-bottom:15px; padding:10px; background:#e6fffa; color:#065f46; border-radius:6px;">{{ session('success') }}</div>
@endif

<table style="width:100%; border-collapse:collapse;">
    <thead>
        <tr style="background:#f3f4f6;">
            <th style="padding:10px; text-align:left;">Number</th>
            <th style="padding:10px; text-align:left;">Type</th>
            <th style="padding:10px; text-align:left;">Price</th>
            <th style="padding:10px; text-align:left;">Capacity</th>
            <th style="padding:10px; text-align:left;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $room)
            <tr>
                <td style="padding:10px;">{{ $room->number }}</td>
                <td style="padding:10px;">{{ $room->type }}</td>
                <td style="padding:10px;">${{ number_format($room->price,2) }}</td>
                <td style="padding:10px;">{{ $room->capacity }}</td>
                <td style="padding:10px;">
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="action-btn">Edit</a>
                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="action-btn delete" onclick="return confirm('Delete this room?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:20px;">
    {{ $rooms->links() }}
</div>

@endsection
@extends('layouts.admin')

@section('page-title', 'Rooms')

@section('content')

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:22px; font-weight:700; color:#1e3a8a;">Rooms</h2>
    <a href="{{ route('admin.rooms.create') }}"
       style="background:linear-gradient(135deg,#1e3a8a,#2563eb); color:white; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.9rem;">
        + Add Room
    </a>
</div>

@if(session('success'))
    <div style="margin-bottom:16px; padding:12px 16px; background:#e6fffa; color:#065f46; border-radius:8px; font-weight:600;">
        ✅ {{ session('success') }}
    </div>
@endif

<div style="background:white; border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,0.07); overflow:hidden; border:1px solid #e5e7eb;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:#f9fafb; border-bottom:2px solid #e5e7eb;">
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Image</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Number</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Type</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Description</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Price</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Capacity</th>
                <th style="padding:14px 16px; text-align:left; color:#6b7280; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                @php
                    // ✅ FIX: Show first image from images[] if no main image
                    $thumbnail = null;
                    if ($room->image) {
                        $thumbnail = $room->image;
                    } elseif ($room->images && count($room->images) > 0) {
                        $thumbnail = $room->images[0];
                    }
                @endphp
                <tr style="border-bottom:1px solid #f3f4f6; transition:background 0.15s;"
                    onmouseover="this.style.background='#f9fafb'"
                    onmouseout="this.style.background='white'">

                    {{-- Image --}}
                    <td style="padding:12px 16px;">
                        @if($thumbnail)
                            <img src="{{ asset('storage/'.$thumbnail) }}"
                                 alt="Room {{ $room->number }}"
                                 style="width:80px; height:70px; object-fit:cover; border-radius:8px; border:1px solid #e5e7eb;">
                        @else
                            <div style="width:80px; height:70px; background:#f3f4f6; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:11px; border:1px dashed #d1d5db;">
                                No image
                            </div>
                        @endif
                    </td>

                    {{-- Number --}}
                    <td style="padding:12px 16px; font-weight:700; color:#1e3a8a;">
                        #{{ $room->number }}
                    </td>

                    {{-- Type --}}
                    <td style="padding:12px 16px;">
                        <span style="background:#eff6ff; color:#1d4ed8; padding:4px 12px; border-radius:20px; font-size:0.82rem; font-weight:600;">
                            {{ $room->type }}
                        </span>
                    </td>

                    {{-- ✅ Description --}}
                    <td style="padding:12px 16px; color:#6b7280; font-size:0.9rem; max-width:200px;">
                        @if($room->description)
                            <span title="{{ $room->description }}">
                                {{ Str::limit($room->description, 50) }}
                            </span>
                        @else
                            <span style="color:#d1d5db;">—</span>
                        @endif
                    </td>

                    {{-- Price --}}
                    <td style="padding:12px 16px; font-weight:700; color:#ff9800;">
                        ${{ number_format($room->price, 2) }}
                    </td>

                    {{-- Capacity --}}
                    <td style="padding:12px 16px; color:#374151;">
                        {{ $room->capacity }} guests
                    </td>

                    {{-- Actions --}}
                    <td style="padding:12px 16px;">
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                               style="background:#f0f4ff; color:#1e3a8a; padding:6px 14px; border-radius:6px; text-decoration:none; font-size:0.85rem; font-weight:600;">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete Room #{{ $room->number }}?')"
                                        style="background:#fef2f2; color:#dc2626; padding:6px 14px; border-radius:6px; border:none; font-size:0.85rem; font-weight:600; cursor:pointer;">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="margin-top:20px;">
    {{ $rooms->links() }}
</div>

@endsection
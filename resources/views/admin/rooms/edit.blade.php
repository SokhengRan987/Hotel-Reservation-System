@extends('layouts.admin')

@section('page-title', 'Edit Room')

@section('content')

<h2 style="margin-bottom:15px;">Edit Room - {{ $room->number }}</h2>

@if($errors->any())
    <div style="margin-bottom:15px; padding:10px; background:#fee2e2; color:#7f1d1d; border-radius:6px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div style="margin-bottom:10px;">
        <label>Number</label><br>
        <input type="text" name="number" value="{{ old('number', $room->number) }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Type</label><br>
        <input type="text" name="type" value="{{ old('type', $room->type) }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Price</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price', $room->price) }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Capacity</label><br>
        <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Features (comma-separated)</label><br>
        <input type="text" name="features" value="{{ old('features', $room->features ? implode(', ', $room->features) : '') }}" />
    </div>
    <div style="margin-bottom:10px;">
        <label>Description</label><br>
        <textarea name="description">{{ old('description', $room->description) }}</textarea>
    </div>
    <div style="margin-bottom:10px;">
        <label>Room Image</label><br>
        @if($room->image)
            <div style="margin-bottom:10px;">
                <img src="{{ asset('storage/' . $room->image) }}" alt="Room" style="max-width:200px; height:auto; border-radius:6px;" />
                <p style="color:#666; font-size:12px;">Current image</p>
            </div>
        @endif
        <input type="file" name="image" accept="image/*" />
        <small style="color:#666;">JPG, PNG, GIF. Max 2MB. Leave empty to keep current image.</small>
    </div>
    <button class="btn-small">Save Changes</button>
</form>

@endsection
@extends('layouts.admin')

@section('page-title', 'Add Room')

@section('content')

<h2 style="margin-bottom:15px;">Add Room</h2>

@if($errors->any())
    <div style="margin-bottom:15px; padding:10px; background:#fee2e2; color:#7f1d1d; border-radius:6px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.rooms.store') }}" method="POST">
    @csrf
    <div style="margin-bottom:10px;">
        <label>Number</label><br>
        <input type="text" name="number" value="{{ old('number') }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Type</label><br>
        <input type="text" name="type" value="{{ old('type') }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Price</label><br>
        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Capacity</label><br>
        <input type="number" name="capacity" value="{{ old('capacity', 1) }}" required />
    </div>
    <div style="margin-bottom:10px;">
        <label>Features (comma-separated)</label><br>
        <input type="text" name="features" value="{{ old('features') }}" />
    </div>
    <div style="margin-bottom:10px;">
        <label>Description</label><br>
        <textarea name="description">{{ old('description') }}</textarea>
    </div>
    <button class="btn-small">Create Room</button>
</form>

@endsection
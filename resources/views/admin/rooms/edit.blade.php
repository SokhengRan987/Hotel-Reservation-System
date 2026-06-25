@extends('layouts.admin')

@section('page-title', 'Edit Room')

@section('content')

<div style="max-width:800px; margin:0 auto;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:800; color:#1e3a8a; margin:0;">Edit Room</h1>
            <p style="color:#6b7280; margin:6px 0 0;">Update details for room <strong>{{ $room->number }}</strong></p>
        </div>
        <a href="{{ route('admin.rooms.index') }}"
           style="background:#f3f4f6; color:#374151; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:600; font-size:0.9rem;">
            Back to Rooms
        </a>
    </div>

    @if($errors->any())
        <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:14px 18px; border-radius:10px; margin-bottom:20px;">
            <strong>Please fix these errors:</strong>
            <ul style="margin:8px 0 0 16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic Info --}}
        <div style="background:#fffaf8; border-radius:14px; padding:22px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:20px; border:1px solid #eae6f6;">
            <h3 style="color:#1e3a8a; font-weight:700; margin:0 0 18px; padding-bottom:10px; border-bottom:2px solid #eae6f6;">
                🏨 Basic Information
            </h3>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Room Number <span style="color:red;">*</span></label>
                    <input type="text" name="number" value="{{ old('number', $room->number) }}" required
                        style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none;">
                </div>
                <div>
                    <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Room Type <span style="color:red;">*</span></label>
                    <select name="type" required style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none; background:white;">
                        <option value="">Select type...</option>
                        <option value="Standard"      @selected(old('type', $room->type) === 'Standard')>Standard</option>
                        <option value="Deluxe"        @selected(old('type', $room->type) === 'Deluxe')>Deluxe</option>
                        <option value="Suite"         @selected(old('type', $room->type) === 'Suite')>Suite</option>
                        <option value="Family"        @selected(old('type', $room->type) === 'Family')>Family</option>
                        <option value="Presidential"  @selected(old('type', $room->type) === 'Presidential')>Presidential</option>
                    </select>
                </div>
                <div>
                    <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Price per Night (USD) <span style="color:red;">*</span></label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#6b7280; font-weight:600;">$</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $room->price) }}" required
                            style="width:100%; padding:10px 14px 10px 28px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none;">
                    </div>
                </div>
                <div>
                    <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Max Capacity <span style="color:red;">*</span></label>
                    <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" required
                        style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none;">
                </div>
            </div>
            <div style="margin-top:14px;">
                <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Features <span style="color:#6b7280; font-weight:400;">(comma-separated)</span></label>
                <input type="text" name="features" value="{{ old('features', $room->features ? implode(', ', $room->features) : '') }}"
                    style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none;">
            </div>
            <div style="margin-top:14px;">
                <label style="font-weight:600; color:#374151; font-size:0.9rem; display:block; margin-bottom:6px;">Description</label>
                <textarea name="description" rows="3"
                    style="width:100%; padding:10px 14px; border:1px solid #d1d5db; border-radius:8px; font-size:0.95rem; outline:none; resize:vertical;">{{ old('description', $room->description) }}</textarea>
            </div>
        </div>

        {{-- Images — single clean uploader --}}
        <div style="background:#fffaf8; border-radius:14px; padding:22px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:20px; border:1px solid #eae6f6;">
            <h3 style="color:#1e3a8a; font-weight:700; margin:0 0 18px; padding-bottom:10px; border-bottom:2px solid #eae6f6;">
                📷 Room Images
            </h3>

            {{-- Current images --}}
            @php
                $allCurrent = [];
                if ($room->image) $allCurrent[] = $room->image;
                if ($room->images) $allCurrent = array_merge($allCurrent, $room->images);
            @endphp

            @if(count($allCurrent) > 0)
                <div style="margin-bottom:16px;">
                    <div style="font-weight:600; color:#374151; font-size:0.9rem; margin-bottom:10px;">Current Images</div>
                    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(120px,1fr)); gap:10px;">
                        @foreach($allCurrent as $i => $img)
                            <div style="position:relative; border-radius:10px; overflow:hidden; aspect-ratio:1;">
                                <img src="{{ asset('storage/'.$img) }}"
                                     style="width:100%; height:100%; object-fit:cover; display:block;">
                                @if($i === 0)
                                    <div style="position:absolute; bottom:6px; left:6px; background:#4f46e5; color:white; font-size:0.7rem; font-weight:700; padding:2px 10px; border-radius:20px;">Cover</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <p style="color:#6b7280; font-size:0.85rem; margin-top:10px;">
                        Upload new images below to replace all current ones. Leave empty to keep existing.
                    </p>
                </div>
            @endif

            {{-- Uploader --}}
            <div id="uploadArea"
                 style="border:2px dashed #d1d5db; border-radius:12px; padding:20px; background:#f9fafb; min-height:140px;"
                 ondragover="event.preventDefault(); this.style.borderColor='#6366f1';"
                 ondragleave="this.style.borderColor='#d1d5db';"
                 ondrop="handleDrop(event)">

                <div id="topBar" style="display:none; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <span id="imageCount" style="color:#1e3a8a; font-weight:600; font-size:0.95rem;"></span>
                    <div style="display:flex; gap:16px;">
                        <span onclick="document.getElementById('allImagesInput').click()"
                              style="color:#4f46e5; font-weight:600; cursor:pointer; font-size:0.9rem;">+ Add more</span>
                        <span onclick="clearAll()"
                              style="color:#ef4444; font-weight:600; cursor:pointer; font-size:0.9rem;">✕ Clear all</span>
                    </div>
                </div>

                <div id="previewGrid"
                     style="display:grid; grid-template-columns:repeat(auto-fill,minmax(120px,1fr)); gap:12px; margin-bottom:8px;">
                </div>

                <div id="emptyPlaceholder" style="text-align:center; padding:16px 0;">
                    <div style="font-size:2rem;">🖼️</div>
                    <div style="color:#6b7280; margin-top:8px; font-size:0.9rem;">Click or drag to upload new images</div>
                    <div style="color:#9ca3af; font-size:0.8rem; margin-top:4px;">Up to 5 images · JPG, PNG, GIF · Max 2MB each</div>
                    <button type="button" onclick="document.getElementById('allImagesInput').click()"
                            style="margin-top:12px; background:#1e3a8a; color:white; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer;">
                        Choose Images
                    </button>
                </div>

                <div id="dropHint" style="display:none; text-align:center; color:#9ca3af; font-size:0.8rem; margin-top:4px;">
                    <span id="dropHintText"></span>
                </div>
            </div>

            <input type="file" id="allImagesInput" name="images[]" accept="image/*" multiple style="display:none;"
                   onchange="handleFiles(this.files)">
        </div>

        {{-- Buttons --}}
        <div style="display:flex; gap:12px; justify-content:flex-end;">
            <a href="{{ route('admin.rooms.index') }}"
               style="padding:12px 28px; background:#f3f4f6; color:#374151; border-radius:8px; text-decoration:none; font-weight:600;">
               Cancel
            </a>
            <button type="submit"
                    style="padding:12px 32px; background:linear-gradient(135deg,#1e3a8a,#2563eb); color:white; border:none; border-radius:8px; font-weight:700; font-size:1rem; cursor:pointer;">
                💾 Save Changes
            </button>
        </div>

    </form>
</div>

<script>
let selectedFiles = [];
const MAX = 5;

function updateUI() {
    const grid     = document.getElementById('previewGrid');
    const topBar   = document.getElementById('topBar');
    const empty    = document.getElementById('emptyPlaceholder');
    const dropHint = document.getElementById('dropHint');
    const countEl  = document.getElementById('imageCount');
    const dropText = document.getElementById('dropHintText');

    grid.innerHTML = '';

    if (selectedFiles.length === 0) {
        topBar.style.display   = 'none';
        empty.style.display    = 'block';
        dropHint.style.display = 'none';
        return;
    }

    topBar.style.display   = 'flex';
    empty.style.display    = 'none';
    dropHint.style.display = 'block';
    countEl.textContent    = selectedFiles.length + ' image' + (selectedFiles.length > 1 ? 's' : '') + ' selected';
    dropText.textContent   = selectedFiles.length + '/' + MAX + ' images · drag more to add';

    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'position:relative; border-radius:10px; overflow:hidden; aspect-ratio:1; background:#e5e7eb;';
            wrap.innerHTML = `
                <img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; display:block;">
                ${i === 0 ? `<div style="position:absolute; bottom:6px; left:6px; background:#4f46e5; color:white; font-size:0.7rem; font-weight:700; padding:2px 10px; border-radius:20px;">Cover</div>` : ''}
                <button type="button" onclick="removeImage(${i})"
                        style="position:absolute; top:5px; right:5px; background:rgba(0,0,0,0.55); color:white; border:none; border-radius:50%; width:22px; height:22px; font-size:0.75rem; cursor:pointer; font-weight:700;">✕</button>
            `;
            grid.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });

    if (selectedFiles.length < MAX) {
        const addTile = document.createElement('div');
        addTile.onclick = () => document.getElementById('allImagesInput').click();
        addTile.style.cssText = 'border:2px dashed #d1d5db; border-radius:10px; aspect-ratio:1; display:flex; flex-direction:column; align-items:center; justify-content:center; cursor:pointer; color:#9ca3af; background:#f9fafb;';
        addTile.innerHTML = '<span style="font-size:1.8rem;">+</span><span style="font-size:0.75rem; margin-top:4px;">Add</span>';
        grid.appendChild(addTile);
    }

    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('allImagesInput').files = dt.files;
}

function handleFiles(files) {
    const toAdd = Array.from(files).slice(0, MAX - selectedFiles.length);
    selectedFiles = [...selectedFiles, ...toAdd];
    updateUI();
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    updateUI();
}

function clearAll() {
    selectedFiles = [];
    updateUI();
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('uploadArea').style.borderColor = '#d1d5db';
    handleFiles(event.dataTransfer.files);
}
</script>

@endsection
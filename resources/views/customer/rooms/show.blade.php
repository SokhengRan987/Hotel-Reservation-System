@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@extends('layouts.customer')

@section('content')
            
<div style="background: #07132f; padding: 60px 0; min-height: 100vh;">
    <div class="container">
        <!-- page book form  -->
        <!-- Back Button -->
        <a href="{{ route('customer.rooms.index') }}" style="display: inline-block; color: #f3f5f9; font-weight: 600; margin-bottom: 30px;">
            <i class="fas fa-arrow-left"></i> Back to Rooms
        </a>

        <div class="row g-4">

            <!-- ── Room Image Gallery ── -->
            <div class="col-lg-6">
                @php
                    $allImages = [];
                    if ($room->image) $allImages[] = $room->image;
                    if ($room->images) $allImages = array_merge($allImages, $room->images);
                @endphp

                <div id="galleryWrap" style="border-radius:15px; overflow:hidden; box-shadow:0 8px 25px rgba(0,0,0,0.1); display:flex; flex-direction:column; height:100%;">

                    @if(count($allImages) > 0)
                        {{-- Main large image --}}
                        <div style="flex:1; min-height:0;">
                            <img id="mainImg"
                                 src="{{ asset('storage/'.$allImages[0]) }}"
                                 onclick="openLightbox(0)"
                                 style="width:100%; height:100%; object-fit:cover; display:block; cursor:zoom-in; min-height:320px;">
                        </div>

                        {{-- Thumbnail strip --}}
                        @if(count($allImages) > 1)
                            <div style="display:grid; grid-template-columns:repeat({{ min(count($allImages)-1, 4) }}, 1fr); gap:3px; background:#000;">
                                @foreach($allImages as $i => $img)
                                    @if($i > 0)
                                        <div style="position:relative; aspect-ratio:16/9; overflow:hidden;">
                                            <img src="{{ asset('storage/'.$img) }}"
                                                 onclick="switchMain('{{ asset('storage/'.$img) }}', {{ $i }})"
                                                 style="width:100%; height:100%; object-fit:cover; cursor:pointer; transition:opacity 0.2s; opacity:0.85;"
                                                 onmouseover="this.style.opacity='1'"
                                                 onmouseout="this.style.opacity='0.85'">
                                            @if($i === 4 && count($allImages) > 5)
                                                <div onclick="openLightbox(4)"
                                                     style="position:absolute; inset:0; background:rgba(0,0,0,0.55); display:flex; align-items:center; justify-content:center; color:white; font-size:1.4rem; font-weight:800; cursor:pointer;">
                                                    +{{ count($allImages) - 5 }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                    @else
                        <div style="flex:1; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#87CEEB,#FFB366); color:white; font-size:4rem; min-height:400px;">
                            <i class="fas fa-door-open"></i>
                        </div>
                    @endif

                </div>
            </div>

            <!-- ── Booking Panel ── -->
            <div class="col-lg-6">
                <div id="bookingPanel" style="background:white; border-radius:15px; padding:40px; box-shadow:0 8px 25px rgba(0,0,0,0.1);">

                    <h1 style="color:#1e3c72; font-weight:800;">Room #{{ $room->number }}</h1>
                    <p style="color:#ff9800; font-weight:600;">
                        <i class="fas fa-tag"></i> {{ $room->type ?? 'Premium Room' }}
                    </p>

                    <!-- Price -->
                    <div style="background:linear-gradient(135deg,#1e3c72,#2a5298); color:white; padding:20px; border-radius:10px; text-align:center; margin:25px 0;">
                        <small>Price Per Night</small>
                        <h2 style="color:#fff9c4; font-weight:800;">${{ number_format($room->price,2) }}</h2>
                    </div>

                    <!-- Info -->
                    <div style="background:#f8f9fa; padding:20px; border-left:4px solid #ff9800; border-radius:10px; margin-bottom:25px; color:#374151;">
                        <strong style="color:#374151;">Max Guests:</strong>
                        <span style="color:#111827; font-weight:700;"> {{ $room->capacity ?? 1 }}</span>
                        <br>
                        @php
                            $isBooked = $room->bookings()
                                ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                                ->where('start_date', '<', now()->addDays(1))
                                ->where('end_date', '>', now())
                                ->exists();
                        @endphp
                        <strong style="color:#374151;">Status:</strong>
                        <span id="roomStatus" style="font-weight:800; margin-left:6px;">
                            @if($isBooked)
                                <span style="color:#e53935;">Booked</span>
                            @else
                                <span style="color:#4caf50;">Available</span>
                            @endif
                        </span>
                    </div>

                    <!-- BOOKING FORM -->
                    <form id="bookingForm">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Check-in Date</label>
                            <input type="date" id="startDate" name="start_date"
                                   min="{{ now()->toDateString() }}" required class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Check-out Date</label>
                            <input type="date" id="endDate" name="end_date"
                                   min="{{ now()->addDay()->toDateString() }}" required class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Guests <span style="color:red;">*</span></label>
                            <input type="number" name="guest_count" value="1" min="1" max="{{ $room->capacity ?? 10 }}"
                                   placeholder="Number of guests"
                                   required class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Full Name <span style="color:red;">*</span></label>
                            <input type="text" name="full_name"
                                   placeholder="Enter your full name (matching your ID/passport)"
                                   required class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Email Address <span style="color:red;">*</span></label>
                            <input type="email" name="email"
                                   placeholder="Enter your email" required class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label style="font-size:15px; color:#ff9800; font-weight:bold;">Phone Number <span style="color:red;">*</span></label>
                            <input type="text" name="phone"
                                   placeholder="e.g. +855 12 345 678" required class="form-control">
                        </div>

                        <!-- Price Breakdown -->
                        <div id="priceBreakdown" style="background:#f0f7ff; padding:15px; border-radius:10px; margin-bottom:20px; display:none;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span style="color:#374151;">Nights: <strong id="nightsCount" style="color:#1e3c72;">0</strong></span>
                                <span>× $<strong>{{ number_format($room->price, 2) }}</strong></span>
                            </div>
                            <div style="border-top:1px solid #ddd; padding-top:10px; display:flex; justify-content:space-between; font-weight:bold; font-size:1.1em; color:#1e3c72;">
                                <span>Total Amount:</span>
                                <span style="color:#ff9800;">$<span id="totalAmount">0.00</span></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold" onclick="submitBooking(event)">
                            <i class="fas fa-credit-card"></i> Book Now & Pay
                        </button>
                    </form>

                    <!-- FEATURES -->
                    <div style="margin-top:30px; border-top:2px solid #eee; padding-top:20px; color:#374151;">
                        <h5 style="color:#1e3c72; font-weight:800; margin-bottom:12px;">Room Features</h5>
                        <ul style="list-style:none; padding:0;">
                            @if($room->features && count($room->features) > 0)
                                @foreach($room->features as $feature)
                                    <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">{{ $feature }}</span></li>
                                @endforeach
                            @else
                                <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">King-size Bed</span></li>
                                <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">Modern Bathroom</span></li>
                                <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">Air Conditioning</span></li>
                                <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">24/7 Room Service</span></li>
                                <li style="color:#374151; margin-bottom:6px;">✔ <span style="margin-left:6px;">Free Wi-Fi</span></li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Lightbox ── --}}
<div id="lightbox"
     onclick="closeLightbox()"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.92); z-index:9999; align-items:center; justify-content:center;">
    <div onclick="closeLightbox()"
         style="position:absolute; top:20px; right:28px; color:white; font-size:2rem; cursor:pointer; font-weight:700; z-index:10000;">✕</div>
    <div onclick="event.stopPropagation(); changeLight(-1)"
         style="position:absolute; left:20px; color:white; font-size:3rem; cursor:pointer; user-select:none; z-index:10000;">&#8249;</div>
    <img id="lightboxImg" src=""
         onclick="event.stopPropagation()"
         style="max-width:90vw; max-height:88vh; object-fit:contain; border-radius:10px;">
    <div onclick="event.stopPropagation(); changeLight(1)"
         style="position:absolute; right:20px; color:white; font-size:3rem; cursor:pointer; user-select:none; z-index:10000;">&#8250;</div>
    <div id="lightboxCounter"
         style="position:absolute; bottom:20px; left:50%; transform:translateX(-50%); color:white; font-size:0.9rem; background:rgba(0,0,0,0.5); padding:4px 16px; border-radius:20px;"></div>
</div>

<script>
const allImages = {!! json_encode(array_map(fn($img) => asset('storage/'.$img), $allImages)) !!};
let currentLight = 0;
const roomPrice = parseFloat("{{ $room->price }}");
let disabledDates = [];
let initialRoomStatusText = null;
let initialRoomStatusColor = null;

// Match gallery height to booking panel
function matchHeight() {
    const panel   = document.getElementById('bookingPanel');
    const gallery = document.getElementById('galleryWrap');
    if (panel && gallery && window.innerWidth >= 992) {
        gallery.style.height = panel.offsetHeight + 'px';
    }
}
window.addEventListener('load', matchHeight);
window.addEventListener('resize', matchHeight);

// Switch main image on thumbnail click
function switchMain(src, index) {
    document.getElementById('mainImg').src = src;
    currentLight = index;
}

// Lightbox
function openLightbox(index) {
    currentLight = index;
    document.getElementById('lightboxImg').src = allImages[index];
    document.getElementById('lightboxCounter').textContent = (index + 1) + ' / ' + allImages.length;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}

function changeLight(dir) {
    currentLight = (currentLight + dir + allImages.length) % allImages.length;
    document.getElementById('lightboxImg').src = allImages[currentLight];
    document.getElementById('lightboxCounter').textContent = (currentLight + 1) + ' / ' + allImages.length;
}

document.addEventListener('keydown', e => {
    if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'ArrowRight') changeLight(1);
        if (e.key === 'ArrowLeft')  changeLight(-1);
        if (e.key === 'Escape')     closeLightbox();
    }
});

// Disabled dates
document.addEventListener('DOMContentLoaded', function () {
    fetchDisabledDates();
    document.getElementById('startDate').addEventListener('change', calculatePrice);
    document.getElementById('endDate').addEventListener('change', calculatePrice);
    // capture initial status so we can revert when no dates selected
    const statusEl = document.getElementById('roomStatus');
    if (statusEl) {
        initialRoomStatusText = statusEl.textContent.trim();
        initialRoomStatusColor = getComputedStyle(statusEl).color;
    }
});

function fetchDisabledDates() {
    fetch("{{ route('customer.rooms.disabled-dates', $room->id) }}")
        .then(res => res.json())
        .then(data => { disabledDates = data.disabled_dates; })
        .catch(err => console.error('Error fetching disabled dates:', err));
}

function validateDate(input) {
    if (disabledDates.includes(input.value)) {
        input.value = '';
        alert('This date is not available. Please select another date.');
    }
}

function calculatePrice() {
    const startDate = document.getElementById('startDate').value;
    const endDate   = document.getElementById('endDate').value;
    const breakdown = document.getElementById('priceBreakdown');
    if (startDate && endDate) {
        const start  = new Date(startDate);
        const end    = new Date(endDate);
        if (end <= start) { breakdown.style.display = 'none'; return; }
        const nights = Math.floor((end - start) / (1000 * 60 * 60 * 24));
        document.getElementById('nightsCount').textContent  = nights;
        document.getElementById('totalAmount').textContent  = (nights * roomPrice).toFixed(2);
        breakdown.style.display = 'block';

        // Update room status based on selected date range vs disabledDates
        const statusEl = document.getElementById('roomStatus');
        if (statusEl) {
            const s = new Date(startDate);
            const e = new Date(endDate);
            // iterate each date from s (inclusive) to the day before e
            let blocked = false;
            for (let d = new Date(s); d < e; d.setDate(d.getDate() + 1)) {
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');
                const ds = `${yyyy}-${mm}-${dd}`;
                if (disabledDates.includes(ds)) { blocked = true; break; }
            }
            if (blocked) {
                statusEl.innerHTML = '<span style="color:#e53935; font-weight:800;">Booked</span>';
            } else {
                statusEl.innerHTML = '<span style="color:#4caf50; font-weight:800;">Available</span>';
            }
        }
    } else {
        breakdown.style.display = 'none';
        // restore initial status when no full date range selected
        const statusEl = document.getElementById('roomStatus');
        if (statusEl && initialRoomStatusText !== null) {
            statusEl.textContent = initialRoomStatusText;
            statusEl.style.color = initialRoomStatusColor;
        }
    }
}

function submitBooking(e) {
    e.preventDefault();
    const form = document.getElementById('bookingForm');
    const btn  = e.target;
    const data = new FormData(form);
    btn.disabled = true;
    btn.innerHTML = 'Processing...';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch("{{ route('customer.bookings.store') }}", {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: data
    })
    .then(async res => { const json = await res.json(); if (!res.ok) throw json; return json; })
    .then(res => { window.location.href = res.redirect; })
    .catch(err => {
        let msg = 'Booking failed. ';
        if (err.errors)      msg += Object.values(err.errors)[0][0];
        else if (err.error)  msg += err.error;
        else if (err.message) msg += err.message;
        else msg += 'Please check your details and try again.';
        alert(msg);
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-credit-card"></i> Book Now & Pay';
    });
}
</script>
@endsection
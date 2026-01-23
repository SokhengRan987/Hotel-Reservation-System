@extends('layouts.customer')

@section('content')
<div style="background: linear-gradient(135deg, #e3f2fd 0%, #fff3e0 100%); padding: 60px 0; min-height: 100vh;">
    <div class="container">

        <!-- Back Button -->
        <a href="{{ route('customer.rooms.index') }}" style="display: inline-block; color: #1e3c72; font-weight: 600; margin-bottom: 30px;">
            <i class="fas fa-arrow-left"></i> Back to Rooms
        </a>

        <div class="row g-4">
            <!-- Room Image -->
            <div class="col-lg-6">
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1);">
                    @if($room->image)
                        <img src="{{ asset('storage/'.$room->image) }}" alt="Room {{ $room->number }}" style="width:100%; height:400px; object-fit:cover;">
                    @else
                        <div style="height:400px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#87CEEB,#FFB366); color:white; font-size:4rem;">
                            <i class="fas fa-door-open"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Panel -->
            <div class="col-lg-6">
                <div style="background:white; border-radius:15px; padding:40px; box-shadow:0 8px 25px rgba(0,0,0,0.1);">

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
                    <div style="background:#f8f9fa; padding:20px; border-left:4px solid #ff9800; border-radius:10px; margin-bottom:25px;">
                        <strong>Max Guests:</strong> {{ $room->capacity ?? 1 }} <br>
                        <strong>Status:</strong> <span style="color:#4caf50;">Available</span>
                    </div>

                    <!-- BOOKING FORM -->
                    <form id="bookingForm">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div style="margin-bottom:15px;">
                            <label>Check-in Date</label>
                            <input type="date"
                                   id="startDate"
                                   name="start_date"
                                   min="{{ now()->toDateString() }}"
                                   required
                                   class="form-control">
                        </div>

                        <div style="margin-bottom:15px;">
                            <label>Check-out Date</label>
                            <input type="date"
                                   id="endDate"
                                   name="end_date"
                                   min="{{ now()->addDay()->toDateString() }}"
                                   required
                                   class="form-control">
                        </div>

                        <div style="margin-bottom:25px;">
                            <label>Guests</label>
                            <input type="number"
                                   name="guest_count"
                                   min="1"
                                   max="{{ $room->capacity ?? 1 }}"
                                   value="1"
                                   required
                                   class="form-control">
                        </div>

                        <!-- Price Breakdown -->
                        <div style="background:#f0f7ff; padding:15px; border-radius:10px; margin-bottom:20px; display:none;" id="priceBreakdown">
                            <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                                <span>Nights: <strong id="nightsCount">0</strong></span>
                                <span>× $<strong>{{ number_format($room->price, 2) }}</strong></span>
                            </div>
                            <div style="border-top:1px solid #ddd; padding-top:10px; display:flex; justify-content:space-between; font-weight:bold; font-size:1.1em; color:#1e3c72;">
                                <span>Total Amount:</span>
                                <span style="color:#ff9800;">$<span id="totalAmount">0.00</span></span>
                            </div>
                        </div>

                        <button type="submit"
                                class="btn btn-warning w-100 fw-bold"
                                onclick="submitBooking(event)">
                            <i class="fas fa-credit-card"></i> Book Now & Pay
                        </button>
                    </form>

                    <!-- FEATURES -->
                    <div style="margin-top:30px; border-top:2px solid #eee; padding-top:20px;">
                        <h5>Room Features</h5>
                        <ul style="list-style:none; padding:0;">
                            <li>✔ King-size Bed</li>
                            <li>✔ Modern Bathroom</li>
                            <li>✔ Air Conditioning</li>
                            <li>✔ 24/7 Room Service</li>
                            <li>✔ Free Wi-Fi</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fetch disabled dates on page load
let disabledDates = [];
const roomPrice = parseFloat("{{ $room->price }}");

document.addEventListener('DOMContentLoaded', function() {
    fetchDisabledDates();
    
    // Add event listeners for date and price calculation
    document.getElementById('startDate').addEventListener('change', calculatePrice);
    document.getElementById('endDate').addEventListener('change', calculatePrice);
});

// Fetch disabled dates from API
function fetchDisabledDates() {
    fetch("{{ route('customer.rooms.disabled-dates', $room->id) }}")
        .then(res => res.json())
        .then(data => {
            disabledDates = data.disabled_dates;
            // Apply validation to date inputs
            applyDateValidation();
        })
        .catch(err => console.error('Error fetching disabled dates:', err));
}

// Apply date validation
function applyDateValidation() {
    const startInput = document.getElementById('startDate');
    const endInput = document.getElementById('endDate');
    
    // Set validation attributes
    startInput.addEventListener('input', function() {
        validateDate(this, 'start');
    });
    
    endInput.addEventListener('input', function() {
        validateDate(this, 'end');
    });
}

// Validate if selected date is disabled
function validateDate(input, type) {
    const selectedDate = input.value;
    if (disabledDates.includes(selectedDate)) {
        input.value = '';
        alert('This date is not available. Please select another date.');
    }
}

// Calculate and display price
function calculatePrice() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const priceBreakdown = document.getElementById('priceBreakdown');
    
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        
        if (end <= start) {
            priceBreakdown.style.display = 'none';
            return;
        }
        
        // Calculate nights
        const nights = Math.floor((end - start) / (1000 * 60 * 60 * 24));
        const total = nights * roomPrice;
        
        // Update display
        document.getElementById('nightsCount').textContent = nights;
        document.getElementById('totalAmount').textContent = total.toFixed(2);
        priceBreakdown.style.display = 'block';
    } else {
        priceBreakdown.style.display = 'none';
    }
}

function submitBooking(e) {
    e.preventDefault();

    const form = document.getElementById('bookingForm');
    const btn = e.target;
    const data = new FormData(form);

    btn.disabled = true;
    btn.innerHTML = 'Processing...';

    fetch("{{ route('customer.bookings.store') }}", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: data
    })
    .then(async res => {
        const json = await res.json();
        if (!res.ok) throw json;
        return json;
    })
    .then(res => {
        window.location.href = res.checkout_url;
    })
    .catch(err => {
        console.error('Booking Error:', err); // Log to browser console for debugging
        
        let errorMessage = 'Booking failed. ';
        
        // Check for validation errors
        if (err.errors) {
            const errors = err.errors;
            if (errors.start_date) errorMessage += errors.start_date[0];
            else if (errors.end_date) errorMessage += errors.end_date[0];
            else if (errors.room_id) errorMessage += errors.room_id[0];
            else if (errors.guest_count) errorMessage += errors.guest_count[0];
            else errorMessage += Object.values(errors)[0][0];
        } else if (err.error) {
            errorMessage += err.error;
        } else if (err.message) {
            errorMessage += err.message;
        } else {
            errorMessage += 'Please check your booking details and try again.';
        }
        
        alert(errorMessage);
        btn.disabled = false;
        btn.innerHTML = 'Book Now & Pay';
    });
}
</script>
@endsection

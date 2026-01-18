@extends('layouts.customer')

@section('content')
<div style="background: linear-gradient(135deg, #e3f2fd 0%, #fff3e0 100%); padding: 60px 0; min-height: 100vh;">
    <div class="container">
        <!-- Back Button -->
        <a href="{{ route('customer.rooms.index') }}" style="display: inline-block; color: #1e3c72; text-decoration: none; font-weight: 600; margin-bottom: 30px; transition: all 0.3s ease;">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Rooms
        </a>

        <div class="row g-4">
            <!-- Room Image Section -->
            <div class="col-lg-6">
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); height: 100%; display: flex; align-items: center; justify-content: center;">
                    @if($room->image)
                        <img src="{{ asset('storage/'.$room->image) }}" alt="Room {{ $room->number }}" style="width: 100%; height: 100%; object-fit: cover; min-height: 400px;">
                    @else
                        <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #87CEEB, #FFB366); display: flex; align-items: center; justify-content: center; font-size: 5rem; color: white;">
                            <i class="fas fa-door-open"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Section -->
            <div class="col-lg-6">
                <div style="background: white; border-radius: 15px; padding: 40px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); height: 100%;">
                    
                    <!-- Room Title -->
                    <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e3c72; margin-bottom: 20px;">
                        Room #{{ $room->number }}
                    </h1>

                    <!-- Room Type -->
                    <p style="font-size: 1.1rem; color: #ff9800; font-weight: 600; margin-bottom: 20px;">
                        <i class="fas fa-tag"></i> {{ $room->type ?? 'Premium Room' }}
                    </p>

                    <!-- Price Display -->
                    <div style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; text-align: center;">
                        <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 0.9rem; margin-bottom: 5px;">Price Per Night</p>
                        <h2 style="font-size: 2.5rem; font-weight: 800; margin: 0; color: #fff9c4;">${{ number_format($room->price, 2) }}</h2>
                    </div>

                    <!-- Room Details -->
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px; border-left: 4px solid #ff9800;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <p style="color: #666; margin: 0; font-size: 0.9rem;">Max Guests</p>
                                <p style="font-size: 1.3rem; font-weight: 700; color: #1e3c72; margin: 0;">{{ $room->max_adults }} Adults</p>
                            </div>
                            <div>
                                <p style="color: #666; margin: 0; font-size: 0.9rem;">Room Status</p>
                                <p style="font-size: 1.1rem; font-weight: 700; color: #4caf50; margin: 0;">
                                    <i class="fas fa-check-circle"></i> Available
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <form id="bookingForm" style="margin-bottom: 30px;">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <!-- Check-in Date -->
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #1e3c72; margin-bottom: 8px;">
                                <i class="fas fa-calendar-check"></i> Check-in Date
                            </label>
                            <input type="date" name="start_date" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="form-input">
                        </div>

                        <!-- Check-out Date -->
                        <div style="margin-bottom: 30px;">
                            <label style="display: block; font-weight: 600; color: #1e3c72; margin-bottom: 8px;">
                                <i class="fas fa-calendar-times"></i> Check-out Date
                            </label>
                            <input type="date" name="end_date" required style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; transition: all 0.3s ease;" class="form-input">
                        </div>

                        <!-- Book Now Button -->
                        <button type="submit" onclick="submitBooking(event)" style="width: 100%; background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%); color: white; padding: 15px; border: none; border-radius: 25px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;" class="book-now-btn">
                            <i class="fas fa-credit-card"></i> Book Now & Pay
                        </button>
                    </form>

                    <!-- Room Features -->
                    <div style="border-top: 2px solid #e0e0e0; padding-top: 20px;">
                        <h3 style="font-size: 1.2rem; font-weight: 700; color: #1e3c72; margin-bottom: 15px;">Room Features</h3>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 8px 0; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #ff9800; margin-right: 10px; font-weight: 700;"></i>
                                Comfortable King-size Bed
                            </li>
                            <li style="padding: 8px 0; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #ff9800; margin-right: 10px; font-weight: 700;"></i>
                                Modern Bathroom with Shower
                            </li>
                            <li style="padding: 8px 0; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #ff9800; margin-right: 10px; font-weight: 700;"></i>
                                Air Conditioning & Heating
                            </li>
                            <li style="padding: 8px 0; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #ff9800; margin-right: 10px; font-weight: 700;"></i>
                                24/7 Room Service
                            </li>
                            <li style="padding: 8px 0; color: #666; display: flex; align-items: center;">
                                <i class="fas fa-check" style="color: #ff9800; margin-right: 10px; font-weight: 700;"></i>
                                Free WiFi Throughout
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-input:focus {
        border-color: #ff9800 !important;
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1);
    }

    .book-now-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(255, 152, 0, 0.3);
    }

    .book-now-btn:active {
        transform: translateY(-1px);
    }
</style>

<script>
function submitBooking(e) {
    e.preventDefault();
    
    const startDate = document.querySelector('input[name="start_date"]').value;
    const endDate = document.querySelector('input[name="end_date"]').value;
    
    if (!startDate || !endDate) {
        alert('Please select both check-in and check-out dates');
        return;
    }
    
    if (new Date(startDate) >= new Date(endDate)) {
        alert('Check-out date must be after check-in date');
        return;
    }
    
    let form = document.getElementById('bookingForm');
    let data = new FormData(form);

    // Show loading state
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;

    fetch("{{ route('customer.bookings.store') }}", {
        method: "POST",
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: data
    })
    .then(res => res.json())
    .then(response => {
        if (response.checkout_url) {
            window.location.href = response.checkout_url;
        } else {
            alert(response.error || 'Booking failed. Please try again.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>
@endsection

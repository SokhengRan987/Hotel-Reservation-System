@extends('layouts.customer')

@section('content')

<!-- Room List Section '
  Room number
    Price
    Guests
    "Book Now" button-->

<div style="background: linear-gradient(135deg, #e3f2fd 0%, #fff3e0 100%); padding: 80px 0;">
    <div class="container">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 60px;">
            <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e3c72; margin-bottom: 10px;">Our Exquisite Rooms</h1>
            <p style="font-size: 1.2rem; color: #666;">Discover your perfect sanctuary at Sunset Heaven Resort</p>
        </div>

        <!-- Rooms Grid -->
        <div class="row g-4">
            @foreach($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; height: 100%;" class="room-card-hover">
                        
                        <!-- Room Image -->
                        <div style="width: 100%; height: 250px; background: linear-gradient(135deg, #87CEEB, #FFB366); display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; overflow: hidden; position: relative;">
                            @if($room->image)
                                <img src="{{ asset('storage/'.$room->image) }}" alt="Room {{ $room->number }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-door-open"></i>
                            @endif
                        </div>

                        <!-- Room Info -->
                        <div style="padding: 30px;">
                            <h3 style="font-size: 1.5rem; font-weight: 700; color: #1e3c72; margin-bottom: 10px;">
                                Room #{{ $room->number }}
                            </h3>
                            
                            <p style="color: #666; margin-bottom: 15px; font-size: 0.95rem;">
                                <i class="fas fa-door-open"></i> {{ $room->type ?? 'Standard Room' }}
                            </p>

                            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span style="color: #666;">Max Guests</span>
                                    <span style="font-weight: 700; color: #1e3c72;">{{ $room->max_adults }} Adults</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #666;">Price per Night</span>
                                    <span style="font-size: 1.3rem; font-weight: 700; color: #ff9800;">${{ number_format($room->price, 2) }}</span>
                                </div>
                            </div>

                            <!-- Features List -->
                            <div style="margin-bottom: 20px;">
                                <p style="font-size: 0.9rem; color: #666; line-height: 1.8; margin: 0;">
                                    <i class="fas fa-check" style="color: #ff9800; margin-right: 8px;"></i>Comfortable Bedding<br>
                                    <i class="fas fa-check" style="color: #ff9800; margin-right: 8px;"></i>Modern Amenities<br>
                                    <i class="fas fa-check" style="color: #ff9800; margin-right: 8px;"></i>24/7 Service
                                </p>
                            </div>

                            <!-- Book Button -->
                            <a href="{{ route('customer.rooms.show', $room->id) }}" style="display: block; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 12px; text-align: center; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.3s ease; text-decoration: none; border: none; width: 100%;" class="book-btn">
                                Book Now <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Rooms Message -->
        @if($rooms->isEmpty())
            <div style="text-align: center; padding: 60px 20px;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 20px;"></i>
                <h3 style="color: #999;">No Rooms Available</h3>
                <p style="color: #bbb;">Please check back soon for available rooms.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .room-card-hover {
        transform: translateY(0);
    }
    
    .room-card-hover:hover {
        transform: translateY(-15px);
        box-shadow: 0 15px 50px rgba(255, 152, 0, 0.2) !important;
    }

    .book-btn:hover {
        background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%) !important;
        transform: translateY(-2px);
    }
</style>
@endsection

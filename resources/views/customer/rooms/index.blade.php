@extends('layouts.customer')

@section('content')

{{-- Page Header --}}
<section style="background:linear-gradient(135deg,#02081c 0%,#07132f 100%); padding:80px 0 50px; border-bottom:1px solid rgba(215,170,70,0.15);">
    <div class="container" style="text-align:center;">
        <span style="color:#d7aa46; font-size:0.78rem; font-weight:700; letter-spacing:3px; text-transform:uppercase;">Our Accommodations</span>
        <h1 style="font-family:'Times New Roman',serif; font-size:clamp(2.2rem,5vw,3.5rem); color:white; margin:16px 0 12px;">Our Exquisite Rooms</h1>
        <div style="width:60px; height:2px; background:linear-gradient(90deg,transparent,#d7aa46,transparent); margin:0 auto 20px;"></div>
        <p style="color:rgba(255,255,255,0.6); font-size:1rem; max-width:520px; margin:0 auto;">
            Choose from our collection of carefully designed rooms and suites for an unforgettable stay.
        </p>
    </div>
</section>

{{-- Rooms Grid --}}
<section style="background:#02081c; padding:60px 0 80px;">
    <div class="container">
        <div class="row g-4">
            @foreach($rooms as $room)
                @php
                    $thumb = $room->image ?? ($room->images[0] ?? null);
                    $isBooked = $room->bookings->isNotEmpty();
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div style="background:#07132f; border:1px solid rgba(215,170,70,0.12); border-radius:6px; overflow:hidden; height:100%; transition:all 0.3s;" class="room-card">

                        {{-- Image --}}
                        <div style="position:relative; height:240px; overflow:hidden;">
                            @if($thumb)
                                <img src="{{ asset('storage/'.$thumb) }}" alt="Room {{ $room->number }}"
                                     style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s;" class="room-img">
                            @else
                                <div style="width:100%; height:100%; background:linear-gradient(135deg,#0d2045,#1a3a6e); display:flex; align-items:center; justify-content:center; font-size:4rem;">🏨</div>
                            @endif

                            {{-- Status badge --}}
                            <div style="position:absolute; top:14px; left:14px;">
                                @if($isBooked)
                                    <span style="background:rgba(220,38,38,0.88); color:white; padding:4px 14px; border-radius:20px; font-size:0.75rem; font-weight:700; backdrop-filter:blur(4px);">● Booked</span>
                                @else
                                    <span style="background:rgba(215,170,70,0.92); color:#081025; padding:4px 14px; border-radius:20px; font-size:0.75rem; font-weight:700; backdrop-filter:blur(4px);">● Available</span>
                                @endif
                            </div>

                            {{-- Price overlay --}}
                            <div style="position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(2,8,28,0.9)); padding:24px 20px 14px;">
                                <span style="color:rgba(255,255,255,0.6); font-size:0.75rem;">From </span>
                                <span style="color:#d7aa46; font-size:1.5rem; font-weight:800;">${{ number_format($room->price,2) }}</span>
                                <span style="color:rgba(255,255,255,0.5); font-size:0.78rem;"> /night</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div style="padding:24px;">
                            <div style="color:rgba(215,170,70,0.7); font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:8px;">
                                {{ $room->type ?? 'Standard Room' }}
                            </div>
                            <h3 style="color:white; font-family:'Times New Roman',serif; font-size:1.4rem; margin-bottom:14px;">
                                Room #{{ $room->number }}
                            </h3>

                            <div style="display:flex; gap:16px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(215,170,70,0.1);">
                                <span style="color:rgba(255,255,255,0.5); font-size:0.82rem;">👥 {{ $room->max_adults }} Adults</span>
                            </div>

                            {{-- Features --}}
                            <div style="margin-bottom:22px;">
                                @if($room->features && count($room->features) > 0)
                                    @foreach(array_slice($room->features, 0, 3) as $f)
                                        <div style="color:rgba(255,255,255,0.55); font-size:0.82rem; margin-bottom:5px;">
                                            <span style="color:#d7aa46; margin-right:8px;">✓</span>{{ $f }}
                                        </div>
                                    @endforeach
                                @else
                                    <div style="color:rgba(255,255,255,0.55); font-size:0.82rem; margin-bottom:5px;"><span style="color:#d7aa46; margin-right:8px;">✓</span>Comfortable Bedding</div>
                                    <div style="color:rgba(255,255,255,0.55); font-size:0.82rem; margin-bottom:5px;"><span style="color:#d7aa46; margin-right:8px;">✓</span>Modern Amenities</div>
                                    <div style="color:rgba(255,255,255,0.55); font-size:0.82rem;"><span style="color:#d7aa46; margin-right:8px;">✓</span>24/7 Service</div>
                                @endif
                            </div>

                            {{-- Button --}}
                            @if($isBooked)
                                <div style="width:100%; background:rgba(255,255,255,0.06); color:rgba(255,255,255,0.3); padding:12px; text-align:center; border-radius:4px; font-weight:600; cursor:not-allowed; font-size:0.88rem; letter-spacing:1px;">
                                    NOT AVAILABLE
                                </div>
                            @else
                                <a href="{{ route('customer.rooms.show', $room->id) }}"
                                    style="display:block; width:100%; background:linear-gradient(135deg,#e2b24e,#c59629); color:#081025; padding:14px; text-align:center; border-radius:4px; font-weight:700; text-decoration:none; font-size:0.88rem; letter-spacing:1.5px; text-transform:uppercase; transition:all 0.3s; box-sizing:border-box;"
                                    class="book-btn">
                                     View Details →
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        {{-- No Rooms --}}
        @if($rooms->isEmpty())
            <div style="text-align:center; padding:80px 0; color:rgba(255,255,255,0.4);">
                <div style="font-size:4rem; margin-bottom:20px;">🏨</div>
                <h3 style="color:rgba(255,255,255,0.6);">No Rooms Available</h3>
                <p>Please check back soon.</p>
            </div>
        @endif

        {{-- Pagination --}}
        <div style="margin-top:40px; text-align:center;">
            {{ $rooms->links() }}
        </div>
    </div>
</section>

<style>
.room-card:hover {
    border-color: rgba(215,170,70,0.35) !important;
    transform: translateY(-8px);
    box-shadow: 0 24px 60px rgba(0,0,0,0.5);
}
.room-card:hover .room-img { transform: scale(1.07); }
.book-btn:hover {
    background: linear-gradient(135deg,#f0c060,#d7aa46) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(215,170,70,0.3);
}
</style>

@endsection
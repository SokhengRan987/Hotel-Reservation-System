@extends('layouts.customer')

@section('content')

{{-- ══════════════════════════════════════════
    HERO
══════════════════════════════════════════ --}}
<section style="position:relative; height:100vh; min-height:620px; overflow:hidden; display:flex; align-items:center;">

    {{-- Background image --}}
    <video autoplay muted loop playsinline
       style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; z-index:0;">
    <source src="{{ asset('image/hero.mp4') }}" type="video/mp4">
     </video>
    {{-- Overlay --}}
    <div style="position:absolute; inset:0; background:linear-gradient(135deg, rgba(17, 36, 96, 0.82) 0%, rgba(12, 30, 73, 0.65) 60%, rgba(15, 33, 92, 0.5) 100%); z-index:1;"></div>

    <div class="container" style="position:relative; z-index:2; text-align:center;">

        <div style="display:inline-block; border:1px solid rgba(215,170,70,0.5); padding:6px 22px; border-radius:30px; margin-bottom:24px;">
            <span style="color:#d7aa46; font-size:0.78rem; font-weight:700; letter-spacing:3px; text-transform:uppercase;">Welcome to</span>
        </div>

        <h1 style="font-family:'Times New Roman', serif; font-size:clamp(2.8rem, 7vw, 5.5rem); font-weight:700; color:white; line-height:1.1; margin-bottom:16px; text-shadow:0 4px 30px rgba(0,0,0,0.4);">
            Sunset Heaven<br><span style="color:#d7aa46;">Resort</span>
        </h1>

        <div style="width:80px; height:2px; background:linear-gradient(90deg, transparent, #d7aa46, transparent); margin:0 auto 24px;"></div>

        <p style="color:rgba(255,255,255,0.85); font-size:clamp(1rem, 2.5vw, 1.25rem); max-width: 560px; margin:0 auto 40px; line-height:1.7;">
            Where the ocean meets elegance. Unwind in our exquisite suites and create unforgettable memories.
        </p>

        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('customer.rooms.index') }}"
               style="background:linear-gradient(135deg,#e2b24e,#c59629); color:#081025; padding:15px 38px; border-radius:4px; font-weight:700; font-size:0.95rem; letter-spacing:1.5px; text-transform:uppercase; text-decoration:none; transition:all 0.3s;">
                Book Your Stay
            </a>
            <a href="#about"
               style="border:1px solid rgba(215,170,70,0.6); color:white; padding:15px 38px; border-radius:4px; font-weight:600; font-size:0.95rem; letter-spacing:1px; text-transform:uppercase; text-decoration:none; transition:all 0.3s;">
                Discover More
            </a>
        </div>

    </div>

    {{-- Scroll indicator --}}
    <div style="position:absolute; bottom:30px; left:50%; transform:translateX(-50%); z-index:2; animation:bounce 2s infinite;">
        <div style="width:28px; height:44px; border:2px solid rgba(215,170,70,0.5); border-radius:14px; display:flex; justify-content:center; padding-top:7px;">
            <div style="width:4px; height:10px; background:#d7aa46; border-radius:2px; animation:scroll 2s infinite;"></div>
        </div>
    </div>

</section>

{{-- ══════════════════════════════════════════
    FEATURES BAR
══════════════════════════════════════════ --}}
<section style="background:#07132f; border-top:1px solid rgba(215,170,70,0.15); border-bottom:1px solid rgba(215,170,70,0.15); padding:40px 0;">
    <div class="container">
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:30px; text-align:center;">
            @foreach([
                ['🛏️','Luxurious Rooms','Premium comfort'],
                ['🌅','Ocean View','Breathtaking sunsets'],
                ['🍽️','World Class Service','At your service'],
                ['🧘','Relax & Unwind','Spa & Wellness'],
            ] as $f)
            <div>
                <div style="font-size:2rem; margin-bottom:10px;">{{ $f[0] }}</div>
                <div style="color:#d7aa46; font-weight:700; font-size:0.95rem; margin-bottom:4px;">{{ $f[1] }}</div>
                <div style="color:rgba(255,255,255,0.55); font-size:0.82rem;">{{ $f[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
    ABOUT
══════════════════════════════════════════ --}}
<section id="about" style="padding:100px 0; background:#02081c;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div style="position:relative;">
                    <img src="{{ asset('image/hero.png') }}" alt="Resort"
                         style="width:100%; height:480px; object-fit:cover; border-radius:4px;">
                    <div style="position:absolute; bottom:-24px; right:-24px; background:#d7aa46; padding:28px 32px; border-radius:4px; text-align:center;">
                        <div style="font-size:2.2rem; font-weight:800; color:#081025; line-height:1;">10+</div>
                        <div style="font-size:0.8rem; font-weight:700; color:#081025; letter-spacing:1px; text-transform:uppercase;">Years of<br>Excellence</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <span style="color:#d7aa46; font-size:0.78rem; font-weight:700; letter-spacing:3px; text-transform:uppercase;">About Our Resort</span>
                <h2 style="font-family:'Times New Roman',serif; font-size:clamp(2rem,4vw,3rem); color:white; margin:16px 0 24px; line-height:1.2;">
                    A Paradise Built<br>for Memories
                </h2>
                <div style="width:50px; height:2px; background:#d7aa46; margin-bottom:28px;"></div>
                <p style="color:rgba(255,255,255,0.7); line-height:1.9; margin-bottom:16px;">
                    Sunset Heaven Resort offers an unparalleled blend of luxury, comfort, and natural beauty. Our beachfront paradise is designed for those who seek relaxation, adventure, and unforgettable experiences.
                </p>
                <p style="color:rgba(255,255,255,0.7); line-height:1.9; margin-bottom:36px;">
                    From our world-class spa to our gourmet dining experiences, every moment at Sunset Heaven is crafted to exceed your expectations.
                </p>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:36px;">
                    @foreach([['50+','Luxury Rooms'],['1000+','Happy Guests'],['24/7','Premium Support'],['5★','Guest Rating']] as $s)
                    <div style="border:1px solid rgba(215,170,70,0.2); padding:20px; border-radius:4px;">
                        <div style="font-size:1.8rem; font-weight:800; color:#d7aa46;">{{ $s[0] }}</div>
                        <div style="color:rgba(255,255,255,0.6); font-size:0.85rem; margin-top:4px;">{{ $s[1] }}</div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('customer.rooms.index') }}"
                   style="background:linear-gradient(135deg,#e2b24e,#c59629); color:#081025; padding:14px 32px; border-radius:4px; font-weight:700; text-decoration:none; display:inline-block; letter-spacing:1px; text-transform:uppercase; font-size:0.88rem;">
                    Explore Rooms
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
    FEATURED ROOMS
══════════════════════════════════════════ --}}
<section style="padding:100px 0; background:#050d1f;">
    <div class="container">
        <div style="text-align:center; margin-bottom:60px;">
            <span style="color:#d7aa46; font-size:0.78rem; font-weight:700; letter-spacing:3px; text-transform:uppercase;">Our Accommodations</span>
            <h2 style="font-family:'Times New Roman',serif; font-size:clamp(2rem,4vw,3rem); color:white; margin:16px 0 12px;">Featured Rooms & Suites</h2>
            <p style="color:rgba(255,255,255,0.55); max-width:500px; margin:0 auto;">Choose from our collection of carefully designed rooms and suites for an unforgettable stay.</p>
        </div>

        <div class="row g-4">
            @foreach($featuredRooms as $room)
                @php
                    $thumb = $room->image ?? ($room->images[0] ?? null);
                    $isBooked = $room->bookings->isNotEmpty();
                @endphp
                <div class="col-md-6 col-lg-3">
                    <div style="background:#07132f; border:1px solid rgba(215,170,70,0.12); border-radius:4px; overflow:hidden; transition:all 0.3s;" class="room-featured-card">
                        <div style="position:relative; height:200px; overflow:hidden;">
                            @if($thumb)
                                <img src="{{ asset('storage/'.$thumb) }}" alt="Room {{ $room->number }}"
                                     style="width:100%; height:100%; object-fit:cover; transition:transform 0.4s;">
                            @else
                                <div style="width:100%; height:100%; background:linear-gradient(135deg,#0d2045,#1a3a6e); display:flex; align-items:center; justify-content:center; font-size:3rem;">🏨</div>
                            @endif
                            <div style="position:absolute; top:12px; left:12px;">
                                @if($isBooked)
                                    <span style="background:rgba(220,38,38,0.85); color:white; padding:3px 12px; border-radius:20px; font-size:0.75rem; font-weight:700;">Booked</span>
                                @else
                                    <span style="background:rgba(215,170,70,0.9); color:#081025; padding:3px 12px; border-radius:20px; font-size:0.75rem; font-weight:700;">Available</span>
                                @endif
                            </div>
                        </div>
                        <div style="padding:22px;">
                            <div style="color:rgba(255,255,255,0.45); font-size:0.78rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;">{{ $room->type }}</div>
                            <h3 style="color:white; font-weight:700; font-size:1.1rem; margin-bottom:16px;">Room #{{ $room->number }}</h3>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                                <span style="color:rgba(255,255,255,0.5); font-size:0.82rem;">👥 {{ $room->capacity }} guests</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <span style="color:rgba(255,255,255,0.4); font-size:0.75rem;">From</span>
                                    <span style="color:#d7aa46; font-size:1.3rem; font-weight:800; margin-left:4px;">${{ number_format($room->price,2) }}</span>
                                    <span style="color:rgba(255,255,255,0.4); font-size:0.75rem;">/night</span>
                                </div>
                                @if(!$isBooked)
                                    <a href="{{ route('customer.rooms.show', $room->id) }}"
                                       style="background:linear-gradient(135deg,#e2b24e,#c59629); color:#081025; padding:8px 16px; border-radius:4px; font-weight:700; font-size:0.82rem; text-decoration:none;">
                                        View
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align:center; margin-top:50px;">
            <a href="{{ route('customer.rooms.index') }}"
               style="border:1px solid rgba(215,170,70,0.5); color:#d7aa46; padding:14px 40px; border-radius:4px; font-weight:700; text-decoration:none; letter-spacing:1px; text-transform:uppercase; font-size:0.88rem; transition:all 0.3s;">
                View All Rooms
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
    CTA BANNER
══════════════════════════════════════════ --}}
<section style="position:relative; padding:100px 0; overflow:hidden;">
    <div style="position:absolute; inset:0; background-image:url('{{ asset('image/hero2.png') }}'); background-size:cover; background-position:center; background-attachment:fixed;"></div>
    <div style="position:absolute; inset:0; background:rgba(2,8,28,0.78);"></div>
    <div class="container" style="position:relative; text-align:center;">
        <h2 style="font-family:'Times New Roman',serif; font-size:clamp(2rem,5vw,3.5rem); color:white; margin-bottom:16px;">
            Your Perfect Escape Awaits
        </h2>
        <div style="width:60px; height:2px; background:#d7aa46; margin:0 auto 24px;"></div>
        <p style="color:rgba(255,255,255,0.75); font-size:1.1rem; max-width:500px; margin:0 auto 40px;">
            Discover a world of luxury and tranquility at Sunset Heaven Resort.
        </p>
        <a href="{{ route('customer.rooms.index') }}"
           style="background:linear-gradient(135deg,#e2b24e,#c59629); color:#081025; padding:16px 44px; border-radius:4px; font-weight:700; font-size:1rem; letter-spacing:1.5px; text-transform:uppercase; text-decoration:none;">
            Explore Rooms
        </a>
    </div>
</section>

<style>
.room-featured-card:hover {
    border-color: rgba(215,170,70,0.4) !important;
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
}
.room-featured-card:hover img { transform: scale(1.06); }
@keyframes bounce { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(-8px)} }
@keyframes scroll { 0%{opacity:1;transform:translateY(0)} 100%{opacity:0;transform:translateY(12px)} }
</style>

@endsection
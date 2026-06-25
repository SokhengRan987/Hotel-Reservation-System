<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sunset Heaven Resort')</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            
            --brand-gold: #d7aa46;
            --brand-light: #f8f3e8;
            --brand-soft: rgba(215, 170, 70, 0.15);
            --brand-border: rgba(215, 170, 70, 0.24);
        }

        body {
            background: var(--brand-dark);
            color: var(--brand-light);
            font-family: 'Inter', sans-serif;
        }

        .custom-navbar {
            background:
            padding: 18px 0;
            border-bottom: 1px solid rgba(215, 170, 70, 0.18);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
        }

        .custom-navbar .nav-logo {
            height: 70px;
            filter: brightness(1.1);
        }

        .custom-navbar .brand-name {
            font-family: 'Times New Roman', Times, serif;
            color: var(--brand-gold);
            font-weight: 700;
            font-size: 1.3rem;
            margin-left: 14px;
            letter-spacing: 1px;
        }

        .nav-link {
            color: var(--brand-light) !important;
            font-weight: 600;
            margin-right: 26px;
            position: relative;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--brand-gold);
            transition: width 0.25s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffffff !important;
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #e2b24e 0%, #c59629 100%) !important;
            border: none !important;
            color: #081025 !important;
            font-weight: 700;
            padding: 12px 28px;
            box-shadow: 0 12px 30px rgba(214, 171, 68, 0.24);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 35px rgba(214, 171, 68, 0.35);
        }

        .btn-outline-warning {
            border-color: rgba(215, 170, 70, 0.7) !important;
            color: var(--brand-light) !important;
            background: transparent !important;
        }

        .btn-outline-warning:hover {
            background: rgba(215, 170, 70, 0.14) !important;
            color: var(--brand-light) !important;
        }

        .footer {
            background:#071437; (4, 12, 29, 0.96);
            padding: 60px 0 20px;
            color: rgba(255, 255, 255, 0.85);
            border-top: 1px solid rgba(215, 170, 70, 0.16);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 36px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 18px;
            color: var(--brand-gold);
        }

        .footer-section p,
        .footer-links a {
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.82);
        }

        .footer-links a {
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.25s ease;
        }

        .footer-links a:hover {
            color: var(--brand-gold);
        }

        .social-icons {
            display: flex;
            gap: 14px;
            margin-top: 18px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-light);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background: var(--brand-gold);
            color: #081025;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 28px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .nav-link {
                margin-right: 16px;
                font-size: 0.88rem;
            }

            .custom-navbar {
                padding: 14px 0;
            }
        }
    </style>
    @yield('styles')
    @yield('head')
</head>
<body>
    <!-- NAVBAR -->
    <nav class="custom-navbar sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('image/logo.png') }}" alt="Sunset Heaven Logo" class="nav-logo">
                <span class="brand-name">Sunset Heaven</span>
            </div>
            <div class="d-none d-md-flex">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('customer.rooms.index') }}" class="nav-link">Our Rooms</a>
                <a href="{{ route('customer.bookings.index') }}" class="nav-link">Booking Tracker</a>
            </div>
            <div>
                  @auth
                    @php $role = Auth::user()->fresh()->role ?? 'customer'; @endphp

                    {{-- Hidden Dashboard button per request: show Profile and Logout only --}}
                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary me-2">Profile</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-danger">Logout</button>
                    </form>
                        @else
                            <!-- Guest -->
                            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-warning">Register</a>
                        @endauth



            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- About -->
                <div class="footer-section">
                    <h3>About Sunset Heaven</h3>
                    <p>Experience luxury and tranquility at our stunning beachfront resort. Your perfect getaway awaits.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section footer-links">
                    <h3>Quick Links</h3>
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    <a href="{{ route('customer.rooms.index') }}">Rooms</a>
                    <a href="{{ route('customer.bookings.index') }}">Booking Tracker</a>
                    <a href="#">Contact Us</a>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>📞 Phone: <strong>0965109851</strong></p>
                    <p>✉ Email: <strong>Sunsethaven1011@gmail.com</strong></p>
                    <p>📍 Location:
                        <a href="https://maps.app.goo.gl/zUewaG6kdAbTySY29?g_st=it"
                         target="_blank"
                        style="color:#3780d4; text-decoration:none;">
                        heaven,resort,Koh Kong Krav.map</a> </p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Sunset Heaven Resort. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

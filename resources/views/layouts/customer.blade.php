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
        /* ===== NAVBAR ===== */
        .custom-navbar {
            background:skyblue;
            padding: 15px 0;
            border-bottom: 3px solid #ff9800;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .custom-navbar .nav-logo {
            height: 85px;
            filter: brightness(1.1);
        }
        
        .custom-navbar .brand-name {
            font-family: 'Times New Roman', Times, serif;
            color:black;
            font-weight: 500;
            font-size: 1.2rem;
            margin-left: 12px;
            letter-spacing: 1px;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 600;
            margin-right: 30px;
            position: relative;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #ff9800;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%) !important;
            border: none !important;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.4);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: skyblue;
            padding: 50px 0 20px;
            color: white;
            border-top: 3px solid #ff9800;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-section h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ff9800;
        }
        
        .footer-section p {
            line-height: 1.8;
            opacity: 0.9;
        }
        
        .footer-links a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            opacity: 0.85;
            transition: all 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #ff9800;
            margin-left: 5px;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-icon:hover {
            background: #ff9800;
            transform: translateY(-5px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 152, 0, 0.3);
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .nav-link {
                margin-right: 15px;
                font-size: 0.85rem;
            }
        }
    </style>
    @yield('styles')
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
               <a href="{{ route('customer.rooms.index') }}" class="nav-link">Home</a>
                <a href="{{ route('customer.rooms.index') }}" class="nav-link">Our Rooms</a>
                <a href="#features" class="nav-link">Booking Tracker</a>
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
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('customer.rooms.index') }}">Rooms</a>
                    <a href="#">Amenities</a>
                    <a href="#">Contact Us</a>
                </div>

                <!-- Contact Info -->
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>📞 Phone: <strong>0965109851</strong></p>
                    <p>✉ Email: <strong>Sunsethaven1011@gmail.com</strong></p>
                    <p>📍 Location: Beach, Kompot Sunset ,koh kongkrav</p>
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

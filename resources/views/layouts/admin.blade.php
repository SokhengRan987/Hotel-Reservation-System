<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Admin - @yield('title', 'Dashboard')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-purple: #7c3aed;
            --purple-dark: #6d28d9;
            --white: #ffffff;
            --gray-light: #f3f4f6;
            --gray-medium: #e5e7eb;
            --gray-dark: #374151;
            --text-primary: #111827;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--gray-light);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--primary-purple);
            color: var(--white);
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 15px;
        }

        .sidebar-menu a {
            color: var(--white);
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--purple-dark);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: var(--white);
            padding: 20px 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            color: var(--primary-purple);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-purple);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        /* Footer */
        .footer {
            background: var(--white);
            padding: 20px 30px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            border-top: 1px solid var(--gray-medium);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding: 15px;
            }

            .main-content {
                margin-left: 0;
            }

            body {
                flex-direction: column;
            }

            .header {
                padding: 15px;
                flex-direction: column;
                gap: 15px;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.navigation')
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Hotel Admin</h2>
        <ul class="sidebar-menu">
            <li><a href="/admin/dashboard" class="active">📊 Dashboard</a></li>
            <li><a href="/admin/bookings">📅 Bookings</a></li>
            <li><a href="/admin/rooms">🏨 Rooms</a></li>
            <li><a href="/admin/guests">👥 Guests</a></li>
            <li><a href="/admin/payments">💳 Payments</a></li>
            <li><a href="/admin/reports">📈 Reports</a></li>
            <li><a href="/admin/settings">⚙️ Settings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="header-right">
                <div class="user-profile">
                    <div class="avatar">A</div>
                    <span>Admin User</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Hotel Booking System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
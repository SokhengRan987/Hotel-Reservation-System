@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Bookings Card -->
        <div class="stat-card">
            <div class="stat-label">Total Bookings</div>
            <div class="stat-value">{{ $totalBookings ?? 342 }}</div>
            <div class="stat-change positive">↑ 12% from last month</div>
        </div>

        <!-- Available Rooms Card -->
        <div class="stat-card stat-card-success">
            <div class="stat-label">Available Rooms</div>
            <div class="stat-value">{{ $availableRooms ?? 28 }}</div>
            <div class="stat-change positive">↑ 5% occupied</div>
        </div>

        <!-- Revenue Card -->
        <div class="stat-card stat-card-warning">
            <div class="stat-label">Revenue</div>
            <div class="stat-value">${{ $revenue ?? '45.2' }}K</div>
            <div class="stat-change positive">↑ 8% growth</div>
        </div>

        <!-- Pending Payments Card -->
        <div class="stat-card stat-card-danger">
            <div class="stat-label">Pending Payments</div>
            <div class="stat-value">${{ $pendingPayments ?? '8.5' }}K</div>
            <div class="stat-change negative">↑ 3% overdue</div>
        </div>
    </div>

    <!-- Recent Bookings Section -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Recent Bookings</h2>
            <a href="/admin/bookings" class="btn btn-primary">View All</a>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Smith</td>
                    <td>Room 301</td>
                    <td>Dec 5, 2024</td>
                    <td><span class="badge badge-success">Confirmed</span></td>
                    <td>
                        <a href="#" class="btn btn-secondary">Edit</a>
                        <a href="#" class="btn btn-secondary" style="color: #ef4444;">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>Sarah Johnson</td>
                    <td>Room 215</td>
                    <td>Dec 6, 2024</td>
                    <td><span class="badge badge-success">Confirmed</span></td>
                    <td>
                        <a href="#" class="btn btn-secondary">Edit</a>
                        <a href="#" class="btn btn-secondary" style="color: #ef4444;">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>Michael Brown</td>
                    <td>Room 410</td>
                    <td>Dec 7, 2024</td>
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td>
                        <a href="#" class="btn btn-secondary">Edit</a>
                        <a href="#" class="btn btn-secondary" style="color: #ef4444;">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td>Emma Davis</td>
                    <td>Room 105</td>
                    <td>Dec 8, 2024</td>
                    <td><span class="badge badge-success">Confirmed</span></td>
                    <td>
                        <a href="#" class="btn btn-secondary">Edit</a>
                        <a href="#" class="btn btn-secondary" style="color: #ef4444;">Delete</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Room Status Section -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Room Status</h2>
            <a href="/admin/rooms" class="btn btn-primary">Manage Rooms</a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div style="padding: 16px; background: #f0fdf4; border-radius: 8px; border-left: 4px solid #10b981;">
                <div style="font-size: 12px; color: #065f46; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Active</div>
                <div style="font-size: 28px; font-weight: 700; color: #10b981;">45</div>
                <div style="font-size: 12px; color: #059669; margin-top: 4px;">Rooms occupied</div>
            </div>

            <div style="padding: 16px; background: #fef3c7; border-radius: 8px; border-left: 4px solid #f59e0b;">
                <div style="font-size: 12px; color: #92400e; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Maintenance</div>
                <div style="font-size: 28px; font-weight: 700; color: #f59e0b;">3</div>
                <div style="font-size: 12px; color: #b45309; margin-top: 4px;">Under repair</div>
            </div>

            <div style="padding: 16px; background: #dbeafe; border-radius: 8px; border-left: 4px solid #2563eb;">
                <div style="font-size: 12px; color: #1e40af; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">Available</div>
                <div style="font-size: 28px; font-weight: 700; color: #2563eb;">28</div>
                <div style="font-size: 12px; color: #1d4ed8; margin-top: 4px;">Ready for booking</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Quick Actions</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
            <a href="/admin/bookings/create" class="btn btn-primary" style="justify-content: center; padding: 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                New Booking
            </a>
            <a href="/admin/guests" class="btn btn-primary" style="justify-content: center; padding: 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                View Guests
            </a>
            <a href="/admin/payments" class="btn btn-primary" style="justify-content: center; padding: 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                    <line x1="1" y1="10" x2="23" y2="10"></line>
                </svg>
                Manage Payments
            </a>
            <a href="/admin/reports" class="btn btn-primary" style="justify-content: center; padding: 16px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width: 18px; height: 18px;">
                    <line x1="12" y1="2" x2="12" y2="22"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
                Reports
            </a>
        </div>
    </div>
@endsection

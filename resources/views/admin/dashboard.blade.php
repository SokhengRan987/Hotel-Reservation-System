
@extends('layouts.admin')

@section('content')
    <h1>Admin Dashboard</h1>

@section('page-title', 'Dashboard')

@section('content')

<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--white);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid var(--primary-purple);
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card.rooms {
        border-left-color: #10b981;
    }

    .stat-card.revenue {
        border-left-color: #f59e0b;
    }

    .stat-card.payments {
        border-left-color: #ef4444;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-change {
        font-size: 12px;
        color: #10b981;
    }

    .stat-change.negative {
        color: #ef4444;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Card */
    .card {
        background: var(--white);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--gray-medium);
        padding-bottom: 15px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
    }

    .btn-small {
        background: var(--primary-purple);
        color: var(--white);
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        transition: background 0.3s;
    }

    .btn-small:hover {
        background: var(--purple-dark);
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        background: var(--gray-light);
        padding: 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid var(--gray-medium);
    }

    td {
        padding: 12px;
        border-bottom: 1px solid var(--gray-medium);
    }

    tr:hover {
        background: var(--gray-light);
    }

    /* Badge */
    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge.confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge.cancelled {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .badge.active {
        background: #dbeafe;
        color: #0c2d6b;
    }

    /* Action Buttons */
    .action-btn {
        background: none;
        border: none;
        color: var(--primary-purple);
        cursor: pointer;
        margin-right: 8px;
        font-size: 14px;
        padding: 4px 8px;
        transition: color 0.3s;
    }

    .action-btn:hover {
        color: var(--purple-dark);
    }

    .action-btn.delete {
        color: #ef4444;
    }

    .action-btn.delete:hover {
        color: #c4161c;
    }

    /* Activity */
    .activity-item {
        padding: 15px 0;
        border-bottom: 1px solid var(--gray-medium);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-time {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 5px;
    }

    .activity-text {
        font-size: 14px;
    }

    .activity-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary-purple);
        margin-right: 8px;
    }
</style>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Bookings</div>
        <div class="stat-value">342</div>
        <div class="stat-change">↑ 12% from last month</div>
    </div>
    <div class="stat-card rooms">
        <div class="stat-label">Available Rooms</div>
        <div class="stat-value">28</div>
        <div class="stat-change">↓ 5% occupied</div>
    </div>
    <div class="stat-card revenue">
        <div class="stat-label">Revenue</div>
        <div class="stat-value">$45.2K</div>
        <div class="stat-change">↑ 8% growth</div>
    </div>
    <div class="stat-card payments">
        <div class="stat-label">Pending Payments</div>
        <div class="stat-value">$8.5K</div>
        <div class="stat-change negative">↑ 3% overdue</div>
    </div>
</div>

<!-- Main Content -->
<div class="content-grid">
    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Bookings</h2>
            <button class="btn-small">View All</button>
        </div>
        <table>
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
                    <td><span class="badge confirmed">Confirmed</span></td>
                    <td>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Sarah Johnson</td>
                    <td>Room 215</td>
                    <td>Dec 6, 2024</td>
                    <td><span class="badge pending">Pending</span></td>
                    <td>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn delete">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Michael Brown</td>
                    <td>Room 405</td>
                    <td>Dec 4, 2024</td>
                    <td><span class="badge confirmed">Confirmed</span></td>
                    <td>
                        <button class="action-btn">Edit</button>
                        <button class="action-btn delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Room Status -->
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h2 class="card-title">Room Status</h2>
            </div>
            <table style="font-size: 13px;">
                <tbody>
                    <tr>
                        <td><span class="badge active">Active</span></td>
                        <td style="text-align: right; font-weight: 600;">45</td>
                    </tr>
                    <tr>
                        <td><span class="badge pending">Maintenance</span></td>
                        <td style="text-align: right; font-weight: 600;">3</td>
                    </tr>
                    <tr>
                        <td><span class="badge confirmed">Available</span></td>
                        <td style="text-align: right; font-weight: 600;">28</td>
                    </tr>
                    <tr>
                        <td><span class="badge cancelled">Occupied</span></td>
                        <td style="text-align: right; font-weight: 600;">24</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Activity</h2>
            </div>
            <div class="activity-item">
                <div class="activity-time">2 hours ago</div>
                <div class="activity-text"><span class="activity-dot"></span>New booking from John Smith</div>
            </div>
            <div class="activity-item">
                <div class="activity-time">4 hours ago</div>
                <div class="activity-text"><span class="activity-dot"></span>Payment received: $1,200</div>
            </div>
            <div class="activity-item">
                <div class="activity-time">6 hours ago</div>
                <div class="activity-text"><span class="activity-dot"></span>Room 215 maintenance completed</div>
            </div>
        </div>
    </div>
</div>

@endsection
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ✅ Real stats from DB
        $totalBookings = Booking::count();

        $availableRooms = Room::whereDoesntHave('bookings', function($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'checked_in'])
              ->where('start_date', '<', now()->addDays(1))
              ->where('end_date', '>', now());
        })->count();

        $bookedRooms = Room::whereHas('bookings', function($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'checked_in'])
              ->where('start_date', '<', now()->addDays(1))
              ->where('end_date', '>', now());
        })->count();

        $totalRooms = Room::count();

        $revenue = Payment::where('status', 'paid')->sum('amount');

        $pendingPayments = Payment::where('status', 'pending')->sum('amount');

        // ✅ Real recent bookings
        $recentBookings = Booking::with(['user', 'room'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'availableRooms',
            'bookedRooms',
            'totalRooms',
            'revenue',
            'pendingPayments',
            'recentBookings'
        ));
    }
}
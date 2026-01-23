<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(12);
        return view('customer.rooms.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        return view('customer.rooms.show', compact('room'));
    }

    /**
     * Get disabled dates for a room (booked dates)
     */
    public function getDisabledDates(Room $room)
    {
        $bookings = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
            ->select('start_date', 'end_date')
            ->get();

        $disabledDates = [];
        foreach ($bookings as $booking) {
            $start = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);

            // Add all dates between start and end (excluding end date as it's checkout day)
            for ($date = $start; $date < $end; $date->addDay()) {
                $disabledDates[] = $date->format('Y-m-d');
            }
        }

        return response()->json([
            'disabled_dates' => array_unique($disabledDates)
        ]);
    }
}

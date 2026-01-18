<?php
namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

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
}

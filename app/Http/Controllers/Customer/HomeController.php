<?php

namespace App\Http\Controllers\Customer;
use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function index()
    {
        $featuredRooms = Room::with(['bookings' => function($q) {
            $q->whereIn('status', ['pending', 'confirmed', 'checked_in'])
              ->where('start_date', '<', now()->addDays(1))
              ->where('end_date', '>', now());
        }])->take(4)->get();
 
       return view('welcome', compact('featuredRooms'));
    }

}

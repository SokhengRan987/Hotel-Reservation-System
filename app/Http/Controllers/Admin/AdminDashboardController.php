<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    // ✅ Add this method
    public function index()
    {
        return view('admin.dashboard'); // make sure this Blade exists
    }
}

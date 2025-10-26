<?php
// File: app/Http/Controllers/Business/DashboardController.php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // Check if user is business
        if (!Auth::user()->isBusiness()) {
            return redirect()->route('home')->with('error', 'Access denied! Business account required.');
        }

        // Fetch all hotels owned by this business user with their rooms & reservations
        $hotels = Auth::user()->hotels()->with(['rooms', 'reservations'])->get();

        // Calculate totals
        $totalHotels = $hotels->count();
        $totalRooms = Room::whereIn('hotel_id', $hotels->pluck('id'))->count();
        $totalBookings = $hotels->sum(function ($hotel) {
            return $hotel->reservations->count();
        });

        // Pass data to the view
        return view('business.dashboard', compact('hotels', 'totalHotels', 'totalRooms', 'totalBookings'));
    }
}

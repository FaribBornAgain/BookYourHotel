<?php
// File: app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Destination;
use App\Models\PropertyType;

class HomeController extends Controller
{
    public function index()
    {
        // Get all active hotels with their rooms
        $hotels = Hotel::where('status', 'active')
                      ->with('rooms')
                      ->latest()
                      ->get();
        
        // Get all rooms (for backward compatibility)
        $rooms = Room::whereHas('hotel', function($query) {
            $query->where('status', 'active');
        })->orWhereNull('hotel_id')->get();
        
        // Get featured destinations
        $destinations = Destination::where('is_featured', true)
                                   ->orderBy('hotels_count', 'desc')
                                   ->get();
        
        // Get property types
        $propertyTypes = PropertyType::withCount('hotels')->get();
        
        // Stats
        $totalHotels = Hotel::where('status', 'active')->count();
        
        return view('home', compact('rooms', 'hotels', 'destinations', 'propertyTypes', 'totalHotels'));
    }

    public function facilities()
    {
        return view('facilities');
    }

    public function about()
    {
        return view('about');
    }
}
<?php
// File: app/Http/Controllers/HotelPublicController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;

class HotelPublicController extends Controller
{
    public function show($id)
    {
        $hotel = Hotel::where('status', 'active')
                     ->with(['rooms', 'destination', 'propertyType'])
                     ->findOrFail($id);
        
        return view('hotels.show', compact('hotel'));
    }
}
<?php
// File: app/Http/Controllers/DestinationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Hotel;

class DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        $hotels = Hotel::where('destination_id', $id)
                      ->where('status', 'active')
                      ->with('rooms')
                      ->paginate(12);
        
        return view('destinations.show', compact('destination', 'hotels'));
    }
}
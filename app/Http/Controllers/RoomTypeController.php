<?php
// File: app/Http/Controllers/RoomTypeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = Room::select('type')->distinct()->get();
        $rooms = Room::all();
        return view('room-types.index', compact('rooms', 'roomTypes'));
    }

    public function show($type)
    {
        $rooms = Room::where('type', $type)->get();
        return view('room-types.show', compact('rooms', 'type'));
    }

    public function standard()
    {
        $rooms = Room::where('type', 'standard')->get();
        return view('room-types.standard', compact('rooms'));
    }

    public function superior()
    {
        $rooms = Room::where('type', 'superior')->get();
        return view('room-types.superior', compact('rooms'));
    }

    public function deluxe()
    {
        $rooms = Room::where('type', 'deluxe')->get();
        return view('room-types.deluxe', compact('rooms'));
    }

    public function filterByType(Request $request)
    {
        $request->validate([
            'type' => 'required|string'
        ]);

        $rooms = Room::where('type', $request->type)->get();
        return view('rooms.index', compact('rooms'));
    }

    public function compareTypes()
    {
        $standardRooms = Room::where('type', 'standard')->get();
        $superiorRooms = Room::where('type', 'superior')->get();
        $deluxeRooms = Room::where('type', 'deluxe')->get();

        return view('room-types.compare', compact('standardRooms', 'superiorRooms', 'deluxeRooms'));
    }
}
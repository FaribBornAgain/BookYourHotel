<?php
// File: app/Http/Controllers/RoomFacilityController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomFacility;
use App\Models\Room;

class RoomFacilityController extends Controller
{
    public function index()
    {
        $roomFacilities = RoomFacility::all();
        return view('room-facilities.index', compact('roomFacilities'));
    }

    public function create()
    {
        return view('room-facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        RoomFacility::create($request->all());

        return redirect()->route('room-facilities.index')
                        ->with('success', 'Room facility added successfully!');
    }

    public function show($id)
    {
        $roomFacility = RoomFacility::findOrFail($id);
        return view('room-facilities.show', compact('roomFacility'));
    }

    public function edit($id)
    {
        $roomFacility = RoomFacility::findOrFail($id);
        return view('room-facilities.edit', compact('roomFacility'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $roomFacility = RoomFacility::findOrFail($id);
        $roomFacility->update($request->all());

        return redirect()->route('room-facilities.index')
                        ->with('success', 'Room facility updated successfully!');
    }

    public function destroy($id)
    {
        $roomFacility = RoomFacility::findOrFail($id);
        $roomFacility->delete();

        return redirect()->route('room-facilities.index')
                        ->with('success', 'Room facility deleted successfully!');
    }

    public function attachToRoom(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $room->facilities()->attach($request->facility_id);

        return redirect()->back()
                        ->with('success', 'Facility added to room successfully!');
    }

    public function detachFromRoom($roomId, $facilityId)
    {
        $room = Room::findOrFail($roomId);
        $room->facilities()->detach($facilityId);

        return redirect()->back()
                        ->with('success', 'Facility removed from room successfully!');
    }
}
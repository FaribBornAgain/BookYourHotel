<?php
// File: app/Http/Controllers/HotelFacilityController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelFacility;

class HotelFacilityController extends Controller
{
    public function index()
    {
        $facilities = HotelFacility::all();
        return view('facilities', compact('facilities'));
    }

    public function create()
    {
        return view('hotel-facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string'
        ]);

        HotelFacility::create($request->all());

        return redirect()->route('facilities')
                        ->with('success', 'Facility added successfully!');
    }

    public function show($id)
    {
        $facility = HotelFacility::findOrFail($id);
        return view('hotel-facilities.show', compact('facility'));
    }

    public function edit($id)
    {
        $facility = HotelFacility::findOrFail($id);
        return view('hotel-facilities.edit', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string'
        ]);

        $facility = HotelFacility::findOrFail($id);
        $facility->update($request->all());

        return redirect()->route('facilities')
                        ->with('success', 'Facility updated successfully!');
    }

    public function destroy($id)
    {
        $facility = HotelFacility::findOrFail($id);
        $facility->delete();

        return redirect()->route('facilities')
                        ->with('success', 'Facility deleted successfully!');
    }
}
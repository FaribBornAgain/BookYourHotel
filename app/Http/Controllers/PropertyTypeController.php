<?php
// File: app/Http/Controllers/PropertyTypeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\Hotel;

class PropertyTypeController extends Controller
{
    public function show($id)
    {
        $propertyType = PropertyType::findOrFail($id);
        $hotels = Hotel::where('property_type_id', $id)
                      ->where('status', 'active')
                      ->with('rooms')
                      ->paginate(12);
        
        return view('property-types.show', compact('propertyType', 'hotels'));
    }
}
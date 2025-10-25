<?php
// File: app/Http/Controllers/Business/BusinessRoomController.php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($hotelId)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($hotelId);
        return view('business.rooms.create', compact('hotel'));
    }

    public function store(Request $request, $hotelId)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($hotelId);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,superior,deluxe',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['hotel_id'] = $hotel->id;

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('rooms/featured', 'public');
            $data['featured_image'] = $featuredImagePath;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('rooms/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $data['gallery_images'] = json_encode($galleryPaths);
        }

        Room::create($data);

        return redirect()->route('business.hotels.show', $hotel->id)
                        ->with('success', 'Room added successfully!');
    }

    public function edit($hotelId, $roomId)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($hotelId);
        $room = Room::where('hotel_id', $hotel->id)->findOrFail($roomId);
        return view('business.rooms.edit', compact('hotel', 'room'));
    }

    public function update(Request $request, $hotelId, $roomId)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($hotelId);
        $room = Room::where('hotel_id', $hotel->id)->findOrFail($roomId);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:standard,superior,deluxe',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:1',
            'amenities' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($room->featured_image) {
                Storage::disk('public')->delete($room->featured_image);
            }
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('rooms/featured', 'public');
            $data['featured_image'] = $featuredImagePath;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($room->gallery_images) {
                $oldImages = json_decode($room->gallery_images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('rooms/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $data['gallery_images'] = json_encode($galleryPaths);
        }

        $room->update($data);

        return redirect()->route('business.hotels.show', $hotel->id)
                        ->with('success', 'Room updated successfully!');
    }

    public function destroy($hotelId, $roomId)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($hotelId);
        $room = Room::where('hotel_id', $hotel->id)->findOrFail($roomId);
        
        // Delete images
        if ($room->featured_image) {
            Storage::disk('public')->delete($room->featured_image);
        }
        if ($room->gallery_images) {
            $galleryImages = json_decode($room->gallery_images, true);
            foreach ($galleryImages as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $room->delete();

        return redirect()->route('business.hotels.show', $hotel->id)
                        ->with('success', 'Room deleted successfully!');
    }
}
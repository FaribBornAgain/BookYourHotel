<?php
// File: app/Http/Controllers/Business/HotelController.php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Destination;
use App\Models\PropertyType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hotels = Auth::user()->hotels;
        return view('business.hotels.index', compact('hotels'));
    }

    public function create()
    {
        $destinations = Destination::all();
        $propertyTypes = PropertyType::all();
        return view('business.hotels.create', compact('destinations', 'propertyTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('hotels/featured', 'public');
            $data['featured_image'] = $featuredImagePath;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('hotels/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $data['gallery_images'] = json_encode($galleryPaths);
        }

        Hotel::create($data);

        return redirect()->route('business.hotels.index')
                        ->with('success', 'Hotel created successfully!');
    }

    public function show($id)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($id);
        $rooms = $hotel->rooms;
        return view('business.hotels.show', compact('hotel', 'rooms'));
    }

    public function edit($id)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($id);
        $destinations = Destination::all();
        $propertyTypes = PropertyType::all();
        return view('business.hotels.edit', compact('hotel', 'destinations', 'propertyTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($id);
        $data = $request->all();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($hotel->featured_image) {
                Storage::disk('public')->delete($hotel->featured_image);
            }
            $featuredImage = $request->file('featured_image');
            $featuredImagePath = $featuredImage->store('hotels/featured', 'public');
            $data['featured_image'] = $featuredImagePath;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($hotel->gallery_images) {
                $oldImages = json_decode($hotel->gallery_images, true);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('hotels/gallery', 'public');
                $galleryPaths[] = $path;
            }
            $data['gallery_images'] = json_encode($galleryPaths);
        }

        $hotel->update($data);

        return redirect()->route('business.hotels.index')
                        ->with('success', 'Hotel updated successfully!');
    }

    public function destroy($id)
    {
        $hotel = Hotel::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete images
        if ($hotel->featured_image) {
            Storage::disk('public')->delete($hotel->featured_image);
        }
        if ($hotel->gallery_images) {
            $galleryImages = json_decode($hotel->gallery_images, true);
            foreach ($galleryImages as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $hotel->delete();

        return redirect()->route('business.hotels.index')
                        ->with('success', 'Hotel deleted successfully!');
    }
}
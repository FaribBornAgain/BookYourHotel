@extends('layouts.master')

@section('title', 'Add New Hotel - Hotel Hebat')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-hotel"></i> Add New Hotel</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('business.hotels.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3">Basic Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hotel Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required placeholder="e.g., Grand Plaza Hotel">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Location *</label>
                                    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                           value="{{ old('location') }}" required placeholder="e.g., Dhaka, Bangladesh">
                                           <div class="mb-3">
    <label class="form-label">Map Location (Optional)</label>
    <div class="row">
        <div class="col-md-6">
            <input type="text" name="latitude" id="latitude" class="form-control" 
                   placeholder="Latitude (e.g., 23.8103)" step="any">
        </div>
        <div class="col-md-6">
            <input type="text" name="longitude" id="longitude" class="form-control" 
                   placeholder="Longitude (e.g., 90.4125)" step="any">
        </div>
    </div>
    <small class="text-muted">
        <i class="fas fa-info-circle"></i> Enter coordinates or search below
    </small>
</div>

<div class="mb-3">
    <label class="form-label">Search Location on Map</label>
    <input type="text" id="map-search" class="form-control" placeholder="Search for a place...">
    <div id="map" style="width: 100%; height: 400px; margin-top: 10px; border-radius: 8px;"></div>
    <small class="text-muted">
        Click on the map to set hotel location
    </small>
</div>

<div class="mb-3">
    <label class="form-label">Map Address</label>
    <input type="text" name="map_address" id="map_address" class="form-control" 
           placeholder="Full address from map">
</div>
                                    @error('location')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="4" required placeholder="Describe your hotel...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+880 1234-567890">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="hotel@example.com">
                                </div>
                            </div>

                            @if(isset($destinations) && $destinations->count() > 0)
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Destination</label>
                                    <select name="destination_id" class="form-control">
                                        <option value="">Select Destination</option>
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Property Type</label>
                                    <select name="property_type_id" class="form-control">
                                        <option value="">Select Type</option>
                                        @foreach($propertyTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="fas fa-images"></i> Hotel Images</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Featured Image *</label>
                                <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'featured-preview')">
                                <small class="text-muted">This will be the main image shown on listings (Max: 2MB)</small>
                                @error('featured_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <div id="featured-preview" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery Images (Optional)</label>
                                <input type="file" name="gallery_images[]" class="form-control" 
                                       accept="image/*" multiple onchange="previewMultipleImages(this, 'gallery-preview')">
                                <small class="text-muted">Upload multiple images (Max: 2MB each, up to 10 images)</small>
                                <div id="gallery-preview" class="row mt-2"></div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('business.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Create Hotel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUSPf9_SIbhHwkylQM0hyKVLadO6TClU&libraries=places"></script>
<script>
let map;
let marker;
let geocoder;

function initMap() {
    // Default location (Dhaka, Bangladesh)
    const defaultLocation = { lat: 23.8103, lng: 90.4125 };
    
    // Initialize map
    map = new google.maps.Map(document.getElementById('map'), {
        center: defaultLocation,
        zoom: 13
    });
    
    // Initialize geocoder
    geocoder = new google.maps.Geocoder();
    
    // Add marker
    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: true
    });
    
    // Click event on map
    map.addListener('click', function(event) {
        placeMarker(event.latLng);
    });
    
    // Drag event on marker
    marker.addListener('dragend', function(event) {
        updateCoordinates(event.latLng);
        reverseGeocode(event.latLng);
    });
    
    // Search box
    const searchBox = new google.maps.places.SearchBox(document.getElementById('map-search'));
    
    searchBox.addListener('places_changed', function() {
        const places = searchBox.getPlaces();
        
        if (places.length == 0) {
            return;
        }
        
        const place = places[0];
        
        if (!place.geometry || !place.geometry.location) {
            return;
        }
        
        map.setCenter(place.geometry.location);
        placeMarker(place.geometry.location);
        
        // Set address
        document.getElementById('map_address').value = place.formatted_address;
    });
}

function placeMarker(location) {
    marker.setPosition(location);
    map.panTo(location);
    updateCoordinates(location);
    reverseGeocode(location);
}

function updateCoordinates(location) {
    document.getElementById('latitude').value = location.lat().toFixed(8);
    document.getElementById('longitude').value = location.lng().toFixed(8);
}

function reverseGeocode(location) {
    geocoder.geocode({ location: location }, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                document.getElementById('map_address').value = results[0].formatted_address;
            }
        }
    });
}

// Initialize map when page loads
window.onload = initMap;
</script>
</section>

<script>
// Preview single image
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview multiple images
function previewMultipleImages(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-2';
                col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">`;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
@extends('layouts.master')

@section('title', $hotel->name . ' - BookYourHotel')

@push('styles')
<style>
    .hotel-header {
        background: #f8f9fa;
        padding: 30px 0;
    }
    .hotel-gallery {
        margin: 30px 0;
    }
    .hotel-gallery .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }
    .hotel-gallery .thumb-image {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .hotel-gallery .thumb-image:hover {
        opacity: 0.7;
        transform: scale(1.05);
    }
    .room-card-horizontal {
        display: flex;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    .room-card-horizontal:hover {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .room-card-horizontal img {
        width: 300px;
        height: 200px;
        object-fit: cover;
    }
    .room-card-horizontal .room-details {
        flex: 1;
        padding: 20px;
    }
</style>
@endpush

@section('content')
<!-- Hotel Header -->
<section class="hotel-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>{{ $hotel->name }}</h1>
                <p class="text-muted mb-2">
                    <i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}
                </p>
                @if($hotel->destination)
                    <span class="badge bg-info">{{ $hotel->destination->name }}</span>
                @endif
                @if($hotel->propertyType)
                    <span class="badge bg-secondary">{{ $hotel->propertyType->name }}</span>
                @endif
            </div>
            <div class="col-md-4 text-end">
                <div class="badge bg-success" style="font-size: 1.5rem; padding: 10px 20px;">
                    9.2 Wonderful
                </div>
                <p class="text-muted mt-2">{{ $hotel->reservations->count() }} reviews</p>
            </div>
        </div>
    </div>
</section>

<!-- Hotel Gallery -->
<section class="hotel-gallery">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-3">
                @if($hotel->featured_image)
                    <img src="{{ asset('storage/' . $hotel->featured_image) }}" alt="{{ $hotel->name }}" class="main-image" id="mainImage">
                @else
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200" alt="{{ $hotel->name }}" class="main-image" id="mainImage">
                @endif
            </div>
            
            <!-- Gallery Thumbnails -->
            @if($hotel->gallery_images && count(json_decode($hotel->gallery_images)) > 0)
            <div class="col-md-12">
                <div class="row">
                    @foreach(json_decode($hotel->gallery_images) as $image)
                    <div class="col-md-2 mb-2">
                        <img src="{{ asset('storage/' . $image) }}" alt="Gallery" class="thumb-image" 
                             onclick="changeMainImage('{{ asset('storage/' . $image) }}')">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Hotel Description -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3>About this property</h3>
                <p>{{ $hotel->description }}</p>

                <hr class="my-4">

                <h3>Contact Information</h3>
                <ul class="list-unstyled">
                    @if($hotel->phone)
                        <li><i class="fas fa-phone"></i> {{ $hotel->phone }}</li>
                    @endif
                    @if($hotel->email)
                        <li><i class="fas fa-envelope"></i> {{ $hotel->email }}</li>
                    @endif
                    <li><i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}</li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Property Highlights</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> {{ $hotel->rooms->count() }} room types</li>
                            <li><i class="fas fa-check text-success"></i> Starting from Tk {{ number_format($hotel->min_price ?? 0, 0, ',', '.') }}</li>
                            <li><i class="fas fa-check text-success"></i> Free cancellation</li>
                            <li><i class="fas fa-check text-success"></i> No prepayment needed</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hotel Location Map -->
@if($hotel->hasCoordinates())
<section class="py-4" style="background: #f8f9fa;">
    <div class="container">
        <h3 class="mb-4"><i class="fas fa-map-marker-alt"></i> Location</h3>
        
        <div class="row">
            <div class="col-md-8">
                <div id="hotel-map" style="width: 100%; height: 400px; border-radius: 10px;"></div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Address</h5>
                        <p>
                            <i class="fas fa-map-marker-alt text-danger"></i> 
                            {{ $hotel->map_address ?? $hotel->location }}
                        </p>
                        <hr>
                        <h6>Coordinates</h6>
                        <p class="small mb-0">
                            <strong>Lat:</strong> {{ $hotel->latitude }}<br>
                            <strong>Lng:</strong> {{ $hotel->longitude }}
                        </p>
                        <hr>
                        <a href="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}" 
                           target="_blank" class="btn btn-primary w-100">
                            <i class="fas fa-directions"></i> Get Directions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUSPf9_SIbhHwkylQM0hyKVLadO6TClU"></script>
<script>
function initHotelMap() {
    const hotelLocation = {
        lat: {{ $hotel->latitude }},
        lng: {{ $hotel->longitude }}
    };
    
    const map = new google.maps.Map(document.getElementById('hotel-map'), {
        center: hotelLocation,
        zoom: 15
    });
    
    const marker = new google.maps.Marker({
        position: hotelLocation,
        map: map,
        title: '{{ $hotel->name }}',
        icon: {
            url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
        }
    });
    
    const infoWindow = new google.maps.InfoWindow({
        content: '<div style="padding: 10px;"><h6>{{ $hotel->name }}</h6><p>{{ $hotel->location }}</p></div>'
    });
    
    marker.addListener('click', function() {
        infoWindow.open(map, marker);
    });
}

window.onload = initHotelMap;
</script>
@endif

<!-- Available Rooms -->
<section class="py-4" style="background: #f8f9fa;">
    <div class="container">
        <h3 class="mb-4">Available Rooms</h3>
        
        @if($hotel->rooms->count() > 0)
            @foreach($hotel->rooms as $room)
            <div class="room-card-horizontal">
                @if($room->featured_image)
                    <img src="{{ asset('storage/' . $room->featured_image) }}" alt="{{ $room->name }}">
                @else
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400" alt="{{ $room->name }}">
                @endif
                
                <div class="room-details">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4>{{ $room->name }}</h4>
                            <span class="badge bg-info mb-2">{{ ucfirst($room->type) }}</span>
                        </div>
                        <div class="text-end">
                            <h3 class="text-primary mb-0">Tk {{ number_format($room->price, 0, ',', '.') }}</h3>
                            <small class="text-muted">per night</small>
                        </div>
                    </div>
                    
                    <p class="mb-2">{{ Str::limit($room->description, 150) }}</p>
                    
                    <div class="mb-3">
                        <strong>Amenities:</strong> {{ $room->amenities ?? 'N/A' }}
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <small class="text-muted"><i class="fas fa-users"></i> Up to {{ $room->capacity }} guests</small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted"><i class="fas fa-door-open"></i> {{ $room->available_rooms }} rooms available</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-primary">
                                Book Now <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No rooms available at this property yet.
            </div>
        @endif
    </div>
</section>

<script>
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endsection
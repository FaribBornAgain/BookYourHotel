@extends('layouts.master')

@section('title', $propertyType->name . ' - Hotel Hebat')

@section('content')
<!-- Property Type Header -->
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <h1>{{ $propertyType->name }}</h1>
        @if($propertyType->description)
            <p class="lead">{{ $propertyType->description }}</p>
        @endif
        <p class="text-muted">{{ $hotels->total() }} properties found</p>
    </div>
</section>

<!-- Properties List -->
<section class="py-5">
    <div class="container">
        @if($hotels->count() > 0)
            <div class="row">
                @foreach($hotels as $hotel)
                <div class="col-md-4 mb-4">
                    <div class="card hotel-card">
                        @if($hotel->featured_image)
                            <img src="{{ asset('storage/' . $hotel->featured_image) }}" class="card-img-top" alt="{{ $hotel->name }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400" class="card-img-top" alt="{{ $hotel->name }}">
                        @endif
                        
                        <div class="card-body">
                            <h5>{{ $hotel->name }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}
                            </p>
                            <p class="small mb-3">{{ Str::limit($hotel->description, 100) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="text-primary mb-0">Rp {{ number_format($hotel->min_price ?? 0, 0, ',', '.') }}</h5>
                                    <small class="text-muted">per night</small>
                                </div>
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $hotels->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No properties available in this category yet.
            </div>
        @endif
    </div>
</section>
@endsection
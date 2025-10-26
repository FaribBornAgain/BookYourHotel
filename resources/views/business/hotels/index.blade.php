@extends('layouts.master')

@section('title', 'My Hotels - BookYourHotel')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>My Hotels</h2>
            <a href="{{ route('business.hotels.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Hotel
            </a>
        </div>

        @if($hotels->count() > 0)
            <div class="row">
                @foreach($hotels as $hotel)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h4>{{ $hotel->name }}</h4>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}
                                    </p>
                                </div>
                                @if($hotel->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>

                            <p>{{ Str::limit($hotel->description, 150) }}</p>

                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <h5 class="text-primary mb-0">{{ $hotel->rooms->count() }}</h5>
                                    <small class="text-muted">Rooms</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-success mb-0">{{ $hotel->active_rooms_count }}</h5>
                                    <small class="text-muted">Available</small>
                                </div>
                                <div class="col-4">
                                    <h5 class="text-info mb-0">{{ $hotel->reservations->count() }}</h5>
                                    <small class="text-muted">Bookings</small>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('business.hotels.show', $hotel->id) }}" class="btn btn-sm btn-primary flex-fill">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <a href="{{ route('business.hotels.edit', $hotel->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-hotel fa-5x text-muted mb-4"></i>
                    <h4>No Hotels Yet</h4>
                    <p class="text-muted mb-4">Start by adding your first hotel property.</p>
                    <a href="{{ route('business.hotels.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Add Your First Hotel
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
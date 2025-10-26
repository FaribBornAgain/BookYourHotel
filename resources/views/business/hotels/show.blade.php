@extends('layouts.master')

@section('title', $hotel->name . ' - Manage Rooms')

@section('content')
<section class="py-5">
    <div class="container">
        <!-- Hotel Info -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2>{{ $hotel->name }}</h2>
                        <p class="text-muted mb-2"><i class="fas fa-map-marker-alt"></i> {{ $hotel->location }}</p>
                        <p>{{ $hotel->description }}</p>
                        @if($hotel->phone)
                            <p class="mb-1"><strong>Phone:</strong> {{ $hotel->phone }}</p>
                        @endif
                        @if($hotel->email)
                            <p class="mb-0"><strong>Email:</strong> {{ $hotel->email }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('business.hotels.edit', $hotel->id) }}" class="btn btn-warning mb-2">
                            <i class="fas fa-edit"></i> Edit Hotel
                        </a>
                        <form action="{{ route('business.hotels.destroy', $hotel->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2" 
                                    onclick="return confirm('Are you sure? This will delete all rooms too!')">
                                <i class="fas fa-trash"></i> Delete Hotel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rooms Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Rooms ({{ $rooms->count() }})</h5>
                <a href="{{ route('business.rooms.create', $hotel->id) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Add Room
                </a>
            </div>
            <div class="card-body">
                @if($rooms->count() > 0)
                    <div class="row">
                        @foreach($rooms as $room)
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>{{ $room->name }}</h5>
                                    <p class="text-muted mb-2">
                                        <span class="badge bg-info">{{ ucfirst($room->type) }}</span>
                                    </p>
                                    <p class="mb-2">{{ Str::limit($room->description, 100) }}</p>
                                    <p class="mb-2">
                                        <strong>Price:</strong> Tk. {{ number_format($room->price, 0, ',', '.') }}/night
                                    </p>
                                    <p class="mb-2">
                                        <strong>Capacity:</strong> {{ $room->capacity }} guests
                                    </p>
                                    <p class="mb-3">
                                        <strong>Available:</strong> {{ $room->available_rooms }} rooms
                                    </p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('business.rooms.edit', [$hotel->id, $room->id]) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('business.rooms.destroy', [$hotel->id, $room->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this room?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-bed fa-4x text-muted mb-3"></i>
                        <p class="text-muted">No rooms added yet.</p>
                        <a href="{{ route('business.rooms.create', $hotel->id) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Your First Room
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('business.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</section>
@endsection
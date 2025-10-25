@extends('layouts.master')

@section('title', 'Edit Room - ' . $room->name)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Edit Room: {{ $room->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('business.rooms.update', [$hotel->id, $room->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Room Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $room->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Room Type *</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="standard" {{ $room->type == 'standard' ? 'selected' : '' }}>Standard</option>
                                    <option value="superior" {{ $room->type == 'superior' ? 'selected' : '' }}>Superior</option>
                                    <option value="deluxe" {{ $room->type == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="3" required>{{ old('description', $room->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Price per Night (Rp) *</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $room->price) }}" required min="0" step="1000">
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Capacity (Guests) *</label>
                                    <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                                           value="{{ old('capacity', $room->capacity) }}" required min="1">
                                    @error('capacity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Available Rooms *</label>
                                <input type="number" name="available_rooms" class="form-control @error('available_rooms') is-invalid @enderror" 
                                       value="{{ old('available_rooms', $room->available_rooms) }}" required min="1">
                                @error('available_rooms')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Amenities</label>
                                <input type="text" name="amenities" class="form-control" 
                                       value="{{ old('amenities', $room->amenities) }}">
                                <small class="text-muted">Separate with commas</small>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('business.hotels.show', $hotel->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Room
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
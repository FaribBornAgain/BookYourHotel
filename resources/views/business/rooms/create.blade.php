@extends('layouts.master')

@section('title', 'Add Room - ' . $hotel->name)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-bed"></i> Add Room to {{ $hotel->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('business.rooms.store', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-3">Room Details</h5>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Room Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required placeholder="e.g., Deluxe Ocean View Suite">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Room Type *</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                                        <option value="superior" {{ old('type') == 'superior' ? 'selected' : '' }}>Superior</option>
                                        <option value="deluxe" {{ old('type') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="3" required placeholder="Describe the room features...">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Price per Night (TK) *</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" required min="0" step="1000" placeholder="250000">
                                    @error('price')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Capacity (Guests) *</label>
                                    <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                                           value="{{ old('capacity') }}" required min="1" placeholder="2">
                                    @error('capacity')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Available Rooms *</label>
                                    <input type="number" name="available_rooms" class="form-control @error('available_rooms') is-invalid @enderror" 
                                           value="{{ old('available_rooms') }}" required min="1" placeholder="5">
                                    @error('available_rooms')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Amenities</label>
                                <input type="text" name="amenities" class="form-control" 
                                       value="{{ old('amenities') }}" placeholder="AC, TV, WiFi, Mini Bar, Bathtub">
                                <small class="text-muted">Separate with commas</small>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="fas fa-images"></i> Room Images</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Featured Image *</label>
                                <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(this, 'featured-preview')">
                                <small class="text-muted">Main room image (Max: 2MB)</small>
                                @error('featured_image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <div id="featured-preview" class="mt-2"></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery Images (Optional)</label>
                                <input type="file" name="gallery_images[]" class="form-control" 
                                       accept="image/*" multiple onchange="previewMultipleImages(this, 'gallery-preview')">
                                <small class="text-muted">Upload multiple room images (Max: 2MB each)</small>
                                <div id="gallery-preview" class="row mt-2"></div>
                            </div>

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> <strong>Tip:</strong> High-quality images attract more bookings! 
                                Show different angles of the room, bathroom, view, and amenities.
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('business.hotels.show', $hotel->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Add Room
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Preview single image
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 400px; max-height: 300px;">`;
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
@extends('admin.dashboard')

@section('title', 'Add New Property')
@section('page-title', 'Add Property')

@section('content')
    <div class="container-fluid p-0">

        {{-- Page Header --}}
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Add New Property</h3>
                <p class="text-muted mb-0">Fill in the details below to publish a new real estate listing.</p>
            </div>

            <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 rounded-3">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Properties</span>
            </a>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Basic Information --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2">
                            <i class="bi bi-info-circle fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Basic Information</h5>
                    </div>

                    <div class="row g-3">
                        {{-- Title --}}
                        <div class="col-12 col-md-8">
                            <label class="form-label fw-semibold">Property Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control"
                                placeholder="e.g. Luxurious 5 Marla Modern Villa" value="{{ old('title') }}" required>
                        </div>

                        {{-- Property Type --}}
                        <div class="col-12 col-md-4">
                            <label class="form-label fw-semibold">Property Type <span class="text-danger">*</span></label>
                            <select name="property_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="House" {{ old('property_type') == 'House' ? 'selected' : '' }}>House</option>
                                <option value="Apartment" {{ old('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="Plot" {{ old('property_type') == 'Plot' ? 'selected' : '' }}>Plot</option>
                                <option value="Commercial" {{ old('property_type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Villa" {{ old('property_type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                            </select>
                        </div>

                        {{-- Purpose --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label fw-semibold">Purpose <span class="text-danger">*</span></label>
                            <select name="purpose" class="form-select" required>
                                <option value="">Select Purpose</option>
                                <option value="Sale" {{ old('purpose') == 'Sale' ? 'selected' : '' }}>For Sale</option>
                                <option value="Rent" {{ old('purpose') == 'Rent' ? 'selected' : '' }}>For Rent</option>
                            </select>
                        </div>

                        {{-- Price --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label fw-semibold">Price (PKR) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" placeholder="e.g. 25000000"
                                value="{{ old('price') }}" required>
                        </div>

                        {{-- Status --}}
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label fw-semibold">Listing Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 text-secondary opacity-25">

                    {{-- Property Specs --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2">
                            <i class="bi bi-aspect-ratio fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Area & Specifications</h5>
                    </div>

                    <div class="row g-3">
                        {{-- Area --}}
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Area Size</label>
                            <input type="number" name="area" class="form-control" placeholder="e.g. 5"
                                value="{{ old('area') }}">
                        </div>

                        {{-- Area Unit --}}
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Area Unit</label>
                            <select name="area_unit" class="form-select">
                                <option value="">Select Unit</option>
                                <option value="Marla" {{ old('area_unit') == 'Marla' ? 'selected' : '' }}>Marla</option>
                                <option value="Kanal" {{ old('area_unit') == 'Kanal' ? 'selected' : '' }}>Kanal</option>
                                <option value="Sq Ft" {{ old('area_unit') == 'Sq Ft' ? 'selected' : '' }}>Square Feet</option>
                                <option value="Sq Yards" {{ old('area_unit') == 'Sq Yards' ? 'selected' : '' }}>Square Yards</option>
                            </select>
                        </div>

                        {{-- Bedrooms --}}
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold">Bedrooms</label>
                            <input type="number" name="bedrooms" class="form-control" min="0" placeholder="e.g. 4"
                                value="{{ old('bedrooms') }}">
                        </div>

                        {{-- Bathrooms --}}
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold">Bathrooms</label>
                            <input type="number" name="bathrooms" class="form-control" min="0" placeholder="e.g. 3"
                                value="{{ old('bathrooms') }}">
                        </div>

                        {{-- Kitchens --}}
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold">Kitchens</label>
                            <input type="number" name="kitchens" class="form-control" min="0" placeholder="e.g. 1"
                                value="{{ old('kitchens') }}">
                        </div>
                    </div>

                    <hr class="my-4 text-secondary opacity-25">

                    {{-- Location Information --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2">
                            <i class="bi bi-geo-alt fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Location Information</h5>
                    </div>

                    <div class="row g-3">
                        {{-- Location / Area Name --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">Location / Society</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g. DHA Phase 6"
                                value="{{ old('location') }}">
                        </div>

                        {{-- City --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Lahore"
                                value="{{ old('city') }}">
                        </div>

                        {{-- Complete Address --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Complete Address</label>
                            <textarea name="address" rows="2" class="form-control" placeholder="Enter complete property street and block address">{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <hr class="my-4 text-secondary opacity-25">

                    {{-- Description & Media --}}
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2">
                            <i class="bi bi-card-image fs-5"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">Description & Gallery</h5>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Property Description</label>
                        <textarea name="description" rows="4" class="form-control"
                            placeholder="Write a comprehensive description highlighting key amenities and features...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Property Images with Interactive Live Preview --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Property Images <span class="text-danger">*</span></label>
                        
                        {{-- Drag & Drop Upload Zone --}}
                        <div class="p-4 rounded-3 text-center border border-dashed mb-3" id="dropzoneBox" style="cursor: pointer; transition: all 0.2s ease;">
                            <i class="bi bi-cloud-arrow-up fs-1 text-primary mb-2 d-block"></i>
                            <h6 class="fw-bold text-dark mb-1">Click to browse or drag & drop photos here</h6>
                            <p class="text-muted small mb-0">Supports JPG, PNG, WebP (Multiple images allowed)</p>
                            <input type="file" name="images[]" id="propertyImagesInput" class="d-none" multiple accept="image/*">
                        </div>

                        {{-- Live Previews Grid --}}
                        <div id="imagePreviewContainer" class="row g-3 d-none"></div>
                    </div>

                    {{-- Featured Switch --}}
                    <div class="form-check form-switch mb-4 p-3 bg-light rounded-3 border">
                        <input class="form-check-input ms-0 me-2" type="checkbox" name="featured" value="1" id="featured" {{ old('featured') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-dark" for="featured">
                            <i class="bi bi-star-fill text-warning me-1"></i> Highlight as Featured Property on Homepage
                        </label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <a href="{{ route('properties.index') }}" class="btn btn-light border px-3">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2 shadow-sm rounded-3">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span>Save & Publish</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    {{-- Instant Image Preview Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropzoneBox = document.getElementById('dropzoneBox');
            const imagesInput = document.getElementById('propertyImagesInput');
            const previewContainer = document.getElementById('imagePreviewContainer');

            if (dropzoneBox && imagesInput) {
                dropzoneBox.addEventListener('click', () => imagesInput.click());

                // Drag & Drop visual highlights
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzoneBox.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        dropzoneBox.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzoneBox.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        dropzoneBox.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
                    });
                });

                dropzoneBox.addEventListener('drop', (e) => {
                    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                        imagesInput.files = e.dataTransfer.files;
                        renderPreviews(imagesInput.files);
                    }
                });

                imagesInput.addEventListener('change', function () {
                    renderPreviews(this.files);
                });
            }

            function renderPreviews(files) {
                previewContainer.innerHTML = '';
                
                if (!files || files.length === 0) {
                    previewContainer.classList.add('d-none');
                    return;
                }

                previewContainer.classList.remove('d-none');

                // Header with counter and clear action
                const headerCol = document.createElement('div');
                headerCol.className = 'col-12 d-flex align-items-center justify-content-between mb-1';
                headerCol.innerHTML = `
                    <span class="fw-semibold small text-muted"><i class="bi bi-images me-1"></i> Selected Images (${files.length})</span>
                    <button type="button" id="clearImagesBtn" class="btn btn-link btn-sm text-danger text-decoration-none p-0"><i class="bi bi-x-circle me-1"></i>Clear Selection</button>
                `;
                previewContainer.appendChild(headerCol);

                document.getElementById('clearImagesBtn').addEventListener('click', function () {
                    imagesInput.value = '';
                    previewContainer.innerHTML = '';
                    previewContainer.classList.add('d-none');
                });

                // Generate preview thumbnails
                Array.from(files).forEach((file) => {
                    if (!file.type.startsWith('image/')) return;

                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';

                    const card = document.createElement('div');
                    card.className = 'card border shadow-xs overflow-hidden rounded-3 h-100';

                    const img = document.createElement('img');
                    img.className = 'card-img-top';
                    img.style.height = '110px';
                    img.style.objectFit = 'cover';
                    img.src = URL.createObjectURL(file);
                    img.alt = file.name;

                    const footer = document.createElement('div');
                    footer.className = 'card-footer bg-light p-2 text-center';
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                    footer.innerHTML = `
                        <div class="text-truncate small fw-semibold text-dark mb-0" style="font-size: 0.75rem;" title="${file.name}">${file.name}</div>
                        <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 0.65rem;">${fileSize}</span>
                    `;

                    card.appendChild(img);
                    card.appendChild(footer);
                    col.appendChild(card);
                    previewContainer.appendChild(col);
                });
            }
        });
    </script>
@endsection

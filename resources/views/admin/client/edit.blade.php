@extends('admin.dashboard')

@section('title', 'Edit ' . $buyer->name . ' - Buyer Profile')
@section('page-title', 'Edit Client Profile')

@section('content')

<div class="container-fluid py-4 px-lg-4">

    {{-- Breadcrumb & Back Navigation --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clients') }}" class="text-decoration-none text-muted">
                        Clients & Buyers
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clients.show', $buyer->id) }}" class="text-decoration-none text-muted">
                        {{ $buyer->name }}
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                    Edit Profile
                </li>
            </ol>
        </nav>

        <div>
            <a href="{{ route('admin.clients.show', $buyer->id) }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Profile
            </a>
        </div>
    </div>

    {{-- Header Banner Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="p-4 p-md-5 text-white position-relative"
             style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0d9488 100%);">
            <div class="position-absolute top-0 end-0 p-3 opacity-20">
                <i class="bi bi-person-gear text-white" style="font-size: 6rem; line-height: 1;"></i>
            </div>

            <div class="d-flex align-items-center gap-3 position-relative" style="z-index: 2;">
                <div class="edit-header-badge rounded-circle shadow-sm p-3 d-flex align-items-center justify-content-center"
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-pencil-square fs-3 edit-header-icon"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-1">Edit Client Profile</h3>
                    <p class="mb-0 text-white-50 small">
                        Update personal details, contact info and avatar for {{ $buyer->name }} (Buyer ID #{{ $buyer->id }})
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Validation Errors Alert --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <strong class="fw-bold">Please check the errors below:</strong>
            </div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Main Edit Form --}}
    <form action="{{ route('admin.client.update', $buyer->id) }}"
          method="POST"
          enctype="multipart/form-data"
          id="clientEditForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Left Column: Avatar & Summary Box --}}
            <div class="col-lg-4">
                {{-- Avatar Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 text-center p-4">
                    <h6 class="fw-bold text-dark mb-3 text-start d-flex align-items-center gap-2">
                        <i class="bi bi-image text-primary"></i> Profile Photo
                    </h6>

                    <div class="position-relative d-inline-block mx-auto mb-3">
                        {{-- Avatar Preview Image --}}
                        <div class="avatar-preview-box rounded-circle shadow border border-4 border-light overflow-hidden mx-auto"
                             style="width: 150px; height: 150px; position: relative; background: #f8fafc;">
                            @if ($buyer->image)
                                <img id="buyerAvatarPreview"
                                     src="{{ str_starts_with($buyer->image, 'http') ? $buyer->image : asset($buyer->image) }}"
                                     alt="{{ $buyer->name }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            @else
                                <div id="buyerAvatarFallback"
                                     class="w-100 h-100 d-flex align-items-center justify-content-center text-white fw-bold fs-1"
                                     style="background: linear-gradient(135deg, #2563eb, #10b981);">
                                    {{ strtoupper(substr($buyer->name, 0, 1)) }}
                                </div>
                                <img id="buyerAvatarPreview"
                                     src=""
                                     alt="Preview"
                                     class="w-100 h-100 d-none"
                                     style="object-fit: cover;">
                            @endif
                        </div>

                        {{-- Quick Upload Badge Button --}}
                        <label for="buyerImageInput"
                               class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow-sm border border-2 border-white d-flex align-items-center justify-content-center cursor-pointer"
                               style="width: 42px; height: 42px; cursor: pointer;"
                               title="Choose new photo">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                    </div>

                    {{-- Hidden / Custom File Input --}}
                    <input type="file"
                           name="image"
                           id="buyerImageInput"
                           class="d-none"
                           accept="image/png, image/jpeg, image/jpg, image/webp"
                           onchange="previewBuyerAvatar(event)">

                    <div class="mb-3">
                        <button type="button"
                                class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                onclick="document.getElementById('buyerImageInput').click();">
                            <i class="bi bi-upload me-1"></i> Choose New Photo
                        </button>
                    </div>

                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">
                        Recommended: Square image (JPG, PNG or WEBP). Maximum file size: 2MB.
                    </p>
                </div>

                {{-- Account Details Card --}}
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i> Account Summary
                    </h6>

                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Account Role</span>
                        <span class="badge bg-primary bg-opacity-15 text-primary rounded-pill px-2.5 py-1">
                            Registered Buyer
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Buyer ID</span>
                        <span class="fw-bold text-dark small">#{{ $buyer->id }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <span class="text-muted small">Status</span>
                        <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-2.5 py-1">
                            Active
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Member Since</span>
                        <span class="text-dark small">
                            {{ $buyer->created_at ? $buyer->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Right Column: Information Form Fields --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-transparent border-bottom py-3 px-4">
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-person-lines-fill text-primary"></i> General Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Full Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $buyer->name) }}"
                                           placeholder="e.g. Ali Khan"
                                           required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Address --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $buyer->email) }}"
                                           placeholder="e.g. buyer@example.com"
                                           required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold text-dark">
                                    Phone / WhatsApp Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $buyer->phone) }}"
                                           placeholder="e.g. +92 300 1234567">
                                </div>
                                <div class="form-text small">Used for seller WhatsApp and contact updates.</div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Role (Readonly Display) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">
                                    System Role
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 ps-0 bg-light"
                                           value="Buyer (Registered Client)"
                                           readonly>
                                </div>
                                <div class="form-text small">Role is managed via system roles and permissions.</div>
                            </div>

                            {{-- Residential Address --}}
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold text-dark">
                                    Residential / City Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <textarea class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Enter street address, neighborhood, city, etc.">{{ old('address', $buyer->address) }}</textarea>
                                </div>
                                @error('address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Form Action Buttons --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 pt-4 mt-4 border-top">
                            <a href="{{ route('admin.clients.show', $buyer->id) }}"
                               class="btn btn-light border rounded-3 px-4 py-2">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4 py-2 shadow-sm d-flex align-items-center gap-1.5 fw-semibold">
                                <i class="bi bi-check2-circle fs-5"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

{{-- Instant Avatar Preview Script --}}
<script>
    function previewBuyerAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('buyerAvatarPreview');
            const fallback = document.getElementById('buyerAvatarFallback');

            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            if (fallback) {
                fallback.classList.add('d-none');
            }
        };
        reader.readAsDataURL(file);
    }
</script>

@endsection

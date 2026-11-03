@extends('admin.dashboard')

@section('title', 'Admin Profile - ' . ($Profile->name ?? 'Administrator'))
@section('page-title', 'Admin Profile')

@section('content')

<div class="container-fluid py-4 px-lg-4">

    {{-- Breadcrumb & Quick Action Buttons --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 align-items-center">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item text-muted">Settings</li>
                <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                    Admin Profile
                </li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-light border btn-sm rounded-3 px-3">
                <i class="bi bi-globe me-1"></i> View Live Site
            </a>
        </div>
    </div>

    {{-- Notification Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 d-flex align-items-center gap-3 mb-4 p-3" role="alert">
            <div class="rounded-circle bg-success bg-opacity-20 text-success p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-check2-circle fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-0 text-success">Operation Successful</h6>
                <div class="small text-muted">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 p-3" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                <h6 class="fw-bold text-danger mb-0">Please resolve the following issues:</h6>
            </div>
            <ul class="mb-0 ps-3 small text-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- =========================================================
         1. HERO COVER & PROFILE OVERVIEW CARD
         ========================================================= --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        {{-- Gradient Header Cover --}}
        <div class="position-relative p-4 p-md-5"
             style="background: linear-gradient(135deg, #090d16 0%, #1e3a8a 50%, #2563eb 100%); min-height: 200px;">
            <div class="position-absolute top-0 end-0 p-4 opacity-20 d-none d-md-block">
                <i class="bi bi-shield-lock-fill text-white" style="font-size: 9rem; line-height: 1;"></i>
            </div>
            <div class="position-absolute top-0 start-0 w-100 h-100"
                 style="background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.08) 0%, transparent 60%); pointer-events: none;"></div>

            <div class="d-flex justify-content-between align-items-start position-relative" style="z-index: 2;">
                <span class="badge bg-white bg-opacity-20 text-dark border border-white border-opacity-25 rounded-pill px-3 py-1.5 small fw-semibold">
                    <i class="bi bi-shield-fill-check me-1 text-warning"></i> EstatePro Master Control Panel
                </span>
                <span class="badge bg-dark bg-opacity-40 text-white-50 rounded-pill px-3 py-1.5 small font-monospace">
                    UID: #{{ $Profile->id }}
                </span>
            </div>
        </div>

        {{-- Profile Bar Info --}}
        <div class="card-body p-4 pt-0">
            <div class="row align-items-end g-3">
                {{-- Avatar with Online Pulse Indicator --}}
                <div class="col-auto" style="margin-top: -65px;">
                    <div class="position-relative d-inline-block">
                        @if ($Profile->image)
                            <img id="adminProfileHeroAvatar"
                                 src="{{ str_starts_with($Profile->image, 'http') ? $Profile->image : asset($Profile->image) }}"
                                 alt="{{ $Profile->name }}"
                                 class="rounded-circle shadow-lg border border-4 border-white"
                                 style="width: 130px; height: 130px; object-fit: cover;">
                        @else
                            <div id="adminProfileHeroFallback"
                                 class="rounded-circle shadow-lg border border-4 border-white text-white d-flex align-items-center justify-content-center fw-bold fs-1"
                                 style="width: 130px; height: 130px; background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                                {{ strtoupper(substr($Profile->name ?? 'A', 0, 1)) }}
                            </div>
                            <img id="adminProfileHeroAvatar"
                                 src=""
                                 alt="{{ $Profile->name }}"
                                 class="rounded-circle shadow-lg border border-4 border-white d-none"
                                 style="width: 130px; height: 130px; object-fit: cover;">
                        @endif

                        {{-- Active Status Indicator Dot --}}
                        <span class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle p-2 shadow-sm"
                              title="Active Master Account"
                              style="width: 22px; height: 22px;"></span>
                    </div>
                </div>

                {{-- Name, Roles, & Status Badges --}}
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <h3 class="fw-bold mb-0 text-dark">{{ $Profile->name ?? 'Administrator' }}</h3>

                        {{-- Role Badge --}}
                        <span class="badge bg-primary bg-opacity-15 text-light border border-primary border-opacity-25 rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-shield-fill-check"></i>
                            @php
                                $roleName = $Profile->roles->first()->name ?? ($Profile->role == 'admin' ? 'Super Admin' : 'Super Administrator');
                            @endphp
                            {{ ucfirst($roleName) }}
                        </span>

                        {{-- Status Badge --}}
                        <span class="badge bg-success bg-opacity-15 text-light border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Active Account
                        </span>

                        {{-- Verified Badge --}}
                        <span class="badge bg-info bg-opacity-15 text-dark border border-info border-opacity-25 rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                            <i class="bi bi-patch-check-fill"></i> Verified Identity
                        </span>
                    </div>

                    {{-- Quick Metadata Pill List --}}
                    <p class="text-muted small mb-0 d-flex flex-wrap align-items-center gap-3">
                        <span class="d-inline-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary me-1.5"></i> {{ $Profile->email }}
                        </span>
                        @if ($Profile->phone)
                            <span class="d-inline-flex align-items-center">
                                <i class="bi bi-telephone-fill text-success me-1.5"></i> {{ $Profile->phone }}
                            </span>
                        @endif
                        @if ($Profile->address)
                            <span class="d-inline-flex align-items-center">
                                <i class="bi bi-geo-alt-fill text-danger me-1.5"></i> {{ $Profile->address }}
                            </span>
                        @else
                            <span class="d-inline-flex align-items-center text-muted">
                                <i class="bi bi-geo-alt text-muted me-1.5"></i> Head Office / EstatePro HQ
                            </span>
                        @endif
                        <span class="d-inline-flex align-items-center">
                            <i class="bi bi-calendar3 text-muted me-1.5"></i> Joined {{ $Profile->created_at ? $Profile->created_at->format('M d, Y') : 'System Origin' }}
                        </span>
                    </p>
                </div>

                {{-- Quick Actions --}}
                <div class="col-12 col-md-auto text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#editProfileFormSection" class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-pencil-square"></i> Edit Details
                        </a>
                        <a href="#securitySection" class="btn btn-light border btn-sm rounded-3 px-3 d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-shield-lock"></i> Security
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         2. FULL HEAVY PLATFORM CONTROL METRICS
         ========================================================= --}}
    <div class="row g-3 mb-4">
        {{-- Card 1: Total Properties --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary"
                         style="width: 52px; height: 52px;">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase" style="font-size: 0.72rem;">Properties Managed</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['totalProperties'] ?? \App\Models\Property::count() }}</h4>
                        <small class="text-success fw-semibold" style="font-size: 0.72rem;">
                            <i class="bi bi-check-circle-fill"></i> {{ $stats['activeProperties'] ?? 0 }} Published Active
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Registered Agents --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success"
                         style="width: 52px; height: 52px;">
                        <i class="bi bi-person-badge-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase" style="font-size: 0.72rem;">Certified Agents</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['totalAgents'] ?? \App\Models\User::role('agent')->count() }}</h4>
                        <small class="text-primary fw-semibold" style="font-size: 0.72rem;">
                            <i class="bi bi-patch-check"></i> Verified Network
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Registered Clients --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info"
                         style="width: 52px; height: 52px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase" style="font-size: 0.72rem;">Buyers & Clients</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['totalBuyers'] ?? \App\Models\User::role('buyer')->count() }}</h4>
                        <small class="text-muted" style="font-size: 0.72rem;">
                            Registered userbase
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 4: Inquiries Managed --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning"
                         style="width: 52px; height: 52px;">
                        <i class="bi bi-chat-left-dots-fill fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block fw-semibold text-uppercase" style="font-size: 0.72rem;">Client Inquiries</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['totalInquiries'] ?? \App\Models\BuyerInquiry::count() }}</h4>
                        <small class="text-warning fw-semibold" style="font-size: 0.72rem;">
                            <i class="bi bi-hourglass-split"></i> {{ $stats['pendingInquiries'] ?? 0 }} Pending Review
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================
         3. MAIN TWO-COLUMN CONTENT LAYOUT
         ========================================================= --}}
    <div class="row g-4">

        {{-- LEFT COLUMN: STATUS, ROLES & PRIVILEGES (4 COLS) --}}
        <div class="col-12 col-xl-4">

            {{-- Account Status & Master Role Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-person-badge text-primary"></i> Account & Role Status
                    </h5>
                    <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1 small">
                        Operational
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between py-2.5 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Account Status</span>
                            <strong class="text-dark small">Active & Online</strong>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.45rem;"></i> Active
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between py-2.5 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Assigned Role</span>
                            <strong class="text-dark small">Super Administrator</strong>
                        </div>
                        <span class="badge bg-primary bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            Root Master
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between py-2.5 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Authority Level</span>
                            <strong class="text-dark small">Highest Level (Tier 1)</strong>
                        </div>
                        <span class="badge bg-dark bg-opacity-10 text-muted rounded-pill px-2.5 py-1">
                            Full Access
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between py-2.5 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Email Verification</span>
                            <strong class="text-dark small">Primary Identity</strong>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            <i class="bi bi-check-lg me-1"></i> Verified
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between py-2.5 border-bottom">
                        <div>
                            <span class="text-muted small d-block">Account Created</span>
                            <strong class="text-dark small">{{ $Profile->created_at ? $Profile->created_at->format('M d, Y') : 'N/A' }}</strong>
                        </div>
                        <small class="text-muted font-monospace" style="font-size: 0.72rem;">
                            {{ $Profile->created_at ? $Profile->created_at->diffForHumans() : '' }}
                        </small>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2.5">
                        <div>
                            <span class="text-muted small d-block">Last Profile Update</span>
                            <strong class="text-dark small">{{ $Profile->updated_at ? $Profile->updated_at->format('M d, Y') : 'N/A' }}</strong>
                        </div>
                        <small class="text-muted font-monospace" style="font-size: 0.72rem;">
                            {{ $Profile->updated_at ? $Profile->updated_at->diffForHumans() : '' }}
                        </small>
                    </div>
                </div>
            </div>

            {{-- Administrative Privileges Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-success"></i> Master Permissions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">
                        As a Super Administrator, you possess unrestricted administrative rights across all modules.
                    </p>

                    <div class="d-flex flex-column gap-2.5">
                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                            <span class="small text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-houses-fill text-primary"></i> Property Listings Management
                            </span>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">Full CRUD</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                            <span class="small text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-person-badge-fill text-success"></i> Agent Verification & Control
                            </span>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">Granted</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                            <span class="small text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-people-fill text-info"></i> Buyer Account Moderation
                            </span>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">Granted</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                            <span class="small text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-chat-left-dots-fill text-warning"></i> Client Inquiry & Message Moderation
                            </span>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">Granted</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                            <span class="small text-dark fw-semibold d-flex align-items-center gap-2">
                                <i class="bi bi-gear-fill text-secondary"></i> System & Database Configuration
                            </span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">Master</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- System Session & Environment Card --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-hdd-network text-info"></i> System Session Info
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Active IP Address</span>
                        <span class="badge bg-light text-dark border font-monospace">{{ request()->ip() }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="text-muted small">Server Protocol</span>
                        <span class="badge bg-light text-dark border font-monospace">{{ request()->secure() ? 'HTTPS Secure' : 'HTTP Local' }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                        <span class="text-muted small">PHP Version</span>
                        <span class="badge bg-light text-dark border font-monospace">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between py-2">
                        <span class="text-muted small">Application Version</span>
                        <span class="badge bg-light text-dark border font-monospace">Laravel {{ app()->version() }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: EDIT PROFILE & SECURITY FORMS (8 COLS) --}}
        <div class="col-12 col-xl-8">

            {{-- =========================================================
                 SECTION 1: EDIT PROFILE DETAILS & AVATAR
                 ========================================================= --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" id="editProfileFormSection">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square text-primary"></i> Edit Profile Information
                        </h5>
                        <small class="text-muted">Update your administrative credentials, contact details and avatar</small>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 small">
                        Admin Form
                    </span>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="adminProfileForm">
                        @csrf
                        @method('PUT')

                        {{-- Avatar Upload & Live Preview Row --}}
                        <div class="p-3 mb-4 rounded-4 bg-light border d-flex flex-column flex-sm-row align-items-center gap-4">
                            <div class="position-relative">
                                <div class="rounded-circle shadow-sm border border-3 border-white overflow-hidden"
                                     style="width: 100px; height: 100px; background: #e2e8f0;">
                                    @if ($Profile->image)
                                        <img id="adminProfileEditAvatar"
                                             src="{{ str_starts_with($Profile->image, 'http') ? $Profile->image : asset($Profile->image) }}"
                                             alt="{{ $Profile->name }}"
                                             class="w-100 h-100"
                                             style="object-fit: cover;">
                                    @else
                                        <div id="adminProfileEditFallback"
                                             class="w-100 h-100 text-white d-flex align-items-center justify-content-center fw-bold fs-2"
                                             style="background: linear-gradient(135deg, #1e3a8a, #2563eb);">
                                            {{ strtoupper(substr($Profile->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <img id="adminProfileEditAvatar"
                                             src=""
                                             alt="Preview"
                                             class="w-100 h-100 d-none"
                                             style="object-fit: cover;">
                                    @endif
                                </div>

                                <label for="adminImageInput"
                                       class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-1.5 shadow-sm border border-2 border-white d-flex align-items-center justify-content-center cursor-pointer"
                                       style="width: 32px; height: 32px; cursor: pointer;"
                                       title="Upload new photo">
                                    <i class="bi bi-camera-fill" style="font-size: 0.85rem;"></i>
                                </label>
                            </div>

                            <div class="flex-grow-1 text-center text-sm-start">
                                <h6 class="fw-bold text-dark mb-1">Profile Photo</h6>
                                <p class="text-muted small mb-2" style="font-size: 0.8rem;">
                                    Upload a square photo (JPG, PNG, or WEBP). Maximum recommended file size: 2MB.
                                </p>
                                <input type="file"
                                       name="image"
                                       id="adminImageInput"
                                       class="d-none"
                                       accept="image/png, image/jpeg, image/jpg, image/webp"
                                       onchange="previewAdminProfileAvatar(event)">
                                <button type="button"
                                        class="btn btn-outline-primary btn-sm rounded-3 px-3"
                                        onclick="document.getElementById('adminImageInput').click();">
                                    <i class="bi bi-upload me-1"></i> Choose New Photo
                                </button>
                            </div>
                        </div>

                        {{-- Form Inputs Grid --}}
                        <div class="row g-3">
                            {{-- Admin Name --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                           name="name"
                                           class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                           value="{{ old('name', $Profile->name) }}"
                                           required
                                           placeholder="e.g. Syed Muneeb Shah">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Admin Email --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email', $Profile->email) }}"
                                           required
                                           placeholder="e.g. admin@estatepro.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Admin Phone --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    Phone Number
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="text"
                                           name="phone"
                                           class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $Profile->phone) }}"
                                           placeholder="e.g. +92 328 4512561">
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Admin Role (Read-only System Indicator) --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    Role Designation
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-shield-check"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control border-start-0 ps-0 bg-light"
                                           value="Super Administrator (System Root)"
                                           readonly
                                           disabled>
                                </div>
                                <small class="text-muted" style="font-size: 0.72rem;">Role is managed via system access permissions</small>
                            </div>

                            {{-- Admin Address / Office Location --}}
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">
                                    Office / Physical Address
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2.5">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <textarea name="address"
                                              rows="2"
                                              class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror"
                                              placeholder="e.g. EstatePro Headquarters, Boulevard Avenue, Sector 5">{{ old('address', $Profile->address) }}</textarea>
                                </div>
                                @error('address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <button type="reset" class="btn btn-light border rounded-3 px-3 py-2">
                                Reset Changes
                            </button>
                            <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 shadow-sm d-inline-flex align-items-center gap-1.5 fw-semibold">
                                <i class="bi bi-check2-circle fs-5"></i> Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- =========================================================
                 SECTION 2: SECURITY & PASSWORD UPDATE
                 ========================================================= --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="securitySection">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock-fill text-danger"></i> Account Security & Password
                        </h5>
                        <small class="text-muted">Ensure your account is protected with a long, strong random password</small>
                    </div>
                    <span class="badge bg-danger bg-opacity-15 text-light rounded-pill px-3 py-1 small">
                        Security
                    </span>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Current Password --}}
                            <div class="col-12">
                                <label class="form-label small fw-semibold text-dark">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-key-fill"></i>
                                    </span>
                                    <input type="password"
                                           name="current_password"
                                           id="current_password_input"
                                           class="form-control border-start-0 border-end-0 ps-0 @error('current_password') is-invalid @enderror"
                                           required
                                           placeholder="Enter your existing password">
                                    <button class="btn btn-light border border-start-0 text-muted"
                                            type="button"
                                            onclick="togglePasswordVisibility('current_password_input', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-shield-lock"></i>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="new_password_input"
                                           class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                                           required
                                           placeholder="At least 8 characters">
                                    <button class="btn btn-light border border-start-0 text-muted"
                                            type="button"
                                            onclick="togglePasswordVisibility('new_password_input', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm New Password --}}
                            <div class="col-12 col-md-6">
                                <label class="form-label small fw-semibold text-dark">
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-check2-circle"></i>
                                    </span>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="confirm_password_input"
                                           class="form-control border-start-0 border-end-0 ps-0"
                                           required
                                           placeholder="Repeat new password">
                                    <button class="btn btn-light border border-start-0 text-muted"
                                            type="button"
                                            onclick="togglePasswordVisibility('confirm_password_input', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Security Recommendations --}}
                        <div class="p-3 my-4 rounded-3 bg-light border small text-muted">
                            <div class="fw-semibold text-dark mb-1 d-flex align-items-center gap-1.5">
                                <i class="bi bi-info-circle text-primary"></i> Password Requirements:
                            </div>
                            <ul class="mb-0 ps-3">
                                <li>Minimum 8 characters in length.</li>
                                <li>Use a combination of uppercase letters, numbers and special symbols.</li>
                                <li>Avoid sharing administrative passwords across team members.</li>
                            </ul>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-danger rounded-3 px-4 py-2 shadow-sm d-inline-flex align-items-center gap-1.5 fw-semibold">
                                <i class="bi bi-shield-check fs-5"></i> Update Account Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>

{{-- =========================================================
     SCRIPTS: INSTANT AVATAR PREVIEW & PASSWORD TOGGLE
     ========================================================= --}}
<script>
    function previewAdminProfileAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            // Update preview in edit section
            const editAvatar = document.getElementById('adminProfileEditAvatar');
            const editFallback = document.getElementById('adminProfileEditFallback');
            if (editAvatar) {
                editAvatar.src = e.target.result;
                editAvatar.classList.remove('d-none');
            }
            if (editFallback) {
                editFallback.classList.add('d-none');
            }

            // Update preview in hero banner
            const heroAvatar = document.getElementById('adminProfileHeroAvatar');
            const heroFallback = document.getElementById('adminProfileHeroFallback');
            if (heroAvatar) {
                heroAvatar.src = e.target.result;
                heroAvatar.classList.remove('d-none');
            }
            if (heroFallback) {
                heroFallback.classList.add('d-none');
            }
        };
        reader.readAsDataURL(file);
    }

    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.className = 'bi bi-eye-slash';
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.className = 'bi bi-eye';
            }
        }
    }
</script>

@endsection
@extends('admin.dashboard')

@section('title', $buyer->name . ' - Buyer Profile')
@section('page-title', 'Client Details')

@section('content')

@php
    // Inquiries sent by this client
    $buyerInquiries = \App\Models\BuyerInquiry::with(['property.images', 'agentProperty.images'])
        ->where('buyer_id', $buyer->id)
        ->latest()
        ->get();

    // Saved properties by this client
    $savedProperties = \App\Models\SavedProperty::with(['property.images'])
        ->where('buyer_id', $buyer->id)
        ->latest()
        ->get();

    $totalInquiries = $buyerInquiries->count();
    $approvedInquiries = $buyerInquiries->where('status', 'approved')->count();
    $pendingInquiries = $buyerInquiries->where('status', 'pending')->count();
    $totalSaved = $savedProperties->count();
@endphp

<div class="container-fluid py-4 px-lg-4">

    {{-- Top Action Bar / Breadcrumb --}}
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
                <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                    {{ $buyer->name }}
                </li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.clients') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Clients
            </a>
            <a href="{{ route('admin.clients.edit', $buyer->id) }}" class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Edit Client
            </a>
            <form action="{{ route('admin.client.delete', $buyer->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Are you sure you want to permanently delete this client?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-3">
                    <i class="bi bi-trash3 me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    {{-- Hero Profile Banner Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        {{-- Gradient Header Cover --}}
        <div class="position-relative p-4 p-md-5"
             style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0d9488 100%); min-height: 180px;">
            <div class="position-absolute top-0 end-0 p-3 opacity-25">
                <i class="bi bi-people-fill text-white" style="font-size: 8rem; line-height: 1;"></i>
            </div>
        </div>

        {{-- Profile Bar Info --}}
        <div class="card-body p-4 pt-0">
            <div class="row align-items-end g-3">
                {{-- Avatar --}}
                <div class="col-auto" style="margin-top: -65px;">
                    <div class="position-relative d-inline-block">
                        @if ($buyer->image)
                            <img src="{{ str_starts_with($buyer->image, 'http') ? $buyer->image : asset($buyer->image) }}"
                                 alt="{{ $buyer->name }}"
                                 class="rounded-circle shadow-lg border border-4 border-white"
                                 style="width: 125px; height: 125px; object-fit: cover;">
                        @else
                            <div class="rounded-circle shadow-lg border border-4 border-white bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-1"
                                 style="width: 125px; height: 125px; background: linear-gradient(135deg, #2563eb, #10b981);">
                                {{ strtoupper(substr($buyer->name, 0, 1)) }}
                            </div>
                        @endif

                        <span class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle p-2"
                              title="Active Account"></span>
                    </div>
                </div>

                {{-- Name & Badges --}}
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <h3 class="fw-bold mb-0 text-dark">{{ $buyer->name }}</h3>
                        <span class="badge bg-primary bg-opacity-15 text-light border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi bi-person-fill me-1"></i> Registered Buyer
                        </span>
                        <span class="badge bg-success bg-opacity-15 text-light border border-success border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Active
                        </span>
                        <span class="badge bg-secondary bg-opacity-10 text-muted border rounded-pill px-2.5 py-1 small">
                            ID: #{{ $buyer->id }}
                        </span>
                    </div>

                    <p class="text-muted small mb-0 d-flex flex-wrap align-items-center gap-3">
                        <span><i class="bi bi-envelope text-primary me-1"></i> {{ $buyer->email }}</span>
                        @if ($buyer->phone)
                            <span><i class="bi bi-telephone text-success me-1"></i> {{ $buyer->phone }}</span>
                        @endif
                        @if ($buyer->address)
                            <span><i class="bi bi-geo-alt text-danger me-1"></i> {{ $buyer->address }}</span>
                        @endif
                        <span><i class="bi bi-calendar3 text-muted me-1"></i> Joined {{ $buyer->created_at ? $buyer->created_at->format('M d, Y') : 'Recently' }}</span>
                    </p>
                </div>

                {{-- Quick Contact Actions --}}
                <div class="col-12 col-md-auto text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="mailto:{{ $buyer->email }}" class="btn btn-light border btn-sm rounded-3 px-3 shadow-xs">
                            <i class="bi bi-envelope-fill text-primary me-1"></i> Email
                        </a>
                        @if ($buyer->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $buyer->phone) }}" target="_blank"
                               class="btn btn-success btn-sm rounded-3 px-3 shadow-xs">
                                <i class="bi bi-whatsapp me-1"></i> WhatsApp
                            </a>
                            <a href="tel:{{ $buyer->phone }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                                <i class="bi bi-telephone-fill me-1"></i> Call
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-chat-left-dots fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Inquiries Sent</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalInquiries }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-heart fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Saved Properties</span>
                        <h4 class="fw-bold mb-0 text-light">{{ $totalSaved }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-check2-circle fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Approved Leads</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $approvedInquiries }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Pending Inquiries</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $pendingInquiries }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Two-Column Layout --}}
    <div class="row g-4">
        {{-- Left Column: Contact & Personal Info Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-person-lines-fill text-primary"></i> Client Information
                    </h5>
                    <a href="{{ route('admin.clients.edit', $buyer->id) }}" class="btn btn-sm btn-link text-decoration-none p-0 text-primary">
                        Edit
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Full Name</span>
                        <div class="fw-semibold text-dark">{{ $buyer->name }}</div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Email Address</span>
                        <div class="fw-semibold text-dark d-flex align-items-center justify-content-between">
                            <span class="text-truncate">{{ $buyer->email }}</span>
                            <a href="mailto:{{ $buyer->email }}" class="text-primary ms-2" title="Send email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Phone Number</span>
                        <div class="fw-semibold text-dark d-flex align-items-center justify-content-between">
                            <span>{{ $buyer->phone ?? 'Not Provided' }}</span>
                            @if ($buyer->phone)
                                <a href="tel:{{ $buyer->phone }}" class="text-success ms-2" title="Call">
                                    <i class="bi bi-telephone-outbound"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Residential Address</span>
                        <div class="fw-semibold text-dark">
                            {{ $buyer->address ?? 'No address registered' }}
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Role & Permission</span>
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                Registered Buyer
                            </span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <span class="text-muted small d-block mb-1">Registration Date</span>
                        <div class="fw-semibold text-dark">
                            {{ $buyer->created_at ? $buyer->created_at->format('F d, Y - h:i A') : 'Unknown' }}
                            <small class="text-muted d-block font-monospace" style="font-size: 0.75rem;">
                                ({{ $buyer->created_at ? $buyer->created_at->diffForHumans() : '' }})
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Client Status Card --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0 text-light d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-success"></i> Account Verification
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <strong class="d-block text-light small">Email Verification</strong>
                            <small class="text-muted">Account authentication</small>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            <i class="bi bi-check-lg me-1"></i> Verified
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <strong class="d-block text-light small">Buyer Dashboard Access</strong>
                            <small class="text-muted">Can browse & submit inquiries</small>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            Active
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block text-light small">Engagement Score</strong>
                            <small class="text-muted">Inquiries & favorites</small>
                        </div>
                        <span class="fw-bold text-light">{{ $totalInquiries + $totalSaved }} activities</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Inquiries & Saved Properties --}}
        <div class="col-lg-8">
            {{-- Inquiries Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-chat-left-dots-fill text-primary"></i> Inquiries Sent
                        </h5>
                        <small class="text-muted">Property inquiries sent by {{ $buyer->name }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-1.5">
                        {{ $buyerInquiries->count() }} Inquiries
                    </span>
                </div>

                <div class="card-body p-0">
                    @if ($buyerInquiries->isEmpty())
                        <div class="text-center py-5 px-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px;">
                                <i class="bi bi-chat-dots text-muted fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Inquiries Sent Yet</h6>
                            <p class="text-muted small mb-0">This buyer has not contacted any property seller or agent yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Property</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buyerInquiries as $inquiry)
                                        @php
                                            $prop = $inquiry->property ?? $inquiry->agentProperty;
                                            $propImg = $prop && $prop->images && $prop->images->first() ? $prop->images->first()->image : null;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($propImg)
                                                        <img src="{{ asset('storage/' . $propImg) }}"
                                                             alt="{{ $prop->title ?? 'Property' }}"
                                                             class="rounded-3 shadow-xs"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted"
                                                             style="width: 50px; height: 50px;">
                                                            <i class="bi bi-house fs-5"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="fw-bold text-dark d-block text-truncate" style="max-width: 200px;">
                                                            {{ $prop->title ?? 'Property #' . $inquiry->property_id }}
                                                        </span>
                                                        <small class="text-muted">
                                                            PKR {{ number_format($prop->price ?? 0) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted small d-inline-block text-truncate" style="max-width: 200px;" title="{{ $inquiry->message }}">
                                                    "{{ $inquiry->message }}"
                                                </span>
                                                @if ($inquiry->reply)
                                                    <div class="text-primary small mt-1">
                                                        <i class="bi bi-reply-fill"></i> Replied
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $inquiry->status == 'approved' ? 'bg-success' : ($inquiry->status == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill px-2.5 py-1 small">
                                                    {{ ucfirst($inquiry->status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $inquiry->created_at ? $inquiry->created_at->format('M d, Y') : '-' }}
                                                </small>
                                            </td>
                                            <td class="text-end pe-4">
                                                @if ($prop)
                                                    <a href="{{ route('properties.show', $prop->id) }}"
                                                       class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1"
                                                       title="View Property">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Saved Properties Card --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-heart-fill text-danger"></i> Saved Properties (Wishlist)
                        </h5>
                        <small class="text-muted">Properties bookmarked by {{ $buyer->name }}</small>
                    </div>
                    <span class="badge bg-danger text-light rounded-pill px-3 py-1">
                        {{ $savedProperties->count() }} Saved
                    </span>
                </div>

                <div class="card-body p-0">
                    @if ($savedProperties->isEmpty())
                        <div class="text-center py-5 px-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px;">
                                <i class="bi bi-heart text-muted fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Saved Properties</h6>
                            <p class="text-muted small mb-0">This buyer hasn't saved any properties to their favorites yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Property</th>
                                        <th>Location</th>
                                        <th>Price</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($savedProperties as $saved)
                                        @php
                                            $property = $saved->property;
                                            if (!$property) continue;
                                            $firstImage = $property->images ? $property->images->first() : null;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage->image) }}"
                                                             alt="{{ $property->title }}"
                                                             class="rounded-3 shadow-xs"
                                                             style="width: 48px; height: 48px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted"
                                                             style="width: 48px; height: 48px;">
                                                            <i class="bi bi-building fs-5"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <span class="fw-bold text-dark d-block text-truncate" style="max-width: 240px;">
                                                            {{ $property->title }}
                                                        </span>
                                                        <small class="badge bg-light text-dark border px-2 py-0.5" style="font-size: 0.7rem;">
                                                            {{ ucfirst($property->property_type ?? 'Property') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt me-1 text-danger"></i>
                                                    {{ $property->location ?? $property->city }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    PKR {{ number_format($property->price ?? 0) }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('properties.show', $property->id) }}"
                                                   class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1"
                                                   title="View Property">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

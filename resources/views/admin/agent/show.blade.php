@extends('admin.dashboard')

@section('title', $agent->name . ' - Agent Profile')
@section('page-title', 'Agent Details')

@section('content')

@php
    // Fetch Agent Properties from both tables
    $agentProperties = \App\Models\AgentProperty::with('images')
        ->where('user_id', $agent->id)
        ->latest()
        ->get();

    if ($agentProperties->isEmpty()) {
        $agentProperties = \App\Models\Property::with('images')
            ->where('user_id', $agent->id)
            ->where('owner_type', 'agent')
            ->latest()
            ->get();
    }

    $totalListings = $agentProperties->count();
    $activeListings = $agentProperties->where('status', 'active')->count();
    $featuredListings = $agentProperties->where('featured', 1)->count();

    // Inquiries on this agent's properties
    $agentInquiries = \App\Models\BuyerInquiry::with(['buyer', 'property'])
        ->where(function ($q) use ($agent) {
            $q->whereHas('property', function ($query) use ($agent) {
                $query->where('user_id', $agent->id)->where('owner_type', 'agent');
            })->orWhere(function ($sub) use ($agent) {
                $sub->where('property_source', 'agentproperties')
                    ->whereHas('agentProperty', function ($ap) use ($agent) {
                        $ap->where('user_id', $agent->id);
                    });
            });
        })
        ->latest()
        ->take(10)
        ->get();

    $inquiryCount = $agentInquiries->count();
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
                    <a href="{{ route('admin.agents') }}" class="text-decoration-none text-muted">
                        Agents
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold" aria-current="page">
                    {{ $agent->name }}
                </li>
            </ol>
        </nav>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.agents') }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Agents
            </a>
            <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Edit Agent
            </a>
            <form action="{{ route('admin.agents.delete', $agent->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Are you sure you want to permanently delete this agent?');">
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
                <i class="bi bi-buildings-fill text-white" style="font-size: 8rem; line-height: 1;"></i>
            </div>
        </div>

        {{-- Profile Bar Info --}}
        <div class="card-body p-4 pt-0">
            <div class="row align-items-end g-3">
                {{-- Avatar --}}
                <div class="col-auto" style="margin-top: -65px;">
                    <div class="position-relative d-inline-block">
                        @if ($agent->image)
                            <img src="{{ str_starts_with($agent->image, 'http') ? $agent->image : asset($agent->image) }}"
                                 alt="{{ $agent->name }}"
                                 class="rounded-circle shadow-lg border border-4 border-white"
                                 style="width: 125px; height: 125px; object-fit: cover;">
                        @else
                            <div class="rounded-circle shadow-lg border border-4 border-white bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-1"
                                 style="width: 125px; height: 125px; background: linear-gradient(135deg, #2563eb, #10b981);">
                                {{ strtoupper(substr($agent->name, 0, 1)) }}
                            </div>
                        @endif

                        <span class="position-absolute bottom-0 end-0 bg-success border border-3 border-white rounded-circle p-2"
                              title="Active Account"></span>
                    </div>
                </div>

                {{-- Name & Badges --}}
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <h3 class="fw-bold mb-0 text-dark">{{ $agent->name }}</h3>
                        <span class="badge bg-primary bg-opacity-15 text-light border border-primary border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi bi-patch-check-fill me-1"></i> Certified Agent
                        </span>
                        <span class="badge bg-success bg-opacity-15 text-light border border-success border-opacity-25 rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Active
                        </span>
                        <span class="badge bg-secondary bg-opacity-10 text-muted border rounded-pill px-2.5 py-1 small">
                            ID: #{{ $agent->id }}
                        </span>
                    </div>

                    <p class="text-muted small mb-0 d-flex flex-wrap align-items-center gap-3">
                        <span><i class="bi bi-envelope text-primary me-1"></i> {{ $agent->email }}</span>
                        @if ($agent->phone)
                            <span><i class="bi bi-telephone text-success me-1"></i> {{ $agent->phone }}</span>
                        @endif
                        @if ($agent->address)
                            <span><i class="bi bi-geo-alt text-danger me-1"></i> {{ $agent->address }}</span>
                        @endif
                        <span><i class="bi bi-calendar3 text-muted me-1"></i> Joined {{ $agent->created_at ? $agent->created_at->format('M d, Y') : 'Recently' }}</span>
                    </p>
                </div>

                {{-- Quick Contact Actions --}}
                <div class="col-12 col-md-auto text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="mailto:{{ $agent->email }}" class="btn btn-light border btn-sm rounded-3 px-3 shadow-xs">
                            <i class="bi bi-envelope-fill text-primary me-1"></i> Email
                        </a>
                        @if ($agent->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->phone) }}" target="_blank"
                               class="btn btn-success btn-sm rounded-3 px-3 shadow-xs">
                                <i class="bi bi-whatsapp me-1"></i> WhatsApp
                            </a>
                            <a href="tel:{{ $agent->phone }}" class="btn btn-outline-secondary btn-sm rounded-3 px-3">
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
                        <i class="bi bi-buildings fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Total Listings</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalListings }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Active Listings</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $activeListings }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-star fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Featured</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $featuredListings }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 d-flex align-items-center justify-content-center"
                         style="width: 50px; height: 50px;">
                        <i class="bi bi-chat-left-dots fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block">Inquiries Handled</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $inquiryCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Two-Column Layout --}}
    <div class="row g-4">
        {{-- Left Column: Contact & Account Info Card --}}
        <div class="col-lg-4">
            {{-- Personal & Contact Information Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-person-lines-fill text-primary"></i> Agent Information
                    </h5>
                    <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-sm btn-link text-decoration-none p-0 text-primary">
                        Edit
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Full Name</span>
                        <div class="fw-semibold text-dark">{{ $agent->name }}</div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Email Address</span>
                        <div class="fw-semibold text-dark d-flex align-items-center justify-content-between">
                            <span class="text-truncate">{{ $agent->email }}</span>
                            <a href="mailto:{{ $agent->email }}" class="text-primary ms-2" title="Send email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Phone Number</span>
                        <div class="fw-semibold text-dark d-flex align-items-center justify-content-between">
                            <span>{{ $agent->phone ?? 'Not Provided' }}</span>
                            @if ($agent->phone)
                                <a href="tel:{{ $agent->phone }}" class="text-success ms-2" title="Call">
                                    <i class="bi bi-telephone-outbound"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Office / Location Address</span>
                        <div class="fw-semibold text-dark">
                            {{ $agent->address ?? 'No address registered' }}
                        </div>
                    </div>

                    <div class="mb-3 pb-3 border-bottom">
                        <span class="text-muted small d-block mb-1">Role & Permission</span>
                        <div>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                Real Estate Agent
                            </span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <span class="text-muted small d-block mb-1">Registration Date</span>
                        <div class="fw-semibold text-dark">
                            {{ $agent->created_at ? $agent->created_at->format('F d, Y - h:i A') : 'Unknown' }}
                            <small class="text-muted d-block font-monospace" style="font-size: 0.75rem;">
                                ({{ $agent->created_at ? $agent->created_at->diffForHumans() : '' }})
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Agent Status & Performance Card --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0 text-light d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check text-success"></i> Verification Status
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <strong class="d-block text-light small">Email Verification</strong>
                            <small class="text-muted">Verified account</small>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            <i class="bi bi-check-lg me-1"></i> Verified
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <strong class="d-block text-light small">Agent Portal Access</strong>
                            <small class="text-muted">Can login & list properties</small>
                        </div>
                        <span class="badge bg-success bg-opacity-15 text-light rounded-pill px-2.5 py-1">
                            Active
                        </span>
                    </div>

                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <strong class="d-block text-light small">Total Commissionable Deals</strong>
                            <small class="text-muted">Linked portfolio</small>
                        </div>
                        <span class="fw-bold text-light">{{ $totalListings }} properties</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Agent's Listed Properties & Inquiries --}}
        <div class="col-lg-8">
            {{-- Properties Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-house-door-fill text-primary"></i> Listed Properties
                        </h5>
                        <small class="text-muted">Properties managed and listed by {{ $agent->name }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-1.5">
                        {{ $agentProperties->count() }} Properties
                    </span>
                </div>

                <div class="card-body p-0">
                    @if ($agentProperties->isEmpty())
                        <div class="text-center py-5 px-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px;">
                                <i class="bi bi-houses text-muted fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Properties Listed Yet</h6>
                            <p class="text-muted small mb-0">This agent has not published any property listings yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Property</th>
                                        <th>Type & Purpose</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agentProperties as $property)
                                        @php
                                            $firstImage = $property->images && $property->images->first() ? $property->images->first()->image : null;
                                        @endphp
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if ($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage) }}"
                                                             alt="{{ $property->title }}"
                                                             class="rounded-3 shadow-xs"
                                                             style="width: 54px; height: 54px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted"
                                                             style="width: 54px; height: 54px;">
                                                            <i class="bi bi-image fs-5"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('properties.show', $property->id) }}"
                                                           class="fw-bold text-dark text-decoration-none d-block text-truncate"
                                                           style="max-width: 260px;"
                                                           title="{{ $property->title }}">
                                                            {{ $property->title }}
                                                        </a>
                                                        <small class="text-muted">
                                                            <i class="bi bi-geo-alt me-1 text-danger"></i>
                                                            {{ $property->location ?? $property->city }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border px-2.5 py-1 small">
                                                    {{ ucfirst($property->property_type ?? 'Property') }}
                                                </span>
                                                <span class="badge {{ ($property->purpose ?? '') == 'Sale' ? 'bg-primary' : 'bg-success' }} text-white px-2 py-0.5 rounded-pill" style="font-size: 0.68rem;">
                                                    For {{ $property->purpose ?? 'Sale' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    PKR {{ number_format($property->price ?? 0) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (($property->status ?? 'active') == 'active')
                                                    <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-2.5 py-1">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-15 text-muted rounded-pill px-2.5 py-1">
                                                        {{ ucfirst($property->status ?? 'Draft') }}
                                                    </span>
                                                @endif
                                                @if ($property->featured ?? false)
                                                    <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                                        <i class="bi bi-star-fill"></i>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('properties.show', $property->id) }}"
                                                   class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1"
                                                   title="View Property Details">
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

            {{-- Recent Inquiries Card --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-chat-left-dots-fill text-info"></i> Recent Client Inquiries
                        </h5>
                        <small class="text-muted">Messages sent by potential buyers regarding this agent's properties</small>
                    </div>
                    <span class="badge bg-info bg-opacity-15 text-light rounded-pill px-3 py-1">
                        {{ $agentInquiries->count() }} Leads
                    </span>
                </div>

                <div class="card-body p-0">
                    @if ($agentInquiries->isEmpty())
                        <div class="text-center py-5 px-3">
                            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 70px; height: 70px;">
                                <i class="bi bi-chat-dots text-muted fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">No Inquiries Received</h6>
                            <p class="text-muted small mb-0">No buyer messages or inquiries have been received for this agent's properties yet.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($agentInquiries as $inquiry)
                                <div class="list-group-item p-3 px-4">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold"
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($inquiry->buyer->name ?? ($inquiry->name ?? 'B'), 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">
                                                    {{ $inquiry->buyer->name ?? ($inquiry->name ?? 'Interested Buyer') }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-envelope me-1"></i> {{ $inquiry->buyer->email ?? ($inquiry->email ?? 'N/A') }}
                                                    @if($inquiry->created_at)
                                                        â€¢ <i class="bi bi-clock me-1"></i> {{ $inquiry->created_at->diffForHumans() }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>

                                        <span class="badge {{ $inquiry->status == 'approved' ? 'bg-success' : ($inquiry->status == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }} rounded-pill px-2.5 py-1 small">
                                            {{ ucfirst($inquiry->status ?? 'pending') }}
                                        </span>
                                    </div>

                                    <div class="bg-light rounded-3 p-3 mt-2 text-dark small">
                                        "{{ $inquiry->message }}"
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

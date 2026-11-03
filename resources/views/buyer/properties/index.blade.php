@extends('buyer.dashboard')

@section('title', 'Browse Properties')
@section('page-title', 'Browse Properties')

@section('content')
    <div class="container-fluid p-0">

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ================= HERO SEARCH BANNER ================= --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="background: linear-gradient(135deg, rgba(37,99,235,0.2), rgba(15,23,42,0.9)), url('{{ asset('images/hero.jpg') }}') center/cover; border: 1px solid var(--card-border) !important;">
            <div class="card-body p-4 p-lg-5">
                <div class="col-lg-8">
                    <span class="badge bg-primary px-3 py-1 rounded-pill mb-3">
                        <i class="bi bi-house-heart me-1"></i> EstatePro Marketplace
                    </span>

                    <h1 class="display-6 fw-bold text-white mb-2">
                        Find Your Perfect <span class="text-warning">Property</span>
                    </h1>

                    <p class="text-white-50 fs-6 mb-4">
                        Discover verified houses, plots, apartments, and commercial properties.
                    </p>

                    {{-- Search Bar --}}
                    <div class="p-2 rounded-3 shadow-lg" style="background-color: var(--card-bg); border: 1px solid var(--card-border);">
                        <form action="{{ route('home') }}" method="GET" class="m-0">
                            <div class="row g-2">
                                <div class="col-12 col-md-5">
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                                        <input type="text" name="search" class="form-control border-0" placeholder="Search location or title...">
                                    </div>
                                </div>

                                <div class="col-6 col-md-3">
                                    <select name="property_type" class="form-select border-0">
                                        <option value="">All Types</option>
                                        <option value="house">House</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="plot">Plot</option>
                                        <option value="villa">Villa</option>
                                        <option value="commercial">Commercial</option>
                                    </select>
                                </div>

                                <div class="col-6 col-md-2">
                                    <select name="purpose" class="form-select border-0">
                                        <option value="">Purpose</option>
                                        <option value="sale">For Sale</option>
                                        <option value="rent">For Rent</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-2">
                                    <button type="submit" class="btn btn-primary w-100 rounded-2 d-flex align-items-center justify-content-center gap-1">
                                        <i class="bi bi-search"></i>
                                        <span>Search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= QUICK STAT METRICS ================= --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="stat-card p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">{{ $properties->count() }}</h3>
                            <small class="text-muted">Total Available Properties</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stat-card p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-3 p-3 me-3">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">{{ $properties->where('featured', 1)->count() }}</h3>
                            <small class="text-muted">Featured Listings</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="stat-card p-3 p-md-4 h-100">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-3 p-3 me-3">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold text-dark mb-0">{{ \App\Models\BuyerInquiry::where('buyer_id', auth()->id())->count() }}</h3>
                            <small class="text-muted">Inquiries Submitted</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= FEATURED PROPERTIES ================= --}}
        @if($properties->where('featured', 1)->count() > 0)
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <div>
                        <span class="text-primary fw-semibold small text-uppercase"><i class="bi bi-star-fill text-warning me-1"></i> Featured Homes</span>
                        <h4 class="fw-bold text-dark mb-0">Premium Listings</h4>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    @foreach($properties->where('featured', 1)->take(3) as $property)
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card property-grid-card border-0 shadow-sm h-100">
                                <div class="property-img-wrapper">
                                    @if ($property->images && $property->images->count() > 0)
                                        <img src="{{ asset('storage/' . $property->images->first()->image) }}" alt="{{ $property->title }}">
                                    @else
                                        <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-house-door fs-1"></i>
                                        </div>
                                    @endif

                                    <div class="position-absolute top-0 start-0 m-3 d-flex gap-2">
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                            <i class="bi bi-star-fill me-1"></i> Featured
                                        </span>
                                        <span class="badge {{ $property->purpose == 'Sale' ? 'bg-success' : 'bg-info text-dark' }} rounded-pill px-2 py-1">
                                            For {{ ucfirst($property->purpose) }}
                                        </span>
                                    </div>

                                    {{-- Save Wishlist Button --}}
                                    <form action="{{ route('user.properties.save', $property->id) }}" method="POST" class="position-absolute top-0 end-0 m-3">
                                        @csrf
                                        @php
                                            $isSaved = $property->isSavedByBuyer();
                                        @endphp
                                        <button type="submit" class="btn btn-sm {{ $isSaved ? 'btn-danger' : 'btn-light' }} rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="{{ $isSaved ? 'Remove from saved' : 'Save property' }}">
                                            <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="card-body p-4 d-flex flex-column">
                                    <h4 class="fw-bold text-primary mb-1">Rs. {{ number_format($property->price) }}</h4>
                                    <h5 class="fw-bold text-dark text-truncate mb-1" title="{{ $property->title }}">
                                        {{ $property->title }}
                                    </h5>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-geo-alt text-danger me-1"></i> {{ $property->location ?? $property->city ?? 'N/A' }}
                                    </p>

                                    <div class="d-flex justify-content-between text-muted small border-top border-bottom border-light-subtle py-2 mb-3">
                                        <span><i class="bi bi-house text-primary me-1"></i> {{ ucfirst($property->property_type) }}</span>
                                        <span><i class="bi bi-door-open text-primary me-1"></i> {{ $property->bedrooms ?? 0 }} Beds</span>
                                        <span><i class="bi bi-droplet text-primary me-1"></i> {{ $property->bathrooms ?? 0 }} Baths</span>
                                    </div>

                                    <div class="d-flex gap-2 mt-auto">
                                        <a href="{{ route('buyer.properties.detailed', $property->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1 rounded-3">
                                            <i class="bi bi-eye me-1"></i> Details
                                        </a>
                                        <a href="{{ route('buyer.inquiries.create', $property->id) }}" class="btn btn-primary btn-sm flex-grow-1 rounded-3">
                                            <i class="bi bi-chat-dots me-1"></i> Inquiry
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ================= ALL PROPERTIES ================= --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="fw-bold text-dark mb-0">Explore All Properties</h4>
                    <small class="text-muted">Browse full real estate inventory</small>
                </div>
            </div>

            <div class="row g-4">
                @forelse($properties as $property)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card property-grid-card border-0 shadow-sm h-100">
                            <div class="property-img-wrapper">
                                @if ($property->images && $property->images->count() > 0)
                                    <img src="{{ asset('storage/' . $property->images->first()->image) }}" alt="{{ $property->title }}">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                        <i class="bi bi-house-door fs-1"></i>
                                    </div>
                                @endif

                                <div class="position-absolute top-0 start-0 m-3 d-flex gap-2">
                                    <span class="badge {{ $property->purpose == 'Sale' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3 py-1">
                                        For {{ ucfirst($property->purpose) }}
                                    </span>
                                    <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-2 py-1">
                                        {{ $property->property_type }}
                                    </span>
                                </div>

                                {{-- Wishlist Button --}}
                                <form action="{{ route('properties.save', $property->id) }}" method="POST" class="position-absolute top-0 end-0 m-3">
                                    @csrf
                                    @php
                                        $isSaved = $property->isSavedByBuyer();
                                    @endphp
                                    <button type="submit" class="btn btn-sm {{ $isSaved ? 'btn-danger' : 'btn-light' }} rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="{{ $isSaved ? 'Remove from saved' : 'Save property' }}">
                                        <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="card-body p-4 d-flex flex-column">
                                <h4 class="fw-bold text-primary mb-1">Rs. {{ number_format($property->price) }}</h4>
                                <h5 class="fw-bold text-dark text-truncate mb-1" title="{{ $property->title }}">
                                    {{ $property->title }}
                                </h5>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt text-danger me-1"></i> {{ $property->location ?? $property->city ?? 'N/A' }}
                                </p>

                                <div class="d-flex justify-content-between text-muted small border-top border-bottom border-light-subtle py-2 mb-3">
                                    <span><i class="bi bi-house text-primary me-1"></i> {{ ucfirst($property->property_type) }}</span>
                                    <span><i class="bi bi-door-open text-primary me-1"></i> {{ $property->bedrooms ?? 0 }} Beds</span>
                                    <span><i class="bi bi-droplet text-primary me-1"></i> {{ $property->bathrooms ?? 0 }} Baths</span>
                                </div>

                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ route('buyer.properties.detailed', $property->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1 rounded-3">
                                        <i class="bi bi-eye me-1"></i> Details
                                    </a>
                                    <a href="{{ route('buyer.inquiries.create', $property->id) }}" class="btn btn-primary btn-sm flex-grow-1 rounded-3">
                                        <i class="bi bi-chat-dots me-1"></i> Inquiry
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                            <div class="card-body">
                                <i class="bi bi-house-x fs-1 text-muted"></i>
                                <h5 class="fw-bold text-dark mt-3">No Properties Found</h5>
                                <p class="text-muted mb-0">There are currently no active properties available.</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

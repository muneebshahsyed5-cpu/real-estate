@extends('layouts.app')

@section('title', 'EstatePro - Find Your Dream Home & Prime Real Estate')

@section('content')

    {{-- SUCCESS ALERT TOAST --}}
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-4" style="z-index: 1090; margin-top: 70px;">
            <div class="alert alert-success alert-dismissible fade show shadow-lg border-0 rounded-4 d-flex align-items-center gap-3 py-3 px-4 text-dark"
                style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-left: 5px solid #10b981 !important;"
                role="alert">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center p-2"
                    style="width: 36px; height: 36px;">
                    <i class="bi bi-check-lg fs-5"></i>
                </div>
                <div>
                    <strong class="d-block text-dark fw-bold mb-0">Success!</strong>
                    <span class="text-secondary small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close ms-3" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- ================= HERO SECTION ================= -->
    <section class="position-relative text-white overflow-hidden"
        style="background: radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.28) 0%, rgba(9, 13, 22, 0.98) 65%), #090d16; min-height: 85vh; display: flex; align-items: center;">

        {{-- Subtle Grid Pattern --}}
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-20"
            style="background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px); background-size: 28px 28px; pointer-events: none;">
        </div>

        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center g-5 py-4">

                {{-- Left Column: Hero Content --}}
                <div class="col-lg-7 text-center text-lg-start">

                    <div
                        class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary bg-opacity-20 border border-primary border-opacity-30 text-primary-emphasis mb-4 shadow-xs">
                        <span class="badge bg-primary rounded-pill px-2 py-1"><i class="bi bi-patch-check-fill"></i>
                            VERIFIED</span>
                        <span class="small fw-semibold text-white">Pakistan's Trusted Real Estate Platform</span>
                    </div>

                    <h1 class="display-3 fw-bold tracking-tight text-white mb-4 lh-sm">
                        Find a Place You'll <span class="text-gradient">Proudly Call</span> Home.
                    </h1>

                    <p class="lead text-secondary mb-4 col-xl-11" style="font-size: 1.15rem; line-height: 1.8;">
                        Discover verified luxury villas, modern apartments, commercial properties, and residential plots in
                        top locations with zero hidden fees and transparent dealings.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 pt-2 mb-5 mb-lg-0">
                        <a href="#featured-properties"
                            class="btn btn-modern-hero btn-lg px-4 py-3 d-inline-flex align-items-center gap-2">
                            <span>Explore Properties</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <a href="{{ route('user.saved.properties') }}"
                            class="btn btn-outline-hero btn-lg px-4 py-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-heart-fill text-danger"></i>
                            <span>Saved Properties</span>
                        </a>
                    </div>

                    {{-- Trust Markers --}}
                    <div
                        class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-4 pt-4 border-top border-secondary border-opacity-25 mt-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-4"></i>
                            <span class="small text-secondary fw-semibold">100% Verified Titles</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-headset text-primary fs-4"></i>
                            <span class="small text-secondary fw-semibold">24/7 Consultation</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-heart-pulse text-danger fs-4"></i>
                            <span class="small text-secondary fw-semibold">Save & Compare</span>
                        </div>
                    </div>

                </div>

                {{-- Right Column: Search Card --}}
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden"
                        style="background-color: #111827; border: 1px solid rgba(255, 255, 255, 0.12) !important;">

                        <div class="card-header border-bottom border-secondary border-opacity-25 p-3 pb-0"
                            style="background-color: rgba(15, 23, 42, 0.8);">
                            <ul class="nav nav-pills nav-fill gap-2" id="heroSearchTab">
                                <li class="nav-item">
                                    <button class="nav-link active rounded-3 py-2 fw-semibold" id="tab-all"
                                        data-purpose="all" type="button">
                                        <i class="bi bi-grid-fill me-1"></i> All
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-3 py-2 fw-semibold" id="tab-sale" data-purpose="Sale"
                                        type="button">
                                        <i class="bi bi-tag-fill me-1"></i> Buy
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link rounded-3 py-2 fw-semibold" id="tab-rent" data-purpose="Rent"
                                        type="button">
                                        <i class="bi bi-key-fill me-1"></i> Rent
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body p-4">
                            <h5 class="fw-bold text-white mb-1">Find Your Property</h5>
                            <p class="text-secondary small mb-4">Filter through live inventory instantly</p>

                            <form id="heroFilterForm" onsubmit="event.preventDefault(); applyPropertyFilter();">

                                {{-- Property Type --}}
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-bold text-uppercase">Property
                                        Type</label>
                                    <div class="input-group">
                                        <span
                                            class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary">
                                            <i class="bi bi-buildings"></i>
                                        </span>
                                        <select
                                            class="form-select bg-dark text-white border-secondary border-opacity-50 py-2"
                                            id="filterType">
                                            <option value="">All Types (House, Flat, Plot...)</option>
                                            <option value="House">House / Villa</option>
                                            <option value="Apartment">Flat / Apartment</option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Plot">Residential Plot</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Location --}}
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-bold text-uppercase">Location /
                                        City</label>
                                    <div class="input-group">
                                        <span
                                            class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                            id="filterLocation" placeholder="e.g. DHA, Lahore, Islamabad...">
                                    </div>
                                </div>

                                {{-- Price & Beds --}}
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <label class="form-label text-secondary small fw-bold text-uppercase">Max Price
                                            (PKR)</label>
                                        <input type="number"
                                            class="form-control bg-dark text-white border-secondary border-opacity-50 py-2"
                                            id="filterMaxPrice" placeholder="Max Budget">
                                    </div>
                                    <div class="col-6">
                                        <label
                                            class="form-label text-secondary small fw-bold text-uppercase">Bedrooms</label>
                                        <select
                                            class="form-select bg-dark text-white border-secondary border-opacity-50 py-2"
                                            id="filterBedrooms">
                                            <option value="">Any</option>
                                            <option value="1">1+ Bed</option>
                                            <option value="2">2+ Beds</option>
                                            <option value="3">3+ Beds</option>
                                            <option value="4">4+ Beds</option>
                                            <option value="5">5+ Beds</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="btn btn-modern-hero w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-search"></i>
                                    <span>Search Properties</span>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= STATS BAR ================= -->
    <section class="position-relative" style="margin-top: -32px; z-index: 10;">
        <div class="container">
            <div class="card border-0 shadow-lg rounded-4 p-4" style="background: #ffffff; border: 1px solid #e2e8f0;">
                <div class="row text-center g-4">

                    <div class="col-6 col-lg-3">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-flex">
                                <i class="bi bi-buildings fs-3"></i>
                            </div>
                            <div class="text-start">
                                <h3 class="fw-bold text-dark mb-0">{{ $properties->count() ?? 10 }}+</h3>
                                <small class="text-muted fw-semibold">Properties Listed</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 d-flex">
                                <i class="bi bi-people fs-3"></i>
                            </div>
                            @php

                                $clientsCount = \App\Models\User::role('buyer')->count();
                               $saved =  \App\Models\SavedProperty::count();
                            @endphp
                            <div class="text-start">
                                <h3 class="fw-bold text-dark mb-0"> {{ $clientsCount }} </h3>
                                <small class="text-muted fw-semibold">Happy Clients</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 d-flex">
                                <i class="bi bi-geo-alt fs-3"></i>
                            </div>



                            <div class="text-start">
                                <h3 class="fw-bold text-dark mb-0">
                                    {{ $locationCounts->count() }}
                                </h3>

                                <small class="text-muted fw-semibold">Prime Locations</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 d-flex">
                                <i class="bi bi-heart-fill fs-3"></i>
                            </div>
                            <div class="text-start">
                                <h3 class="fw-bold text-dark mb-0">{{$saved}}</h3>
                                <small class="text-muted fw-semibold">Click Heart to Save</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ================= FEATURED PROPERTIES ================= -->
    <section id="featured-properties" class="py-5 mt-4">
        <div class="container py-4">

            {{-- Section Title --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-5">
                <div>
                    <span
                        class="badge bg-warning bg-opacity-20 text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-pill mb-2 fw-semibold">
                        <i class="bi bi-star-fill text-warning me-1"></i> HANDPICKED
                    </span>
                    <h2 class="display-6 fw-bold text-dark mb-1">Featured Properties</h2>
                    <p class="text-muted mb-0">Explore our handpicked featured properties with verified documents.</p>
                </div>
                <a href="#all-properties"
                    class="btn btn-outline-primary d-inline-flex align-items-center gap-2 rounded-pill px-4 py-2">
                    <span>View All Properties</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            {{-- Featured Cards Grid --}}
            <div class="row g-4">
                @forelse($propertiesfeatured as $property)
                    @php
                        $isSaved = false;
                        if (auth()->check()) {
                            $isSaved = \App\Models\SavedProperty::where('buyer_id', auth()->id())
                                ->where('property_id', $property->id)
                                ->exists();
                        }
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4 property-item" data-purpose="{{ $property->purpose }}"
                        data-type="{{ $property->property_type }}" data-price="{{ $property->price }}"
                        data-location="{{ strtolower(($property->location ?? '') . ' ' . ($property->city ?? '')) }}"
                        data-bedrooms="{{ $property->bedrooms ?? 0 }}">

                        <div
                            class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden property-card position-relative">

                            {{-- Property Image Container --}}
                            <div class="position-relative overflow-hidden" style="height: 240px;">
                                @if ($property->images && $property->images->count() > 0)
                                    <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                                        alt="{{ $property->title }}" class="w-100 h-100 property-img"
                                        style="object-fit: cover;">
                                @else
                                    <div
                                        class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center text-white">
                                        <i class="bi bi-buildings fs-1 text-secondary"></i>
                                    </div>
                                @endif

                                {{-- Badges on top-left --}}
                                <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1"
                                    style="z-index: 5;">
                                    <span
                                        class="badge bg-warning text-dark fw-bold rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-star-fill"></i> FEATURED
                                    </span>

                                    @if (isset($property->owner_type))
                                        @if ($property->owner_type == 'admin')
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1 shadow-sm">
                                                ADMIN
                                            </span>
                                        @elseif($property->owner_type == 'agent')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1 shadow-sm">
                                                AGENT
                                            </span>
                                        @elseif($property->owner_type == 'owner')
                                            <span class="badge bg-info text-dark rounded-pill px-3 py-1 shadow-sm">
                                                OWNER
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                {{-- FLOATING SAVE PROPERTY BUTTON (TOP RIGHT) --}}
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                    @auth
                                        <form action="{{ route('user.properties.save', $property->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-save-circle {{ $isSaved ? 'is-saved' : '' }}"
                                                title="{{ $isSaved ? 'Remove from Saved' : 'Save Property' }}">
                                                <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-save-circle"
                                            title="Sign in to save this property">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    @endauth
                                </div>

                                {{-- Price Overlay (Bottom) --}}
                                <div class="position-absolute bottom-0 start-0 w-100 p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); z-index: 4;">
                                    <h4 class="text-white fw-bold mb-0">PKR {{ number_format($property->price) }}</h4>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body p-4 d-flex flex-column">

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-2 fw-semibold">
                                        {{ $property->property_type }}
                                    </span>
                                    <span
                                        class="badge {{ $property->purpose == 'Sale' ? 'bg-primary' : 'bg-success' }} text-white rounded-pill px-2 py-1">
                                        For {{ $property->purpose }}
                                    </span>
                                </div>

                                <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $property->title }}">
                                    {{ $property->title }}
                                </h5>

                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $property->location }}{{ $property->city ? ', ' . $property->city : '' }}
                                </p>

                                {{-- Specs Strip --}}
                                <div
                                    class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3 mb-4 text-secondary small">
                                    <div><i class="bi bi-door-open text-primary"></i> <span
                                            class="fw-semibold">{{ $property->bedrooms ?? 0 }}</span> Beds</div>
                                    <div class="vr opacity-25"></div>
                                    <div><i class="bi bi-droplet text-primary"></i> <span
                                            class="fw-semibold">{{ $property->bathrooms ?? 0 }}</span> Baths</div>
                                    <div class="vr opacity-25"></div>
                                    <div><i class="bi bi-aspect-ratio text-primary"></i> <span
                                            class="fw-semibold">{{ $property->area ?? '-' }}</span>
                                        {{ $property->area_unit ?? '' }}</div>
                                </div>

                                {{-- ACTION BUTTONS ROW --}}
                                <div class="mt-auto">
                                    <div class="d-flex gap-2 mb-2">
                                        {{-- View Details --}}
                                        @if (Route::has('buyer.properties.detailed'))
                                            <a href="{{ route('buyer.properties.detailed', $property->id) }}"
                                                class="btn btn-action-outline flex-grow-1">
                                                <i class="bi bi-eye me-1"></i> Details
                                            </a>
                                        @else
                                            <a href="{{ route('properties.show', $property->id) }}"
                                                class="btn btn-action-outline flex-grow-1">
                                                <i class="bi bi-eye me-1"></i> Details
                                            </a>
                                        @endif

                                        {{-- Save Button in Action Row --}}
                                        @auth
                                            <form action="{{ route('user.properties.save', $property->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn {{ $isSaved ? 'btn-save-active' : 'btn-save-outline' }}"
                                                    title="{{ $isSaved ? 'Saved in your favorites' : 'Save Property' }}">
                                                    <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
                                                    <span>{{ $isSaved ? 'Saved' : 'Save' }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-save-outline"
                                                title="Login to save">
                                                <i class="bi bi-heart me-1"></i> Save
                                            </a>
                                        @endauth
                                    </div>

                                    {{-- Collapsible Inquiry Toggle Button --}}
                                    <button class="btn btn-inquiry-toggle w-100" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#inquiryBoxFeatured{{ $property->id }}">
                                        <i class="bi bi-chat-dots-fill me-1"></i> Send Buyer Inquiry
                                    </button>

                                    {{-- Collapsed Inquiry Form --}}
                                    <div class="collapse mt-2" id="inquiryBoxFeatured{{ $property->id }}">
                                        <div class="card card-body bg-light border-0 p-3 rounded-3">
                                            <form action="{{ route('buyer.inquiries.store', $property->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                                <input type="hidden" name="property_source"
                                                    value="{{ $property->property_source ?? 'properties' }}">

                                                <textarea name="message" class="form-control form-control-sm mb-2 rounded-3" rows="2"
                                                    placeholder="I am interested in this property..." required></textarea>

                                                <button type="submit"
                                                    class="btn btn-primary btn-sm w-100 rounded-3 fw-semibold">
                                                    <i class="bi bi-send-fill me-1"></i> Submit Inquiry
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center py-4 rounded-4 border-0 shadow-sm">
                            <h5 class="mb-1 fw-bold">No Featured Properties Found</h5>
                            <p class="mb-0 text-muted">Featured properties will appear here.</p>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </section>

    <!-- ================= ALL PROPERTIES ================= -->
    <section id="all-properties" class="py-5 bg-white border-top border-bottom">
        <div class="container py-4">

            {{-- Heading & Filter Pills --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-5">
                <div>
                    <span
                        class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-2 fw-semibold">INVENTORY</span>
                    <h2 class="display-6 fw-bold text-dark mb-0">Explore All Properties</h2>
                </div>


                {{-- Filter Pills --}}
                <div class="d-flex flex-wrap gap-2" id="categoryFilterPills">
                    <button class="btn btn-sm btn-primary rounded-pill px-3 active" onclick="filterByCategory('')">All
                        Types</button>
                    <button class="btn btn-sm btn-light border rounded-pill px-3"
                        onclick="filterByCategory('House')">Houses</button>
                    <button class="btn btn-sm btn-light border rounded-pill px-3"
                        onclick="filterByCategory('Apartment')">Flats</button>
                    <button class="btn btn-sm btn-light border rounded-pill px-3"
                        onclick="filterByCategory('Commercial')">Commercial</button>
                    <button class="btn btn-sm btn-light border rounded-pill px-3"
                        onclick="filterByCategory('Plot')">Plots</button>
                </div>
            </div>

            {{-- Properties Grid --}}
            <div class="row g-4" id="allPropertiesGrid">
                @forelse($properties as $property)
                    {{-- {{dd($property)}} --}}
                    @php
                        $isSaved = false;
                        if (auth()->check()) {
                            $isSaved = \App\Models\SavedProperty::where('buyer_id', auth()->id())
                                ->where('property_id', $property->id)
                                ->exists();
                        }
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4 property-item" data-purpose="{{ $property->purpose }}"
                        data-type="{{ $property->property_type }}" data-price="{{ $property->price }}"
                        data-location="{{ strtolower(($property->location ?? '') . ' ' . ($property->city ?? '')) }}"
                        data-bedrooms="{{ $property->bedrooms ?? 0 }}">

                        <div
                            class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden property-card position-relative">

                            {{-- Image Container --}}
                            <div class="position-relative overflow-hidden" style="height: 230px;">
                                @if ($property->images && $property->images->count() > 0)
                                    <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                                        alt="{{ $property->title }}" class="w-100 h-100 property-img"
                                        style="object-fit: cover;">
                                @else
                                    <div
                                        class="w-100 h-100 bg-secondary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-buildings fs-1"></i>
                                    </div>
                                @endif

                                {{-- Badges on top-left --}}
                                <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1"
                                    style="z-index: 5;">
                                    @if (isset($property->owner_type))
                                        @if ($property->owner_type == 'admin')
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1 shadow-sm">
                                                ADMIN
                                            </span>
                                        @elseif($property->owner_type == 'agent')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1 shadow-sm">
                                                AGENT
                                            </span>
                                        @elseif($property->owner_type == 'owner')
                                            <span class="badge bg-info text-dark rounded-pill px-3 py-1 shadow-sm">
                                                OWNER
                                            </span>
                                        @endif
                                    @endif

                                    <span
                                        class="badge {{ $property->purpose == 'Sale' ? 'bg-primary' : 'bg-success' }} text-white rounded-pill px-2 py-1 shadow-sm">
                                        For {{ $property->purpose }}
                                    </span>
                                </div>

                                {{-- FLOATING SAVE PROPERTY BUTTON (TOP RIGHT) --}}
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                    @auth
                                        <form action="{{ route('user.properties.save', $property->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-save-circle {{ $isSaved ? 'is-saved' : '' }}"
                                                title="{{ $isSaved ? 'Remove from Saved' : 'Save Property' }}">
                                                <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-save-circle"
                                            title="Sign in to save this property">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    @endauth
                                </div>

                                {{-- Price Overlay --}}
                                <div class="position-absolute bottom-0 start-0 w-100 p-3"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); z-index: 4;">
                                    <h5 class="text-white fw-bold mb-0">PKR {{ number_format($property->price) }}</h5>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body p-4 d-flex flex-column">

                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-light text-dark border fw-semibold">
                                        {{ $property->property_type }}
                                    </span>
                                    <small class="text-muted"><i class="bi bi-clock"></i>
                                        {{ $property->created_at ? $property->created_at->diffForHumans() : 'Available' }}</small>
                                </div>

                                <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $property->title }}">
                                    {{ $property->title }}
                                </h5>

                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $property->location }}{{ $property->city ? ', ' . $property->city : '' }}
                                </p>

                                {{-- Specs Strip --}}
                                <div
                                    class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3 mb-4 text-secondary small">
                                    <div><i class="bi bi-door-open text-primary"></i> <span
                                            class="fw-semibold">{{ $property->bedrooms ?? 0 }}</span> Beds</div>
                                    <div class="vr opacity-25"></div>
                                    <div><i class="bi bi-droplet text-primary"></i> <span
                                            class="fw-semibold">{{ $property->bathrooms ?? 0 }}</span> Baths</div>
                                    <div class="vr opacity-25"></div>
                                    <div><i class="bi bi-aspect-ratio text-primary"></i> <span
                                            class="fw-semibold">{{ $property->area ?? '-' }}</span>
                                        {{ $property->area_unit ?? '' }}</div>
                                </div>

                                {{-- ACTION BUTTONS ROW --}}
                                <div class="mt-auto">
                                    <div class="d-flex gap-2 mb-2">
                                        {{-- View Details --}}
                                        @if (Route::has('buyer.properties.detailed'))
                                            <a href="{{ route('buyer.properties.detailed', $property->id) }}"
                                                class="btn btn-action-outline flex-grow-1">
                                                <i class="bi bi-eye me-1"></i> Details
                                            </a>
                                        @else
                                            <a href="{{ route('properties.show', $property->id) }}"
                                                class="btn btn-action-outline flex-grow-1">
                                                <i class="bi bi-eye me-1"></i> Details
                                            </a>
                                        @endif

                                        {{-- Save Button in Action Row --}}
                                        @auth
                                            <form action="{{ route('user.properties.save', $property->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="btn {{ $isSaved ? 'btn-save-active' : 'btn-save-outline' }}"
                                                    title="{{ $isSaved ? 'Saved in your favorites' : 'Save Property' }}">
                                                    <i class="bi {{ $isSaved ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
                                                    <span>{{ $isSaved ? 'Saved' : 'Save' }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-save-outline"
                                                title="Login to save">
                                                <i class="bi bi-heart me-1"></i> Save
                                            </a>
                                        @endauth
                                    </div>

                                    {{-- Collapsible Inquiry Toggle Button --}}
                                    <button class="btn btn-inquiry-toggle w-100" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#inquiryBoxAll{{ $property->id }}">
                                        <i class="bi bi-chat-dots-fill me-1"></i> Send Buyer Inquiry
                                    </button>

                                    {{-- Collapsed Inquiry Form --}}
                                    <div class="collapse mt-2" id="inquiryBoxAll{{ $property->id }}">
                                        <div class="card card-body bg-light border-0 p-3 rounded-3">
                                            <form action="{{ route('buyer.inquiries.store', $property->id) }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                                <input type="hidden" name="property_source"
                                                    value="{{ $property->property_source ?? 'properties' }}">

                                                <textarea name="message" class="form-control form-control-sm mb-2 rounded-3" rows="2"
                                                    placeholder="I am interested in this property..." required></textarea>

                                                <button type="submit"
                                                    class="btn btn-primary btn-sm w-100 rounded-3 fw-semibold">
                                                    <i class="bi bi-send-fill me-1"></i> Submit Inquiry
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center py-4 rounded-4">
                            No properties available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- No Results Message for live JS filter --}}
            <div id="noResultsMsg" class="d-none text-center py-5">
                <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                <h5 class="fw-bold text-dark">No Properties Match Your Filter</h5>
                <p class="text-muted small mb-3">Try adjusting your filters or search keywords.</p>
                <button class="btn btn-outline-primary rounded-pill px-4" onclick="resetAllFilters()">Reset All
                    Filters</button>
            </div>

        </div>
    </section>

    <!-- ================= WHY CHOOSE US ================= -->
    <section id="about" class="py-5">
        <div class="container py-4">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill mb-2 fw-semibold">WHY
                        CHOOSE US</span>
                    <h2 class="display-6 fw-bold mt-2 mb-3">
                        Making Real Estate <span class="text-primary">Simple & Secure</span>
                    </h2>

                    <p class="text-muted lead mb-4" style="font-size: 1.05rem;">
                        We connect buyers, sellers, and tenants with verified quality properties while making the entire
                        process simple, transparent, and legally safeguarded.
                    </p>

                    <div class="row g-4">
                        <div class="col-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-patch-check-fill text-primary fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">100% Verified</h6>
                                    <small class="text-muted">Direct checked property listings.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-shield-lock-fill text-success fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Trusted Escrow</h6>
                                    <small class="text-muted">Safe and reliable payments.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-tags-fill text-warning fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">Best Pricing</h6>
                                    <small class="text-muted">Properties for every budget.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-headset text-info fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">24/7 Support</h6>
                                    <small class="text-muted">Expert assistance whenever needed.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="bg-dark rounded-4 p-5 text-white shadow-lg position-relative overflow-hidden"
                        style="background: linear-gradient(135deg, #090d16 0%, #1e293b 100%);">
                        <div class="text-center mb-4">
                            <div class="display-3 mb-2">🏙️</div>
                            <h3 class="fw-bold">Your Property Journey</h3>
                            <p class="text-secondary small">From searching to closing the deal, we're here to help.</p>
                        </div>

                        <div class="row text-center g-3 pt-3 border-top border-secondary border-opacity-25">
                            <div class="col-4">
                                <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold mb-2 shadow-sm"
                                    style="width: 44px; height: 44px;">01</div>
                                <h6 class="fw-bold mb-0">Search</h6>
                                <small class="text-secondary" style="font-size: 0.75rem;">Browse listings</small>
                            </div>
                            <div class="col-4">
                                <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold mb-2 shadow-sm"
                                    style="width: 44px; height: 44px;">02</div>
                                <h6 class="fw-bold mb-0">Save & Inquire</h6>
                                <small class="text-secondary" style="font-size: 0.75rem;">Bookmark favorites</small>
                            </div>
                            <div class="col-4">
                                <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold mb-2 shadow-sm"
                                    style="width: 44px; height: 44px;">03</div>
                                <h6 class="fw-bold mb-0">Move In</h6>
                                <small class="text-secondary" style="font-size: 0.75rem;">Receive keys</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= CTA SECTION ================= -->
    <section class="bg-dark text-white py-5 position-relative overflow-hidden"
        style="background: radial-gradient(circle at 50% 50%, rgba(37, 99, 235, 0.22) 0%, rgba(9, 13, 22, 1) 100%), #090d16;">
        <div class="container py-4 text-center">

            <span class="badge bg-primary px-3 py-1 rounded-pill mb-3 fw-semibold">START TODAY</span>
            <h2 class="display-6 fw-bold mb-3">Ready to Find Your Dream Property?</h2>
            <p class="text-secondary lead col-md-8 mx-auto mb-4" style="font-size: 1.1rem;">
                Browse our latest verified listings, save your top choices, or send direct inquiries today.
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="#properties-section" class="btn btn-modern-hero btn-lg px-5">
                    Explore All Properties
                </a>
                <a href="{{ route('user.saved.properties') }}"
                    class="btn btn-outline-hero btn-lg px-4 d-inline-flex align-items-center gap-2">
                    <i class="bi bi-heart-fill text-danger"></i>
                    <span>View Saved Properties</span>
                </a>
            </div>

        </div>
    </section>

    <!-- ================= EMBEDDED CUSTOM STYLES ================= -->
    <style>
        /* Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Modern Hero Buttons */
        .btn-modern-hero {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 0.75rem;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.4);
            transition: all 0.25s ease;
        }

        .btn-modern-hero:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.55);
        }

        .btn-outline-hero {
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.25s ease;
        }

        .btn-outline-hero:hover {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Property Cards */
        .property-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff;
        }

        .property-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px -8px rgba(0, 0, 0, 0.12) !important;
            border-color: #cbd5e1 !important;
        }

        .property-img {
            transition: transform 0.4s ease;
        }

        .property-card:hover .property-img {
            transform: scale(1.04);
        }

        /* Floating Circular Save Button */
        .btn-save-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.18);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            padding: 0;
        }

        .btn-save-circle:hover {
            transform: scale(1.12);
            color: #ef4444;
            background: #ffffff;
            box-shadow: 0 6px 18px rgba(239, 68, 68, 0.35);
        }

        .btn-save-circle.is-saved {
            color: #ef4444;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
        }

        /* Card Action Row Buttons */
        .btn-action-outline {
            border: 1.5px solid #e2e8f0;
            background: #ffffff;
            color: #0f172a;
            font-weight: 600;
            border-radius: 0.65rem;
            padding: 0.55rem 1rem;
            transition: all 0.2s ease;
        }

        .btn-action-outline:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: #2563eb;
            transform: translateY(-1px);
        }

        .btn-save-outline {
            border: 1.5px solid #fecdd3;
            background: #fff1f2;
            color: #e11d48;
            font-weight: 600;
            border-radius: 0.65rem;
            padding: 0.55rem 0.9rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .btn-save-outline:hover {
            background: #ffe4e6;
            color: #be123c;
            border-color: #fda4af;
            transform: translateY(-1px);
        }

        .btn-save-active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 0.65rem;
            padding: 0.55rem 0.9rem;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
            transition: all 0.2s ease;
        }

        .btn-save-active:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(239, 68, 68, 0.45);
        }

        .btn-inquiry-toggle {
            background: #f1f5f9;
            color: #334155;
            border: 1px dashed #cbd5e1;
            font-weight: 600;
            border-radius: 0.65rem;
            padding: 0.55rem 1rem;
            font-size: 0.88rem;
            transition: all 0.2s ease;
        }

        .btn-inquiry-toggle:hover {
            background: #e2e8f0;
            color: #0f172a;
            border-color: #94a3b8;
        }
    </style>

    @push('scripts')
        <script>
            let activePurpose = 'all';
            let activeCategory = '';

            // Purpose Tab selection in Hero
            document.querySelectorAll('#heroSearchTab button').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('#heroSearchTab button').forEach(btn => btn.classList.remove(
                        'active'));
                    this.classList.add('active');
                    activePurpose = this.getAttribute('data-purpose');
                });
            });

            // Filter by category pills
            function filterByCategory(cat) {
                activeCategory = cat;

                document.querySelectorAll('#categoryFilterPills button').forEach(btn => {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-light');
                    if ((cat === '' && btn.innerText.includes('All')) || (cat !== '' && btn.innerText.includes(cat))) {
                        btn.classList.remove('btn-light');
                        btn.classList.add('btn-primary', 'active');
                    }
                });

                applyPropertyFilter();
            }

            // Apply interactive live filter on properties
            function applyPropertyFilter() {
                const typeVal = document.getElementById('filterType') ? document.getElementById('filterType').value : '';
                const locVal = document.getElementById('filterLocation') ? document.getElementById('filterLocation').value
                    .toLowerCase().trim() : '';
                const maxPrice = document.getElementById('filterMaxPrice') ? parseFloat(document.getElementById(
                    'filterMaxPrice').value) : NaN;
                const bedVal = document.getElementById('filterBedrooms') ? parseInt(document.getElementById('filterBedrooms')
                    .value) : NaN;

                const effectiveType = activeCategory || typeVal;

                const items = document.querySelectorAll('.property-item');
                let visibleCount = 0;

                items.forEach(item => {
                    const itemPurpose = item.getAttribute('data-purpose');
                    const itemType = item.getAttribute('data-type');
                    const itemPrice = parseFloat(item.getAttribute('data-price')) || 0;
                    const itemLocation = item.getAttribute('data-location') || '';
                    const itemBeds = parseInt(item.getAttribute('data-bedrooms')) || 0;

                    let matches = true;

                    // Purpose match
                    if (activePurpose !== 'all' && itemPurpose.toLowerCase() !== activePurpose.toLowerCase()) {
                        matches = false;
                    }

                    // Type match
                    if (effectiveType && itemType.toLowerCase() !== effectiveType.toLowerCase()) {
                        matches = false;
                    }

                    // Location match
                    if (locVal && !itemLocation.includes(locVal)) {
                        matches = false;
                    }

                    // Max price match
                    if (!isNaN(maxPrice) && maxPrice > 0 && itemPrice > maxPrice) {
                        matches = false;
                    }

                    // Bedrooms match
                    if (!isNaN(bedVal) && bedVal > 0 && itemBeds < bedVal) {
                        matches = false;
                    }

                    if (matches) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                const noResults = document.getElementById('noResultsMsg');
                if (noResults) {
                    if (visibleCount === 0) {
                        noResults.classList.remove('d-none');
                    } else {
                        noResults.classList.add('d-none');
                    }
                }

                // Scroll smoothly to properties if submitted from hero
                if (window.event && window.event.type === 'submit') {
                    const section = document.getElementById('all-properties');
                    if (section) {
                        section.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            }

            function resetAllFilters() {
                if (document.getElementById('filterType')) document.getElementById('filterType').value = '';
                if (document.getElementById('filterLocation')) document.getElementById('filterLocation').value = '';
                if (document.getElementById('filterMaxPrice')) document.getElementById('filterMaxPrice').value = '';
                if (document.getElementById('filterBedrooms')) document.getElementById('filterBedrooms').value = '';
                activePurpose = 'all';
                activeCategory = '';

                document.querySelectorAll('#heroSearchTab button').forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.getAttribute('data-purpose') === 'all') btn.classList.add('active');
                });

                document.querySelectorAll('#categoryFilterPills button').forEach(btn => {
                    btn.classList.remove('btn-primary', 'active');
                    btn.classList.add('btn-light');
                    if (btn.innerText.includes('All')) {
                        btn.classList.remove('btn-light');
                        btn.classList.add('btn-primary', 'active');
                    }
                });

                applyPropertyFilter();
            }
        </script>
    @endpush

@endsection

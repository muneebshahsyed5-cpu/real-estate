@extends('user.dashboard')

@section('content')

{{-- ================= WELCOME ================= --}}
<div class="card bg-primary text-white border-0 shadow mb-4">
    <div class="card-body p-4">

        <h2 class="fw-bold">
            Welcome, {{ auth()->user()->name }}! 👋
        </h2>

        <p class="mb-0">
            Find your perfect property and manage your inquiries.
        </p>

    </div>
</div>


{{-- ================= STATISTICS ================= --}}
<div class="row g-4 mb-4">

    {{-- Available Properties --}}
    <div class="col-md-4">

        <a href="{{ route('home') }}" class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Available Properties
                            </p>

                            <h2 class="fw-bold text-dark">
                                {{
                                    \App\Models\Property::count()

                                }}
                             {{-- <span class="badge bg-success">
                    +
                </span> --}}
                            </h2>

                        </div>

                        <div class="text-primary fs-1">
                            <i class="bi bi-buildings"></i>
                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- My Inquiries --}}
    <div class="col-md-4">

        <a href="{{ route('user.inquiries.index') }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                My Inquiries
                            </p>

                            <h2 class="fw-bold text-dark">
                                {{ \App\Models\BuyerInquiry::where('buyer_id', auth()->id())->count() }}
                            </h2>

                        </div>

                        <div class="text-success fs-1">
                            <i class="bi bi-chat-left-text"></i>
                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>


    {{-- Saved Properties --}}
    <div class="col-md-4">

        <a href="{{ route('saved-properties.index') }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Saved Properties
                            </p>

                            <h2 class="fw-bold text-dark">
                                {{ \App\Models\SavedProperty::where('buyer_id', auth()->id())->count() }}
                            </h2>

                        </div>

                        <div class="text-danger fs-1">
                            <i class="bi bi-heart-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>

</div>

@php
    $propertiesfeatured = \App\Models\Property::where('featured', '1')->latest()->get();
@endphp
{{-- ================= FEATURED PROPERTIES ================= --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <h3 class="fw-bold mb-0">
        Featured Properties
    </h3>

    <a href="{{ route('home') }}"
       class="btn btn-primary">
        View All
    </a>

</div>


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

@endsection

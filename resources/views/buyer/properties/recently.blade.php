@extends('buyer.dashboard')

@section('content')

<div class="container py-5">

    {{-- ================= HEADER ================= --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">

        <div>
            <div class="d-flex align-items-center mb-2">
                <div class="bg-primary text-white rounded-3 p-2 me-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>

                <div>
                    <h2 class="fw-bold mb-0">
                        Recently Viewed
                    </h2>

                    <p class="text-muted mb-0">
                        Properties you've recently explored
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-3 mt-md-0">
            <a href="{{ route('home') }}"
               class="btn btn-outline-primary rounded-pill px-4">

                <i class="bi bi-search me-2"></i>
                Explore Properties

            </a>
        </div>

    </div>


    {{-- ================= PROPERTY COUNT ================= --}}
    @if($recentlyViewed->count() > 0)

        <div class="d-flex align-items-center mb-4">

            <span class="badge bg-primary rounded-pill px-3 py-2">
                {{ $recentlyViewed->count() }}
                {{ $recentlyViewed->count() == 1 ? 'Property' : 'Properties' }}
            </span>

            <span class="text-muted ms-3">
                Recently viewed by you
            </span>

        </div>


        {{-- ================= PROPERTY GRID ================= --}}
        <div class="row g-4">

            @foreach($recentlyViewed as $item)

                @php
                    $property = $item->property;

                    $firstImage = $property->images->first();
                @endphp


                @if($property)

                    <div class="col-md-6 col-lg-4">

                        <div class="card property-card border-0 shadow-sm rounded-4 overflow-hidden h-100">


                            {{-- ================= IMAGE ================= --}}
                            <div class="position-relative">

                                @if($firstImage)

                                    <img
                                        src="{{ asset('storage/' . $firstImage->image) }}"
                                        class="property-image"
                                        alt="{{ $property->title }}"
                                    >

                                @else

                                    <div class="property-image bg-light
                                                d-flex align-items-center
                                                justify-content-center">

                                        <div class="text-center text-muted">

                                            <i class="bi bi-house-door fs-1"></i>

                                            <p class="mb-0 mt-2">
                                                No Image
                                            </p>

                                        </div>

                                    </div>

                                @endif


                                {{-- Purpose --}}
                                <div class="position-absolute top-0 start-0 m-3">

                                    <span class="badge bg-primary rounded-pill px-3 py-2">

                                        {{ ucfirst($property->purpose) }}

                                    </span>

                                </div>


                                {{-- Image Count --}}
                                @if($property->images->count() > 0)

                                    <div class="position-absolute bottom-0 end-0 m-3">

                                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2">

                                            <i class="bi bi-images me-1"></i>

                                            {{ $property->images->count() }}

                                        </span>

                                    </div>

                                @endif


                            </div>


                            {{-- ================= CARD BODY ================= --}}
                            <div class="card-body p-4 d-flex flex-column">


                                {{-- Title --}}
                                <h5 class="fw-bold mb-2 text-truncate">

                                    {{ $property->title }}

                                </h5>


                                {{-- Location --}}
                                <p class="text-muted mb-3">

                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>

                                    {{ $property->location }}

                                    @if($property->city)
                                        , {{ $property->city }}
                                    @endif

                                </p>


                                {{-- Price --}}
                                <h4 class="text-primary fw-bold mb-3">

                                    Rs. {{ number_format($property->price) }}

                                </h4>


                                {{-- Property Features --}}
                                <div class="property-features border-top border-bottom py-3 mb-3">

                                    <div class="row text-center g-0">

                                        {{-- Area --}}
                                        <div class="col-4 border-end">

                                            <i class="bi bi-rulers text-primary"></i>

                                            <div class="small fw-semibold mt-1">

                                                {{ $property->area }}
                                                {{ $property->area_unit }}

                                            </div>

                                            <small class="text-muted">
                                                Area
                                            </small>

                                        </div>


                                        {{-- Bedrooms --}}
                                        <div class="col-4 border-end">

                                            <i class="bi bi-door-open text-primary"></i>

                                            <div class="small fw-semibold mt-1">

                                                {{ $property->bedrooms ?? 'N/A' }}

                                            </div>

                                            <small class="text-muted">
                                                Beds
                                            </small>

                                        </div>


                                        {{-- Bathrooms --}}
                                        <div class="col-4">

                                            <i class="bi bi-droplet text-primary"></i>

                                            <div class="small fw-semibold mt-1">

                                                {{ $property->bathrooms ?? 'N/A' }}

                                            </div>

                                            <small class="text-muted">
                                                Baths
                                            </small>

                                        </div>

                                    </div>

                                </div>


                                {{-- Recently Viewed Time --}}
                                <div class="text-muted small mb-3">

                                    <i class="bi bi-clock me-1"></i>

                                    Viewed
                                    {{ $item->updated_at->diffForHumans() }}

                                </div>


                                {{-- Button --}}
                                <div class="mt-auto">

                                    <a href="{{ route('buyer.properties.detailed', $property->id) }}"
                                       class="btn btn-primary w-100 rounded-pill py-2">

                                        View Property

                                        <i class="bi bi-arrow-right ms-2"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    @else


        {{-- ================= EMPTY STATE ================= --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <div class="empty-icon mx-auto mb-4">

                    <i class="bi bi-clock-history"></i>

                </div>

                <h3 class="fw-bold">
                    No Recently Viewed Properties
                </h3>

                <p class="text-muted mx-auto mb-4"
                   style="max-width: 500px;">

                    You haven't viewed any properties yet.
                    Start exploring properties and they will appear here
                    automatically.

                </p>

                <a href="{{ route('home') }}"
                   class="btn btn-primary rounded-pill px-4 py-2">

                    <i class="bi bi-search me-2"></i>

                    Browse Properties

                </a>

            </div>

        </div>

    @endif

</div>


{{-- ================= CUSTOM CSS ================= --}}
<style>

    .property-card {
        transition: all 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12) !important;
    }

    .property-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .property-card:hover .property-image {
        transform: scale(1.04);
    }

    .property-features i {
        font-size: 18px;
    }

    .empty-icon {
        width: 90px;
        height: 90px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: rgba(13, 110, 253, 0.1);

        color: #0d6efd;

        font-size: 40px;
    }

</style>

@endsection

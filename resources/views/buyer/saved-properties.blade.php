@extends('buyer.dashboard')

@section('title', 'Saved Properties')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-heart-fill text-danger me-2"></i>
                Saved Properties
            </h2>
            <p class="text-muted mb-0">
                Properties you have saved for later review
            </p>
        </div>

        <span class="badge bg-primary rounded-pill px-3 py-2">
            {{ $savedProperties->count() }} Saved
        </span>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- No Saved Properties --}}
    @if($savedProperties->isEmpty())
        <div class="card border-0 shadow-sm text-center py-5 rounded-4">
            <div class="card-body">
                <div class="mb-3">
                    <i class="bi bi-heart display-1 text-muted"></i>
                </div>
                <h4 class="fw-bold">
                    No Saved Properties
                </h4>
                <p class="text-muted">
                    You haven't saved any properties yet.
                </p>
                <a href="{{ route('buyer.properties') }}" class="btn btn-primary px-4 rounded-3">
                    <i class="bi bi-search me-2"></i>
                    Explore Properties
                </a>
            </div>
        </div>
    @else
        {{-- Property Grid --}}
        <div class="row g-4">
            @foreach($savedProperties as $saved)
                @php
                    $property = $saved->property;
                    if (!$property) {
                        continue;
                    }
                    $image = $property->images ? $property->images->first() : null;
                @endphp

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                        {{-- Property Image --}}
                        <div class="position-relative" style="height: 220px;">
                            @if($image)
                                <img src="{{ asset('storage/' . $image->image) }}"
                                     class="w-100 h-100"
                                     style="object-fit: cover;"
                                     alt="{{ $property->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center w-100 h-100">
                                    <i class="bi bi-house-door display-3 text-muted"></i>
                                </div>
                            @endif

                            {{-- Saved Badge --}}
                            <span class="position-absolute top-0 end-0 m-3 badge bg-white text-danger shadow-sm px-3 py-2 rounded-pill">
                                <i class="bi bi-heart-fill me-1"></i> Saved
                            </span>

                            @if($property->purpose)
                                <span class="position-absolute top-0 start-0 m-3 badge bg-primary text-white shadow-sm px-3 py-2 rounded-pill">
                                    For {{ ucfirst($property->purpose) }}
                                </span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="badge bg-light text-primary border align-self-start mb-2 px-2.5 py-1">
                                {{ ucfirst($property->property_type ?? 'Property') }}
                            </span>

                            <h5 class="fw-bold mb-2 text-truncate" title="{{ $property->title }}">
                                {{ $property->title }}
                            </h5>

                            {{-- Location --}}
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                {{ $property->location }}{{ $property->city ? ', ' . $property->city : '' }}
                            </p>

                            {{-- Price --}}
                            <h4 class="text-primary fw-bold mb-3">
                                Rs. {{ number_format($property->price) }}
                            </h4>

                            {{-- Property Specs --}}
                            <div class="d-flex gap-3 text-muted small border-top pt-3 mt-auto">
                                @if($property->bedrooms)
                                    <span>
                                        <i class="bi bi-door-open me-1 text-primary"></i>
                                        {{ $property->bedrooms }} Beds
                                    </span>
                                @endif

                                @if($property->bathrooms)
                                    <span>
                                        <i class="bi bi-droplet me-1 text-primary"></i>
                                        {{ $property->bathrooms }} Baths
                                    </span>
                                @endif

                                @if($property->area)
                                    <span>
                                        <i class="bi bi-aspect-ratio me-1 text-primary"></i>
                                        {{ $property->area }} {{ $property->area_unit }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                            <div class="d-flex gap-2">
                                {{-- View Property --}}
                                @if(Route::has('buyer.properties.detailed'))
                                    <a href="{{ route('buyer.properties.detailed', $property->id) }}"
                                       class="btn btn-primary flex-grow-1 rounded-3">
                                        <i class="bi bi-eye me-1"></i> View Details
                                    </a>
                                @else
                                    <a href="{{ route('properties.show', $property->id) }}"
                                       class="btn btn-primary flex-grow-1 rounded-3">
                                        <i class="bi bi-eye me-1"></i> View Details
                                    </a>
                                @endif

                                {{-- Remove --}}
                                <form action="{{ route('properties.save', $property->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-danger rounded-3"
                                            title="Remove from saved properties">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

@endsection

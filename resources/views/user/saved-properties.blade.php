@extends('user.dashboard')

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
                Properties you have saved for later
            </p>
        </div>

        <span class="badge bg-primary rounded-pill px-3 py-2">
            {{ $savedProperties->count() }} Saved
        </span>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- No Saved Properties --}}
    @if($savedProperties->isEmpty())

        <div class="card border-0 shadow-sm text-center py-5">

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

                <a href="{{ url('/properties') }}"
                   class="btn btn-primary px-4">
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
                    $image = $property->images->first();
                @endphp

                <div class="col-xl-4 col-lg-6 col-md-6">

                    <div class="card border-0 shadow-sm h-100 overflow-hidden">

                        {{-- Property Image --}}
                        <div class="position-relative">

                            @if($image)

                                <img src="{{ asset('storage/' . $image->image) }}"
                                     class="w-100"
                                     style="height:230px; object-fit:cover;"
                                     alt="{{ $property->title }}">

                            @else

                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height:230px;">

                                    <i class="bi bi-house-door display-3 text-muted"></i>

                                </div>

                            @endif


                            {{-- Saved Badge --}}
                            <span class="position-absolute top-0 end-0 m-3
                                         badge bg-white text-danger shadow-sm px-3 py-2">

                                <i class="bi bi-heart-fill me-1"></i>
                                Saved

                            </span>

                        </div>


                        {{-- Content --}}
                        <div class="card-body p-4">

                            <h5 class="fw-bold mb-2">
                                {{ $property->title }}
                            </h5>

                            {{-- Location --}}
                            <p class="text-muted mb-3">

                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>

                                {{ $property->location ?? $property->city }}

                            </p>


                            {{-- Price --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h4 class="text-primary fw-bold mb-0">

                                    Rs. {{ number_format($property->price) }}

                                </h4>

                            </div>


                            {{-- Property Details --}}
                            <div class="d-flex gap-3 text-muted small border-top pt-3">

                                @if($property->bedrooms)
                                    <span>
                                        <i class="bi bi-door-open me-1"></i>
                                        {{ $property->bedrooms }} Beds
                                    </span>
                                @endif

                                @if($property->bathrooms)
                                    <span>
                                        <i class="bi bi-droplet me-1"></i>
                                        {{ $property->bathrooms }} Baths
                                    </span>
                                @endif

                                @if($property->area)
                                    <span>
                                        <i class="bi bi-rulers me-1"></i>
                                        {{ $property->area }}
                                        {{ $property->area_unit }}
                                    </span>
                                @endif

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="card-footer bg-white border-0 px-4 pb-4">

                            <div class="d-flex gap-2">

                                {{-- View Property --}}
                                <a href="{{ route('properties.show', $property->id) }}"
                                   class="btn btn-primary flex-grow-1">

                                    <i class="bi bi-eye me-1"></i>
                                    View Property

                                </a>


                                {{-- Remove --}}
                                <form action="{{ route('properties.save', $property->id) }}"
                                      method="POST">

                                    @csrf

                                    <button type="submit"
                                            class="btn btn-outline-danger"
                                            title="Remove from saved">

                                        <i class="bi bi-heart-fill"></i>

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

@extends('buyer.dashboard')

@section('content')

    <div class="container py-5">

        {{-- Breadcrumb --}}
        <div class="mb-4">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                Home
            </a>
            <span class="mx-2">/</span>
            <span class="text-muted">{{ $property->title }}</span>
        </div>


        {{-- ================= IMAGE GALLERY ================= --}}

        @if ($property->images->count() > 0)
            <div class="row g-3 mb-5">

                {{-- Main Image --}}
                <div class="col-lg-8">

                    <div class="position-relative">

                        <img id="mainPropertyImage" src="{{ asset('storage/' . $property->images->first()->image) }}"
                            class="w-100 rounded-4 shadow-sm" style="height: 500px; object-fit: cover;"
                            alt="{{ $property->title }}">

                        {{-- Image count --}}
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 px-3 py-2">
                                <i class="bi bi-images"></i>
                                {{ $property->images->count() }} Photos
                            </span>
                        </div>

                    </div>

                </div>


                {{-- Small Images --}}
                <div class="col-lg-4">

                    <div class="row g-3">

                        @foreach ($property->images->take(4) as $image)
                            <div class="col-6">

                                <img src="{{ asset('storage/' . $image->image) }}"
                                    class="property-thumbnail w-100 rounded-3"
                                    style="height: 240px; object-fit: cover; cursor: pointer;"
                                    onclick="changeMainImage(this.src)" alt="{{ $property->title }}">

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
        @else
            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mb-5" style="height: 500px;">

                <div class="text-center text-muted">
                    <i class="bi bi-house fs-1"></i>
                    <p class="mt-2">No property image available</p>
                </div>

            </div>
        @endif



        {{-- ================= PROPERTY HEADER ================= --}}

        <div class="row g-4">

            {{-- LEFT SIDE --}}
            <div class="col-lg-8">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <span class="badge bg-primary mb-2">
                            {{ ucfirst($property->purpose) }}
                        </span>

                        <h1 class="fw-bold mb-2">
                            {{ $property->title }}
                        </h1>

                        <p class="text-muted fs-5">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            {{ $property->location }}
                            @if ($property->city)
                                , {{ $property->city }}
                            @endif
                        </p>

                    </div>


                    {{-- Save --}}
                    @auth

                        <form action="{{ route('properties.save', $property->id) }}" method="POST">

                            @csrf

                            <button type="submit" class="btn btn-light border rounded-circle shadow-sm"
                                style="width:50px;height:50px;">

                                <i class="bi bi-heart fs-5"></i>

                            </button>

                        </form>

                    @endauth

                </div>


                {{-- Price --}}

                <div class="mt-3 mb-4">

                    <h2 class="text-primary fw-bold">
                        Rs. {{ number_format($property->price) }}
                    </h2>

                </div>



                {{-- ================= PROPERTY FEATURES ================= --}}

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-4">
                            Property Details
                        </h4>

                        <div class="row g-4">

                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-house-door fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Property Type
                                    </h6>

                                    <span class="text-muted">
                                        {{ ucfirst($property->property_type) }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-rulers fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Area
                                    </h6>

                                    <span class="text-muted">
                                        {{ $property->area }}
                                        {{ $property->area_unit }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-door-open fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Bedrooms
                                    </h6>

                                    <span class="text-muted">
                                        {{ $property->bedrooms ?? 'N/A' }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-droplet fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Bathrooms
                                    </h6>

                                    <span class="text-muted">
                                        {{ $property->bathrooms ?? 'N/A' }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-fire fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Kitchens
                                    </h6>

                                    <span class="text-muted">
                                        {{ $property->kitchens ?? 'N/A' }}
                                    </span>

                                </div>

                            </div>


                            <div class="col-6 col-md-3">

                                <div class="text-center">

                                    <i class="bi bi-building fs-2 text-primary"></i>

                                    <h6 class="mt-2 mb-1">
                                        Purpose
                                    </h6>

                                    <span class="text-muted">
                                        {{ ucfirst($property->purpose) }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================= DESCRIPTION ================= --}}

                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-3">
                            Description
                        </h4>

                        <p class="text-muted lh-lg mb-0">
                            {{ $property->description }}
                        </p>

                    </div>

                </div>



                {{-- ================= ADDRESS ================= --}}

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-3">
                            Location & Address
                        </h4>

                        <p class="text-muted mb-2">

                            <i class="bi bi-geo-alt text-danger me-2"></i>

                            {{ $property->address ?? $property->location }}

                        </p>

                        @if ($property->city)
                            <p class="text-muted mb-0">

                                <i class="bi bi-building me-2"></i>

                                {{ $property->city }}

                            </p>
                        @endif


                    </div>

                </div>

            </div>




            {{-- ================= RIGHT SIDEBAR ================= --}}

            <div class="col-lg-4">

                <div class="card border-0 shadow rounded-4 sticky-top" style="top: 90px;">

                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-4">
                            Interested in this property?
                        </h4>

                        @auth

                            <a href="{{ route('buyer.inquiries.create', $property->id) }}"
                                class="btn btn-primary w-100 py-3 mb-3">

                                <i class="bi bi-chat-dots me-2"></i>

                                Send Inquiry

                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 py-3 mb-3">

                                Login to Contact

                            </a>

                        @endauth


                        <a href="https://wa.me/{{ $property->user->phone }}" target="_blank"
                            class="btn btn-success w-100 py-3">

                            <i class="bi bi-whatsapp me-2"></i>
                            Contact Seller on WhatsApp

                        </a>


                        <hr class="my-4">


                        <div class="d-flex align-items-center">

                            <div class="bg-primary text-white rounded-circle
                                    d-flex align-items-center justify-content-center"
                                style="width:50px;height:50px;">

                                <i class="bi bi-person fs-4"></i>

                            </div>

                            <div class="ms-3">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <h6 class="mb-0 fw-bold text-dark">
                                        {{-- <i class="bi bi-person-badge-fill text-primary me-1"></i> --}}
                                        {{ $property->user->name }}
                                    </h6>

                                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1"
                                        style="font-size: 11px;">
                                        <i class="bi bi-patch-check-fill me-1"></i>
                                        Verified
                                    </span>
                                </div>

                                <div class="d-flex align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-house-door me-1"></i>
                                        Property Owner
                                    </small>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ================= IMAGE SCRIPT ================= --}}

    <script>
        function changeMainImage(imageUrl) {
            document.getElementById('mainPropertyImage').src = imageUrl;
        }
    </script>

@endsection

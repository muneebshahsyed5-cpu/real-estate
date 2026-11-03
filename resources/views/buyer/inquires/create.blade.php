@extends('buyer.dashboard')

@section('title', 'Send Inquiry')

@section('content')

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-lg-8 col-xl-7">

                <div class="card border-0 shadow-sm rounded-4">

                    {{-- Header --}}
                    <div class="card-header bg-white border-0 p-4">
                        <h4 class="fw-bold mb-1">
                            <i class="bi bi-chat-dots text-primary me-2"></i>
                            Send Buyer Inquiry
                        </h4>

                        <p class="text-muted mb-0">
                            Send an inquiry about this property.
                        </p>
                    </div>


                    <div class="card-body p-4">

                        {{-- Property Information --}}
                        <div class="bg-light rounded-4 p-4 mb-4">

                            <div class="row align-items-center">

                                {{-- Property Image --}}
                                <div class="col-md-4 mb-3 mb-md-0">

                                    @if ($property->images->count() > 0)
                                        <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                                            class="img-fluid rounded-3"
                                            style="height: 160px; width: 100%; object-fit: cover;"
                                            alt="{{ $property->title }}">
                                    @else
                                        <div class="bg-secondary-subtle rounded-3 d-flex align-items-center justify-content-center"
                                            style="height: 160px;">

                                            <i class="bi bi-house-door fs-1 text-secondary"></i>

                                        </div>
                                    @endif

                                </div>


                                {{-- Property Details --}}
                                <div class="col-md-8">

                                    <span class="badge bg-primary mb-2">
                                        {{ ucfirst($property->property_type) }}
                                    </span>

                                    <h5 class="fw-bold mb-2">
                                        {{ $property->title }}
                                    </h5>

                                    <p class="text-muted mb-2">

                                        <i class="bi bi-geo-alt me-1"></i>

                                        {{ $property->location }},

                                        {{ $property->city }}

                                    </p>

                                    <h5 class="text-primary fw-bold mb-0">

                                        Rs. {{ number_format($property->price) }}

                                    </h5>

                                </div>

                            </div>

                        </div>


                        {{-- Inquiry Form --}}
                        <form action="{{ route('buyer.inquiries.store', $property->id) }}" method="POST">
                            @csrf

                            <input type="hidden" name="property_id" value="{{ $property->id }}">

                            <input type="hidden" name="property_source" value="properties">

                            <div class="mb-3">
                                <label class="form-label">Your Message</label>

                                <textarea name="message" class="form-control" rows="4" placeholder="I am interested in this property..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Send Inquiry
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

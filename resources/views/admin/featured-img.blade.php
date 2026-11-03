@extends('admin.dashboard')

@section('content')

<div class="container-fluid">

    <h3 class="fw-bold mb-4">Featured Properties</h3>

    <div class="row g-4">

        @forelse ($properties as $property)

            <div class="col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm h-100">

                    {{-- Property Image --}}
                    @if ($property->images->count() > 0)

                        <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                             class="card-img-top"
                             style="height: 220px; object-fit: cover;"
                             alt="{{ $property->title }}">

                    @else

                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 220px;">
                            <i class="bi bi-house fs-1 text-muted"></i>
                        </div>

                    @endif

                    <div class="card-body">

                        <h5 class="fw-bold">
                            {{ $property->title }}
                        </h5>

                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt"></i>
                            {{ $property->city ?? 'N/A' }}
                        </p>

                        <h6 class="text-primary fw-bold">
                            Rs. {{ number_format($property->price) }}
                        </h6>

                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-star-fill"></i>
                            Featured
                        </span>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-info">
                    No featured properties found.
                </div>
            </div>

        @endforelse

    </div>

</div>

@endsection

@extends('admin.dashboard')

@section('title', 'Properties Management')
@section('page-title', 'Properties Management')

@section('content')

    <div class="container-fluid p-0">

        {{-- Header Section --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">All Properties</h3>
                <p class="text-muted mb-0">Manage, update and organize your real estate listings.</p>
            </div>

            <a href="{{ route('properties.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm">
                <i class="bi bi-plus-lg"></i>
                <span>Add Property</span>
            </a>
        </div>

        {{-- Success Notification --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Properties Table Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
                <span class="fw-bold text-dark">Property Listings <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ count($properties) }}</span></span>
                <span class="text-muted small">Showing all active and listed properties</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 50px;">#</th>
                                <th>Property Details</th>
                                <th>Type</th>
                                <th>Purpose</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($properties as $property)
                                <tr>
                                    {{-- ID --}}
                                    <td class="ps-3 text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Property Image + Title --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($property->images && $property->images->count() > 0)
                                                <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                                                    alt="{{ $property->title }}" width="60" height="50"
                                                    class="rounded-3 shadow-xs" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border"
                                                    style="width: 60px; height: 50px;">
                                                    <i class="bi bi-house fs-5"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <strong class="text-dark d-block text-truncate" style="max-width: 200px;">
                                                    {{ $property->title }}
                                                </strong>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i> {{ $property->city ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Type --}}
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $property->property_type }}
                                        </span>
                                    </td>

                                    {{-- Purpose --}}
                                    <td>
                                        @if ($property->purpose == 'Sale')
                                            <span class="badge badge-soft-success rounded-pill px-2 py-1">
                                                For Sale
                                            </span>
                                        @else
                                            <span class="badge badge-soft-warning rounded-pill px-2 py-1">
                                                For Rent
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Location --}}
                                    <td>
                                        <span class="text-secondary small">{{ $property->location ?? '-' }}</span>
                                    </td>

                                    {{-- Price --}}
                                    <td>
                                        <strong class="text-dark">
                                            Rs. {{ number_format($property->price) }}
                                        </strong>
                                    </td>

                                    {{-- Area --}}
                                    <td>
                                        <span class="text-secondary small">
                                            {{ $property->area }} {{ $property->area_unit }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($property->status == 'active')
                                            <span class="badge badge-soft-success rounded-pill px-2 py-1">
                                                Active
                                            </span>
                                        @elseif($property->status == 'pending')
                                            <span class="badge badge-soft-warning rounded-pill px-2 py-1">
                                                Pending
                                            </span>
                                        @elseif($property->status == 'sold')
                                            <span class="badge badge-soft-danger rounded-pill px-2 py-1">
                                                Sold
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-2 py-1">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Featured --}}
                                    <td>
                                        @if ($property->featured)
                                            <span class="badge bg-warning bg-opacity-20 text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1">
                                                <i class="bi bi-star-fill text-warning me-1"></i> Featured
                                            </span>
                                        @else
                                            <span class="text-muted small">No</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-light border text-primary rounded-2" title="Edit Property">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this property listing?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger rounded-2" title="Delete Property">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-house-door fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No Properties Found</h5>
                                        <p class="text-muted small mb-3">You have not added any properties to your listings yet.</p>
                                        <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm rounded-3 px-3 py-2">
                                            <i class="bi bi-plus-lg"></i> Add Your First Property
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection

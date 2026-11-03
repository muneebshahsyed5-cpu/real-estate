
@extends('user.dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            <i class="bi bi-chat-dots text-primary me-2"></i>
            My Inquiries
        </h2>
        <p class="text-muted mb-0">
            View and manage your property inquiries.
        </p>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary">
        <i class="bi bi-buildings me-1"></i>
        Browse Properties
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm"
         role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}

        <button type="button" class="btn-close"
                data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">Your Inquiries</h5>

            <span class="badge bg-primary">
                {{ $inquiries->count() }} Total
            </span>
        </div>
    </div>

    <div class="card-body p-0">

        @if ($inquiries->count() > 0)

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-3">#</th>
                            <th>Property</th>
                            <th>Your Message</th>
                            <th>Property Reply</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($inquiries as $inquiry)

                            @php
                                $property = $inquiry->property;
                            @endphp

                            <tr>
                                {{-- Inquiry Number --}}
                                <td class="px-3 fw-bold">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Property Details --}}
                                <td style="min-width: 220px;">
                                    @if ($property)

                                        <div class="d-flex align-items-center">

                                            @if ($property->images && $property->images->count() > 0)
                                                <img
                                                    src="{{ asset('storage/' . $property->images->first()->image) }}"
                                                    alt="{{ $property->title }}"
                                                    class="rounded"
                                                    style="width: 70px; height: 55px; object-fit: cover;"
                                                >
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                     style="width: 70px; height: 55px;">
                                                    <i class="bi bi-house fs-4 text-muted"></i>
                                                </div>
                                            @endif

                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1">
                                                    {{ $property->title ?? 'Untitled Property' }}
                                                </h6>

                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $property->city ?? $property->location ?? 'Location not available' }}
                                                </small>
                                            </div>

                                        </div>

                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            Property no longer available
                                        </span>
                                    @endif
                                </td>

                                {{-- Buyer Message --}}
                                <td style="min-width: 220px;">
                                    <span class="text-muted">
                                        {{ $inquiry->message }}
                                    </span>
                                </td>

                                {{-- Property Owner and Reply --}}
                                <td style="min-width: 220px;">

                                    @if ($property && $property->owner_type === 'admin')

                                        <span class="badge bg-primary mb-2">
                                            <i class="bi bi-shield-check me-1"></i>
                                            Admin
                                        </span>

                                    @elseif ($property && $property->owner_type === 'owner')

                                        <span class="badge bg-success mb-2">
                                            <i class="bi bi-house me-1"></i>
                                            Owner
                                        </span>

                                    @elseif ($property && $property->owner_type === 'agent')

                                        <span class="badge bg-info text-dark mb-2">
                                            <i class="bi bi-person-badge me-1"></i>
                                            Agent
                                        </span>

                                    @else

                                        <span class="badge bg-secondary mb-2">
                                            Property owner unknown
                                        </span>

                                    @endif

                                    @if ($inquiry->reply)
                                        <div class="alert alert-success py-2 px-3 mb-0">
                                            <i class="bi bi-reply me-1"></i>
                                            {{ $inquiry->reply }}
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            No reply yet
                                        </span>
                                    @endif

                                </td>

                                {{-- Inquiry Status --}}
                                <td>
                                    @if ($inquiry->status === 'pending')

                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock me-1"></i>
                                            Pending
                                        </span>

                                    @elseif ($inquiry->status === 'approved')

                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Approved
                                        </span>

                                    @elseif ($inquiry->status === 'rejected')

                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Rejected
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            {{ ucfirst($inquiry->status ?? 'pending') }}
                                        </span>

                                    @endif
                                </td>

                                {{-- Inquiry Date --}}
                                <td class="text-muted">
                                    {{ $inquiry->created_at?->format('d M Y') }}
                                    <br>
                                    <small>
                                        {{ $inquiry->created_at?->format('h:i A') }}
                                    </small>
                                </td>

                            </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>

        @else

            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-chat-square-text text-muted"
                       style="font-size: 60px;"></i>
                </div>

                <h5 class="fw-bold">No Inquiries Yet</h5>

                <p class="text-muted mb-4">
                    You haven't sent any property inquiries yet.
                </p>

                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>
                    Browse Properties
                </a>
            </div>

        @endif

    </div>
</div>

@endsection

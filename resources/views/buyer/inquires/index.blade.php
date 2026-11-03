@extends('buyer.dashboard')

@section('content')

<style>
    .inquiry-header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border-radius: 20px;
        color: white;
    }

    .inquiry-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
    }

    .inquiry-table thead th {
        background: #f8f9fa;
        color: #6c757d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 1px solid #e9ecef;
        padding: 16px;
        white-space: nowrap;
    }

    .inquiry-table tbody td {
        padding: 20px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }

    .inquiry-table tbody tr {
        transition: .2s ease;
    }

    .inquiry-table tbody tr:hover {
        background: #f8fbff;
    }

    .property-title {
        font-weight: 700;
        color: #212529;
    }

    .property-location {
        font-size: 13px;
        color: #6c757d;
    }

    .property-price {
        font-size: 14px;
    }

    .message-box,
    .reply-box {
        max-width: 320px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.6;
    }

    .message-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #495057;
    }

    .reply-box {
        background: #eaf3ff;
        border: 1px solid #cfe2ff;
        color: #084298;
        margin-top: 8px;
    }

    .message-label,
    .reply-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 5px;
    }

    .message-label {
        color: #6c757d;
    }

    .reply-label {
        color: #0d6efd;
    }

    .waiting-reply {
        color: #adb5bd;
        font-size: 13px;
        font-style: italic;
        margin-top: 8px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .status-contacted {
        background: #cfe2ff;
        color: #084298;
    }

    .status-closed {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-approved {
        background: #d1e7dd;
        color: #0f5132;
    }

    .status-rejected {
        background: #f8d7da;
        color: #842029;
    }

    .date-box {
        min-width: 110px;
    }

    .empty-state {
        padding: 70px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: #e9f2ff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 30px;
    }

    .inquiry-count {
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.25);
        padding: 8px 14px;
        border-radius: 30px;
        font-size: 13px;
    }
</style>


{{-- Success Alert --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"
         role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>

        <strong>Success!</strong>
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>
    </div>
@endif


{{-- Page Header --}}
<div class="inquiry-header p-4 p-lg-5 mb-4 shadow-sm">

    <div class="d-flex flex-column flex-md-row
                justify-content-between align-items-md-center gap-3">

        <div>
            <div class="small opacity-75 mb-2">
                <i class="bi bi-person-circle me-1"></i>
                BUYER PORTAL
            </div>

            <h2 class="fw-bold mb-2">
                My Inquiries
            </h2>

            <p class="mb-0 opacity-75">
                Track your property inquiries and admin replies.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">

            <span class="inquiry-count">
                <i class="bi bi-chat-dots me-1"></i>
                {{ $inquiries->count() }} Inquiries
            </span>

            <a href="{{ route('buyer.properties') }}"
               class="btn btn-light px-4">

                <i class="bi bi-search me-1"></i>
                Browse Properties

            </a>

        </div>

    </div>

</div>


{{-- Inquiry Card --}}
<div class="card inquiry-card shadow-sm">

    <div class="card-body p-0">

        @if($inquiries->count() > 0)

            <div class="table-responsive">

                <table class="table inquiry-table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Property</th>
                            <th>Your Message</th>
                            <th>Admin Reply</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>


                    <tbody>

                        @foreach($inquiries as $inquiry)

                            <tr>

                                {{-- Number --}}
                                <td>
                                    <span class="text-muted fw-bold">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>


                                {{-- Property --}}
                                <td>

                                    @if($inquiry->property)

                                        <div class="property-title">
                                            {{ $inquiry->property->title }}
                                        </div>

                                        <div class="property-location mt-1">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $inquiry->property->location }}
                                        </div>

                                        @if($inquiry->property->price)

                                            <div class="property-price text-primary fw-bold mt-1">

                                                Rs.
                                                {{ number_format($inquiry->property->price) }}

                                            </div>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            Property not available
                                        </span>

                                    @endif

                                </td>


                                {{-- Your Message --}}
                                <td>

                                    <div class="message-box">

                                        <div class="message-label">
                                            <i class="bi bi-chat-left-text me-1"></i>
                                            Your Message
                                        </div>

                                        {{ $inquiry->message }}

                                    </div>

                                </td>


                                {{-- Admin Reply --}}
                                <td>

                                    @if($inquiry->reply)

                                        <div class="reply-box">

                                            <div class="reply-label">
                                                <i class="bi bi-reply-fill me-1"></i>
                                                Admin Reply
                                            </div>

                                            {{ $inquiry->reply }}

                                        </div>

                                    @else

                                        <div class="waiting-reply">

                                            <i class="bi bi-hourglass-split me-1"></i>
                                            Waiting for admin reply...

                                        </div>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if($inquiry->status === 'pending')

                                        <span class="status-badge status-pending">

                                            <i class="bi bi-clock me-1"></i>
                                            Pending

                                        </span>

                                    @elseif($inquiry->status === 'contacted')

                                        <span class="status-badge status-contacted">

                                            <i class="bi bi-telephone me-1"></i>
                                            Contacted

                                        </span>

                                    @elseif($inquiry->status === 'closed')

                                        <span class="status-badge status-closed">

                                            <i class="bi bi-check-circle me-1"></i>
                                            Closed

                                        </span>

                                    @elseif($inquiry->status === 'approved')

                                        <span class="status-badge status-approved">

                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Approved

                                        </span>

                                    @elseif($inquiry->status === 'rejected')

                                        <span class="status-badge status-rejected">

                                            <i class="bi bi-x-circle-fill me-1"></i>
                                            Rejected

                                        </span>

                                    @else

                                        <span class="badge bg-secondary rounded-pill">

                                            {{ ucfirst($inquiry->status) }}

                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td>

                                    <div class="date-box">

                                        <div class="fw-semibold">
                                            {{ $inquiry->created_at->format('d M, Y') }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $inquiry->created_at->format('h:i A') }}
                                        </small>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- Empty State --}}
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-chat-square-text"></i>
                </div>

                <h5 class="fw-bold">
                    No Inquiries Yet
                </h5>

                <p class="text-muted mb-4">
                    You haven't sent any property inquiries yet.
                </p>

                <a href="{{ route('buyer.properties') }}"
                   class="btn btn-primary px-4">

                    <i class="bi bi-building me-1"></i>
                    Explore Properties

                </a>

            </div>

        @endif

    </div>

</div>

@endsection

@extends('admin.dashboard')

@section('content')

{{-- Success Message --}}
@if (session('success'))
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


<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-chat-left-dots-fill text-primary me-2"></i>
                Buyer Inquiries
            </h3>

            <p class="text-muted mb-0">
                Manage buyer messages, replies and inquiry status.
            </p>
        </div>

        <span class="badge bg-primary rounded-pill px-3 py-2">
            {{ $inquiries->count() }} Inquiries
        </span>

    </div>


    {{-- Inquiries --}}
    @forelse ($inquiries as $inquiry)

        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

            <div class="card-body p-4">

                <div class="row g-4">

                    {{-- Property Image --}}
                    <div class="col-lg-2 col-md-3">

                        @if ($inquiry->property && $inquiry->property->images->first())

                            <img src="{{ asset('storage/' . $inquiry->property->images->first()->image) }}"
                                 class="rounded-3 shadow-sm w-100"
                                 style="height:140px; object-fit:cover;"
                                 alt="Property">

                        @else

                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                                 style="height:140px;">

                                <i class="bi bi-house-door text-secondary"
                                   style="font-size:45px;">
                                </i>

                            </div>

                        @endif

                        <div class="text-center mt-2">

                            <span class="badge bg-light text-primary border px-3 py-2">
                                <i class="bi bi-house me-1"></i>
                                Property #{{ $inquiry->property_id }}
                            </span>

                        </div>

                    </div>


                    {{-- Inquiry Information --}}
                    <div class="col-lg-10 col-md-9">

                        {{-- Top Section --}}
                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="fw-bold mb-1">
                                    {{ $inquiry->name }}
                                </h5>

                                <div class="text-muted small">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ $inquiry->email }}
                                </div>

                            </div>


                            {{-- Status --}}
                            <div>

                                <form action="{{ route('admin.inquiries.status', $inquiry->id) }}"
                                      method="POST">

                                    @csrf

                                    <select name="status"
                                            class="form-select form-select-sm fw-semibold"
                                            onchange="this.form.submit()"
                                            style="min-width:130px;">

                                        <option value="pending"
                                            {{ $inquiry->status == 'pending' ? 'selected' : '' }}>
                                            🟡 Pending
                                        </option>

                                        <option value="approved"
                                            {{ $inquiry->status == 'approved' ? 'selected' : '' }}>
                                            🟢 Approved
                                        </option>

                                        <option value="rejected"
                                            {{ $inquiry->status == 'rejected' ? 'selected' : '' }}>
                                            🔴 Rejected
                                        </option>

                                    </select>

                                </form>

                            </div>

                        </div>


                        {{-- Buyer Message --}}
                        <div class="bg-light rounded-3 p-3 mt-3">

                            <div class="fw-semibold text-dark mb-2">
                                <i class="bi bi-chat-left-text-fill text-primary me-2"></i>
                                Buyer Message
                            </div>

                            <p class="text-muted mb-0">
                                {{ $inquiry->message }}
                            </p>

                        </div>


                        {{-- Existing Reply --}}
                        @if($inquiry->reply)

                            <div class="bg-primary bg-opacity-10 rounded-3 p-3 mt-3">

                                <div class="fw-semibold text-primary mb-2">
                                    <i class="bi bi-reply-fill me-2"></i>
                                    Admin Reply
                                </div>

                                <p class="text-muted mb-0">
                                    {{ $inquiry->reply }}
                                </p>

                            </div>

                        @endif


                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">

                            {{-- Reply --}}
                            <button type="button"
                                    class="btn btn-primary rounded-3 px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#replyModal{{ $inquiry->id }}">

                                <i class="bi bi-reply-fill me-1"></i>
                                {{ $inquiry->reply ? 'Edit Reply' : 'Reply' }}

                            </button>


                            {{-- Delete --}}
                            <form action="{{ route('admin.inquiries.delete', $inquiry->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this inquiry?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-outline-danger rounded-3 px-3">

                                    <i class="bi bi-trash3 me-1"></i>
                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Reply Modal --}}
        <div class="modal fade"
             id="replyModal{{ $inquiry->id }}"
             tabindex="-1"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow-lg rounded-4">

                    <div class="modal-header border-0 p-4">

                        <div>

                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-reply-fill text-primary me-2"></i>
                                Reply to Buyer
                            </h5>

                            <small class="text-muted">
                                {{ $inquiry->name }} · {{ $inquiry->email }}
                            </small>

                        </div>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                        </button>

                    </div>


                    <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}"
                          method="POST">

                        @csrf

                        <div class="modal-body px-4">

                            <label class="form-label fw-semibold">
                                Your Reply
                            </label>

                            <textarea name="reply"
                                      class="form-control rounded-3"
                                      rows="5"
                                      placeholder="Write your reply to the buyer..."
                                      required>{{ $inquiry->reply }}</textarea>

                        </div>


                        <div class="modal-footer border-0 px-4 pb-4">

                            <button type="button"
                                    class="btn btn-light rounded-3"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit"
                                    class="btn btn-primary rounded-3 px-4">

                                <i class="bi bi-send-fill me-1"></i>
                                Send Reply

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @empty

        {{-- Empty State --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center py-5">

                <i class="bi bi-chat-square-text text-muted"
                   style="font-size:60px;">
                </i>

                <h4 class="fw-bold mt-3">
                    No Inquiries Found
                </h4>

                <p class="text-muted mb-0">
                    There are currently no buyer inquiries.
                </p>

            </div>

        </div>

    @endforelse

</div>


@endsection

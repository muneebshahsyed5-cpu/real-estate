@extends('admin.dashboard')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            <strong>Success!</strong>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>

        </div>
    @endif

    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    All Buyers
                </h3>

                <p class="text-muted mb-0">
                    Manage all registered property buyers.
                </p>
            </div>

            <span class="badge bg-primary rounded-pill px-3 py-2">
                <i class="bi bi-people-fill me-1"></i>
                {{ $buyers->count() }} Buyers
            </span>

        </div>


        {{-- Buyers Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            {{-- Card Header --}}
            <div class="card-header bg-transparent border-bottom py-3 px-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Buyer Management
                        </h5>

                        <small class="text-muted">
                            View and manage registered buyers
                        </small>
                    </div>

                    <span class="text-muted small">
                        Total: {{ $buyers->count() }}
                    </span>

                </div>

            </div>


            {{-- Table --}}
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        {{-- Table Head --}}
                        <thead>

                            <tr>

                                <th class="ps-4 text-muted small">
                                    #
                                </th>

                                <th class="text-muted small">
                                    BUYER
                                </th>

                                <th class="text-muted small">
                                    EMAIL
                                </th>

                                <th class="text-muted small">
                                    PHONE
                                </th>

                                <th class="text-muted small">
                                    ADDRESS
                                </th>

                                <th class="text-muted small">
                                    ROLE
                                </th>

                                <th class="text-muted small">
                                    STATUS
                                </th>

                                <th class="text-end pe-4 text-muted small">
                                    ACTIONS
                                </th>

                            </tr>

                        </thead>


                        {{-- Table Body --}}
                        <tbody>

                            @forelse($buyers as $buyer)
                                <tr>

                                    {{-- Number --}}
                                    <td class="ps-4 text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- Buyer --}}
                                    <td>

                                        <div class="d-flex align-items-center gap-3">

                                            {{-- Avatar --}}

                                            <div class="rounded-circle overflow-hidden bg-primary d-flex align-items-center justify-content-center"
                                                style="width:60px;height:60px;">

                                                @if ($buyer->image)
                                                    <img src="{{ asset($buyer->image) }}" alt="{{ $buyer->name }}"
                                                        width="70" height="70" class="rounded-circle"
                                                        style="object-fit: cover;">
                                                @else
                                                    <span class="text-white fw-bold fs-5">
                                                        {{ strtoupper(substr($buyer->name, 0, 1)) }}
                                                    </span>
                                                @endif

                                            </div>


                                            <div>

                                                <div class="fw-semibold">
                                                    {{ $buyer->name }}
                                                </div>

                                                <small class="text-muted">
                                                    Buyer #{{ $buyer->id }}
                                                </small>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Email --}}
                                    <td>

                                        <span class="text-muted">

                                            <i class="bi bi-envelope me-1"></i>

                                            {{ $buyer->email }}

                                        </span>

                                    </td>


                                    {{-- Phone --}}
                                    <td>

                                        @if ($buyer->phone)
                                            <span class="text-muted">

                                                <i class="bi bi-telephone me-1"></i>

                                                {{ $buyer->phone }}

                                            </span>
                                        @else
                                            <span class="text-muted">
                                                —
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Address --}}
                                    <td>

                                        @if ($buyer->address)
                                            <span class="text-muted">

                                                <i class="bi bi-geo-alt me-1"></i>

                                                {{ $buyer->address }}

                                            </span>
                                        @else
                                            <span class="text-muted">
                                                —
                                            </span>
                                        @endif

                                    </td>


                                    {{-- Role --}}
                                    <td>

                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">

                                            <i class="bi bi-person-fill me-1"></i>

                                            Buyer

                                        </span>

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">

                                            <i class="bi bi-check-circle-fill me-1"></i>

                                            Active

                                        </span>

                                    </td>


                                    {{-- Actions --}}
                                    <td class="text-end pe-4">

                                        <div class="d-flex justify-content-end gap-1">

                                            {{-- View --}}
                                            <a href="{{ route('admin.clients.show', $buyer->id) }}"
                                                class="btn btn-sm btn-light" title="View Buyer">

                                                <i class="bi bi-eye text-primary"></i>

                                            </a>


                                            {{-- Edit --}}
                                            <a href="{{ route('admin.clients.edit', $buyer->id) }}"
                                                class="btn btn-sm btn-light" title="Edit Buyer">

                                                <i class="bi bi-pencil text-warning"></i>

                                            </a>


                                            {{-- Delete --}}

                                            <form action="{{ route('admin.client.delete', $buyer->id) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-light" title="Delete Buyer">

                                                    <i class="bi bi-trash text-danger"></i>

                                                </button>

                                            </form>


                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        <i class="bi bi-people fs-1 text-muted"></i>

                                        <h5 class="fw-bold mt-3">
                                            No Buyers Found
                                        </h5>

                                        <p class="text-muted mb-0">
                                            No buyers have been registered yet.
                                        </p>

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

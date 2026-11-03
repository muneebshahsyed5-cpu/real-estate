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
    <div class="container-fluid px-0">

        {{-- =========================
        PAGE HEADER
    ========================== --}}
        <div class="d-flex flex-column flex-md-row justify-content-between
                align-items-md-center gap-3 mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    All Agents
                </h3>

                <p class="text-muted mb-0">
                    Manage all registered real estate agents.
                </p>
            </div>

            <div>
                <span class="badge bg-primary bg-opacity-10 text-primary
                         rounded-pill px-3 py-2">

                    <i class="bi bi-people-fill me-1"></i>

                    {{ $agents->count() }} Agents

                </span>
            </div>

        </div>


        {{-- =========================
        AGENTS TABLE
    ========================== --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            {{-- Table Header --}}
            <div class="card-header bg-transparent border-bottom
                    py-3 px-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="fw-bold mb-1">
                            Agent Management
                        </h5>

                        <small class="text-muted">
                            View and manage registered agents
                        </small>
                    </div>

                    <span class="text-muted small">
                        Total: {{ $agents->count() }}
                    </span>

                </div>

            </div>


            {{-- Table --}}
            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        {{-- =========================
                        TABLE HEAD
                    ========================== --}}
                        <thead>

                            <tr>

                                <th class="ps-4 text-muted small">
                                    #
                                </th>

                                <th class="text-muted small">
                                    IMAGE
                                </th>

                                <th class="text-muted small">
                                    AGENT
                                </th>

                                <th class="text-muted small">
                                    EMAIL
                                </th>

                                <th class="text-muted small">
                                    PHONE
                                </th>

                                <th class="text-muted small">
                                    PROPERTIES
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


                        {{-- =========================
                        TABLE BODY
                    ========================== --}}
                        <tbody>

                            @forelse($agents as $agent)
                                <tr>

                                    {{-- Number --}}
                                    <td class="ps-4 text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- =========================
                                    AGENT IMAGE
                                ========================== --}}
                                    <td>
                                        <img src="{{ asset($agent->image) }}" alt="{{ $agent->name }}" width="100"
                                            height="100" class="rounded-circle" style="object-fit: cover;">
                                    </td>

                                    {{-- Agent Name --}}
                                    <td>
                                        <div class="fw-semibold">
                                            {{ $agent->name }}
                                        </div>

                                        <small class="text-muted">
                                            Agent #{{ $agent->id }}
                                        </small>
                                    </td>


                {{-- Email --}}
                <td>

                    <span class="text-muted">

                        <i class="bi bi-envelope me-1"></i>

                        {{ $agent->email }}

                    </span>

                </td>


                {{-- Phone --}}
                <td>

                    @if ($agent->phone)
                        <span class="text-muted">

                            <i class="bi bi-telephone me-1"></i>

                            {{ $agent->phone }}

                        </span>
                    @else
                        <span class="text-muted">
                            —
                        </span>
                    @endif

                </td>


                {{-- =========================
                                    PROPERTIES COUNT
                                ========================== --}}
                <td>

                    <span
                        class="badge bg-info bg-opacity-10
                                                 text-info rounded-pill px-3 py-2">

                        <i class="bi bi-building me-1"></i>

                        {{ $agent->properties_count ?? 0 }}

                    </span>

                </td>


                {{-- =========================
                                    ROLE
                                ========================== --}}
                <td>

                    <span
                        class="badge bg-primary bg-opacity-10
                                                 text-primary rounded-pill px-3 py-2">

                        <i class="bi bi-person-badge me-1"></i>

                        Agent

                    </span>

                </td>


                {{-- =========================
                                    STATUS
                                ========================== --}}
                <td>

                    @if ($agent->status ?? true)
                        <span
                            class="badge bg-success bg-opacity-10
                                                     text-success rounded-pill px-3 py-2">

                            <i class="bi bi-check-circle-fill me-1"></i>

                            Active

                        </span>
                    @else
                        <span
                            class="badge bg-danger bg-opacity-10
                                                     text-danger rounded-pill px-3 py-2">

                            <i class="bi bi-x-circle-fill me-1"></i>

                            Inactive

                        </span>
                    @endif

                </td>


                {{-- =========================
                                    ACTIONS
                                ========================== --}}
                <td class="text-end pe-4">

                    <div class="d-flex justify-content-end gap-1">

                        {{-- View --}}
                        <a href="{{ route('admin.agents.show', $agent->id) }}" class="btn btn-sm btn-light"
                            title="View Agent">

                            <i class="bi bi-eye text-primary"></i>

                        </a>


                        {{-- Edit --}}
                        <a href="{{ route('admin.agents.edit', $agent->id) }}" class="btn btn-sm btn-light"
                            title="Edit Agent">

                            <i class="bi bi-pencil text-warning"></i>

                        </a>


                        {{-- Delete --}}
                        <form action="{{ route('admin.agents.delete', $agent->id) }}" method="POST" class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-light" title="Delete Agent"
                                onclick="return confirm('Are you sure you want to delete this agent?')">

                                <i class="bi bi-trash text-danger"></i>

                            </button>

                        </form>

                    </div>

                </td>

                </tr>

            @empty

                {{-- =========================
                                NO AGENTS
                            ========================== --}}
                <tr>

                    <td colspan="9" class="text-center py-5">

                        <i class="bi bi-people fs-1 text-muted"></i>

                        <h5 class="fw-bold mt-3">
                            No Agents Found
                        </h5>

                        <p class="text-muted mb-0">
                            No agents have been registered yet.
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

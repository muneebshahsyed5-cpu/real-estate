@php
    use App\Models\BuyerInquiry;
    use App\Models\AgentProperty;
    use App\Models\Property;

    $agentUserId = auth()->id();

    $inquiryCount = $inquiryCount ?? BuyerInquiry::where(function ($q) use ($agentUserId) {
        $q->whereHas('property', function ($query) use ($agentUserId) {
            $query->where('user_id', $agentUserId)->where('owner_type', 'agent');
        })->orWhere(function ($sub) use ($agentUserId) {
            $sub->where('property_source', 'agentproperties')
                ->whereHas('agentProperty', function ($ap) use ($agentUserId) {
                    $ap->where('user_id', $agentUserId);
                });
        });
    })->count();
@endphp
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Agent Dashboard') - EstatePro</title>

    <!-- Inline script to set theme before DOM render (avoids flash) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('estatepro_agent_theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-body-font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --topbar-height: 70px;
            --primary-color: #2563eb;
            --primary-light: #eff6ff;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.08);
        }

        /* DARK THEME (DEFAULT) */
        [data-bs-theme="dark"] {
            --body-bg: #090d16;
            --card-bg: #111827;
            --card-border: #1e293b;
            --topbar-bg: #0f172a;
            --topbar-border: #1e293b;
            --sidebar-bg: #0a0f1d;
            --sidebar-border: #1e293b;
            --input-bg: #1e293b;
            --input-border: #334155;
            --input-color: #f8fafc;
            --text-main: #f1f5f9;
            --text-muted-color: #94a3b8;
            --table-hover-bg: #151f32;
        }

        /* LIGHT THEME */
        [data-bs-theme="light"] {
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --topbar-bg: #ffffff;
            --topbar-border: #e2e8f0;
            --sidebar-bg: #0f172a;
            --sidebar-border: rgba(255, 255, 255, 0.07);
            --input-bg: #f8fafc;
            --input-border: #e2e8f0;
            --input-color: #1e293b;
            --text-main: #334155;
            --text-muted-color: #64748b;
            --table-hover-bg: #f8fafc;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--body-bg);
            color: var(--text-main);
            overflow-x: hidden;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            transition: all 0.3s ease;
            z-index: 1045;
            border-right: 1px solid var(--sidebar-border);
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .sidebar-menu {
            padding: 1rem 0.85rem;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.075rem;
            text-transform: uppercase;
            color: #64748b;
            padding: 0.75rem 0.75rem 0.35rem 0.75rem;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: var(--sidebar-text);
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin-bottom: 0.2rem;
            text-decoration: none;
        }

        .sidebar .nav-link i {
            font-size: 1.15rem;
            width: 20px;
            text-align: center;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: #f1f5f9;
            background-color: var(--sidebar-hover);
        }

        .sidebar .nav-link:hover i {
            color: #60a5fa;
        }

        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: var(--sidebar-text-active);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .sidebar .nav-link.active i {
            color: #ffffff;
        }

        /* Top Navbar */
        .top-navbar {
            height: var(--topbar-height);
            background-color: var(--topbar-bg);
            border-bottom: 1px solid var(--topbar-border);
            position: sticky;
            top: 0;
            z-index: 1020;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .search-box {
            position: relative;
            max-width: 320px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: 0.5rem;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-color);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            background-color: var(--card-bg);
            border-color: #3b82f6;
            color: var(--input-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .search-box .search-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        /* Main Content */
        .main-wrapper {
            min-height: calc(100vh - var(--topbar-height));
            display: flex;
            flex-direction: column;
        }

        /* Cards & Stats */
        .stat-card {
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-hover-shadow);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 0.85rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--card-shadow);
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        .card-header {
            background-color: var(--card-bg) !important;
            border-bottom: 1px solid var(--card-border) !important;
        }

        /* Table Styling */
        .table> :not(caption)>*>* {
            padding: 0.85rem 1rem;
            border-bottom-color: var(--card-border);
            background-color: transparent;
        }

        .table tbody tr:hover {
            background-color: var(--table-hover-bg);
        }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            font-weight: 700;
            color: #94a3b8;
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--card-border);
        }

        /* Badges */
        .badge-soft-primary {
            background-color: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
        }

        .badge-soft-success {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .badge-soft-warning {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }

        .badge-soft-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: #f87171;
        }

        .badge-soft-info {
            background-color: rgba(6, 182, 212, 0.15);
            color: #22d3ee;
        }

        /* Notification & Toggle Buttons */
        .notification-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sidebar-text);
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .notification-btn:hover,
        .notification-btn:focus,
        .notification-btn.show {
            color: #ffffff !important;
            background: var(--sidebar-hover) !important;
        }

        .notification-btn:hover i,
        .notification-btn:focus i,
        .notification-btn.show i {
            color: #ffffff !important;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            font-size: 0.65rem;
            font-weight: 700;
            line-height: 14px;
            background-color: #ef4444;
            color: #ffffff;
            border-radius: 9999px;
            border: 2px solid var(--topbar-bg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 0.65rem;
            background: linear-gradient(135deg, #10b981, #2563eb);
            color: #ffffff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            background-color: var(--topbar-bg) !important;
            border-top: 1px solid var(--topbar-border) !important;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }

        /* =========================================================
           LIGHT MODE SYSTEM OVERRIDES
           (Without dark mode: make white text black/dark)
           ========================================================= */
        [data-bs-theme="light"] {
            --text-main: #0f172a;
            --text-muted-color: #64748b;
        }

        [data-bs-theme="light"] body {
            color: #0f172a !important;
        }

        /* Headings & Texts in Light Mode -> Black/Dark */
        [data-bs-theme="light"] h1,
        [data-bs-theme="light"] h2,
        [data-bs-theme="light"] h3,
        [data-bs-theme="light"] h4,
        [data-bs-theme="light"] h5,
        [data-bs-theme="light"] h6,
        [data-bs-theme="light"] .text-dark,
        [data-bs-theme="light"] .text-body,
        [data-bs-theme="light"] strong,
        [data-bs-theme="light"] b,
        [data-bs-theme="light"] label,
        [data-bs-theme="light"] .form-label,
        [data-bs-theme="light"] .modal-title,
        [data-bs-theme="light"] .card-title,
        [data-bs-theme="light"] .dropdown-item {
            color: #0f172a !important;
        }

        /* Prevent white text on light backgrounds in main content */
        [data-bs-theme="light"] .main-wrapper .card:not(.bg-primary):not(.bg-danger):not(.bg-success):not(.bg-dark) .text-white,
        [data-bs-theme="light"] .main-wrapper .btn-light .text-white,
        [data-bs-theme="light"] .main-wrapper .table .text-white {
            color: #0f172a !important;
        }

        /* Tables in Light Mode */
        [data-bs-theme="light"] .table {
            color: #0f172a !important;
        }

        [data-bs-theme="light"] .table th {
            color: #64748b !important;
            background-color: #f8fafc !important;
            border-bottom-color: #e2e8f0 !important;
        }

        [data-bs-theme="light"] .table td {
            color: #1e293b !important;
            border-bottom-color: #f1f5f9 !important;
        }

        /* Light Mode Buttons */
        [data-bs-theme="light"] .btn-light {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        [data-bs-theme="light"] .btn-light:hover {
            background-color: #e2e8f0 !important;
            border-color: #94a3b8 !important;
            color: #0f172a !important;
        }

        [data-bs-theme="light"] .bg-light {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #e2e8f0 !important;
        }

        /* Topbar notification buttons in Light Mode */
        [data-bs-theme="light"] .notification-btn {
            color: #334155 !important;
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
        }

        [data-bs-theme="light"] .notification-btn i {
            color: #334155 !important;
            transition: color 0.2s ease;
        }

        [data-bs-theme="light"] .notification-btn:hover,
        [data-bs-theme="light"] .notification-btn:focus,
        [data-bs-theme="light"] .notification-btn.show {
            color: #ffffff !important;
            background-color: #1e293b !important;
            border-color: #1e293b !important;
        }

        [data-bs-theme="light"] .notification-btn:hover i,
        [data-bs-theme="light"] .notification-btn:focus i,
        [data-bs-theme="light"] .notification-btn.show i {
            color: #ffffff !important;
        }

        /* =========================================================
           DARK MODE SYSTEM OVERRIDES
           (In dark mode: make black/dark text white/light)
           ========================================================= */
        [data-bs-theme="dark"] {
            --text-main: #f1f5f9;
            --text-muted-color: #94a3b8;
        }

        [data-bs-theme="dark"] body {
            color: #f1f5f9 !important;
        }

        /* Headings & Texts in Dark Mode -> White/Light */
        [data-bs-theme="dark"] h1,
        [data-bs-theme="dark"] h2,
        [data-bs-theme="dark"] h3,
        [data-bs-theme="dark"] h4,
        [data-bs-theme="dark"] h5,
        [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .text-black,
        [data-bs-theme="dark"] .text-body,
        [data-bs-theme="dark"] strong,
        [data-bs-theme="dark"] b,
        [data-bs-theme="dark"] label,
        [data-bs-theme="dark"] .form-label,
        [data-bs-theme="dark"] .modal-title,
        [data-bs-theme="dark"] .card-title {
            color: #f8fafc !important;
        }

        /* Dark Mode overrides for common bootstrap utility classes */
        [data-bs-theme="dark"] .bg-white {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
        }

        /* In dark mode, .btn-light becomes sleek dark button instead of white glare */
        [data-bs-theme="dark"] .btn-light {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .btn-light:hover {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] .btn-light i,
        [data-bs-theme="dark"] .btn-light span,
        [data-bs-theme="dark"] .btn-light div {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #1a2333 !important;
            color: #cbd5e1 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .border {
            border-color: var(--card-border) !important;
        }

        [data-bs-theme="dark"] .border-bottom {
            border-bottom-color: var(--card-border) !important;
        }

        [data-bs-theme="dark"] .border-top {
            border-top-color: var(--card-border) !important;
        }

        /* Modals in Dark Mode */
        [data-bs-theme="dark"] .modal-content {
            background-color: #111827 !important;
            border: 1px solid var(--card-border) !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer {
            border-color: var(--card-border) !important;
        }

        /* Dropdowns in Dark Mode */
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #111827 !important;
            border-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #cbd5e1 !important;
        }

        [data-bs-theme="dark"] .dropdown-item:hover,
        [data-bs-theme="dark"] .dropdown-item:focus {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        /* Form Inputs in Dark Mode */
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #111827 !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #0f172a !important;
            border-color: #3b82f6 !important;
            color: #f8fafc !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
        }

        /* Tables in Dark Mode */
        [data-bs-theme="dark"] .table {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] .table th {
            color: #94a3b8 !important;
            background-color: var(--card-bg) !important;
            border-bottom-color: var(--card-border) !important;
        }

        [data-bs-theme="dark"] .table td {
            color: #f1f5f9 !important;
            border-bottom-color: var(--card-border) !important;
        }

        /* Topbar notification buttons in Dark Mode */
        [data-bs-theme="dark"] .notification-btn {
            color: #94a3b8 !important;
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
        }

        [data-bs-theme="dark"] .notification-btn i {
            color: #94a3b8 !important;
            transition: color 0.2s ease;
        }

        [data-bs-theme="dark"] .notification-btn:hover,
        [data-bs-theme="dark"] .notification-btn:focus,
        [data-bs-theme="dark"] .notification-btn.show {
            color: #ffffff !important;
            background-color: #334155 !important;
            border-color: #475569 !important;
        }

        [data-bs-theme="dark"] .notification-btn:hover i,
        [data-bs-theme="dark"] .notification-btn:focus i,
        [data-bs-theme="dark"] .notification-btn.show i {
            color: #ffffff !important;
        }

        /* Button text contrast guarantees */
        .btn-primary,
        .btn-primary *,
        .btn-danger,
        .btn-danger * {
            color: #ffffff !important;
        }

        .btn-warning,
        .btn-warning * {
            color: #0f172a !important;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
            }
        }
    </style>
</head>

<body>

    <div class="d-flex min-vh-100">

        {{-- SIDEBAR COMPONENT --}}
        <aside class="sidebar offcanvas-lg offcanvas-start d-flex flex-column flex-shrink-0" tabindex="-1"
            id="agentSidebarMenu" aria-labelledby="agentSidebarMenuLabel">

            {{-- Brand Logo Header --}}
            <div class="sidebar-brand d-flex align-items-center justify-content-between">
                <a href="{{ route('agent.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center"
                        style="width: 36px; height: 36px;">
                        <i class="bi bi-buildings-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="fs-5 fw-bold text-black tracking-tight">Estate<span
                                class="text-primary">Pro</span></span>
                        <span
                            class="badge bg-success bg-opacity-25 border border-success-subtle text-success ms-1 py-0 px-1"
                            style="font-size: 0.65rem;">AGENT</span>
                    </div>
                </a>
                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                    data-bs-target="#agentSidebarMenu" aria-label="Close"></button>
            </div>

            {{-- Navigation Items --}}
            <div class="sidebar-menu flex-grow-1 overflow-y-auto">

                <div class="sidebar-heading">Management</div>
                <div class="nav flex-column">
                    <a href="{{ route('agent.dashboard') }}"
                        class="nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('agent.properties.index') }}"
                        class="nav-link {{ request()->routeIs('agent.properties.index') ? 'active' : '' }}">
                        <i class="bi bi-houses-fill"></i>
                        <span>My Properties</span>
                    </a>
                    <a href="{{ route('agent.properties.create') }}"
                        class="nav-link {{ request()->routeIs('agent.properties.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Add Property</span>
                    </a>
                    <a href="{{ route('agent.inquiries') }}"
                        class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('agent.inquiries') ? 'active' : '' }}">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-chat-left-dots-fill"></i>
                            <span>My Inquiries</span>
                        </div>
                        @if (($inquiryCount ?? 0) > 0)
                            <span class="badge bg-danger rounded-pill px-2 py-0.5" style="font-size: 0.7rem;">
                                {{ $inquiryCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <div class="sidebar-heading mt-3">Portal & Settings</div>
                <div class="nav flex-column">
                    <a href="{{ route('home') }}" target="_blank" class="nav-link">
                        <i class="bi bi-globe"></i>
                        <span>Live Website</span>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="bi bi-person-gear"></i>
                        <span>Profile Settings</span>
                    </a>
                </div>

            </div>

            {{-- Sidebar Footer / Sign Out --}}
            <div class="p-3 border-top border-dark border-opacity-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-grow-1 d-flex flex-column main-wrapper w-100" style="min-width: 0;">

            {{-- TOP NAVIGATION BAR --}}
            <header class="top-navbar d-flex align-items-center justify-content-between px-3 px-md-4">

                {{-- Left: Toggle & Title / Search --}}
                <div class="d-flex align-items-center gap-2 gap-md-3">
                    <button
                        class="btn btn-light d-lg-none d-flex align-items-center justify-content-center p-2 rounded-3 border"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#agentSidebarMenu"
                        aria-controls="agentSidebarMenu" aria-label="Toggle navigation">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <div class="d-none d-md-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 text-dark">@yield('page-title', 'Agent Dashboard')</h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2.5 py-1 small fw-semibold d-none d-xl-inline-flex align-items-center gap-1">
                            <i class="bi bi-patch-check-fill" style="font-size: 0.75rem;"></i> Portal
                        </span>
                    </div>

                    {{-- Search Input Box --}}
                    <div class="search-box d-none d-md-block ms-lg-3">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Search my listings, inquiries...">
                    </div>
                </div>

                {{-- Right: Actions & Inquiries & Theme Toggle & User Dropdown --}}
                <div class="d-flex align-items-center gap-2 gap-md-3">

                    {{-- Quick Front Link --}}
                    <a href="{{ route('home') }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm d-none d-sm-flex align-items-center gap-1.5 rounded-3 px-2.5 py-1.5"
                        title="View Public Website">
                        <i class="bi bi-globe2"></i>
                        <span class="fw-medium">Live Site</span>
                    </a>

                    {{-- Quick Action Button --}}
                    <a href="{{ route('agent.properties.create') }}"
                        class="btn btn-primary btn-sm d-none d-sm-flex align-items-center gap-1.5 rounded-3 px-3 py-1.5 shadow-sm fw-medium">
                        <i class="bi bi-plus-lg"></i>
                        <span>Add Property</span>
                    </a>

                    {{-- Inquiries Notification Dropdown --}}
                    <div class="dropdown">
                        <button class="notification-btn position-relative" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Client Inquiries">
                            <i class="bi bi-chat-left-dots"></i>
                            @if (($inquiryCount ?? 0) > 0)
                                <span class="notification-badge">
                                    {{ $inquiryCount > 99 ? '99+' : $inquiryCount }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border mt-2 rounded-3 p-0"
                            style="min-width: 290px;">
                            <li class="px-3 py-2.5 border-bottom d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-dark d-flex align-items-center gap-1.5">
                                    <i class="bi bi-chat-left-text text-primary"></i> Client Inquiries
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $inquiryCount ?? 0 }} total</span>
                            </li>
                            <li class="p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                        style="width: 44px; height: 44px;">
                                        <i class="bi bi-chat-dots-fill fs-5"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-1 text-dark">
                                    {{ $inquiryCount ?? 0 }} Inquir{{ ($inquiryCount ?? 0) === 1 ? 'y' : 'ies' }} Received
                                </h6>
                                <p class="text-muted small mb-3">Manage messages and leads from interested property buyers.</p>
                                <a href="{{ route('agent.inquiries') }}" class="btn btn-primary btn-sm w-100 rounded-2 fw-medium">
                                    <i class="bi bi-arrow-right-circle me-1"></i> View All Inquiries
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Dark / Light Theme Toggle Button --}}
                    <button class="notification-btn" id="themeToggleBtn" type="button" title="Toggle Theme">
                        <i class="bi bi-sun-fill" id="themeIcon"></i>
                    </button>

                    <div class="vr mx-1 opacity-25 d-none d-sm-block" style="height: 24px;"></div>

                    {{-- User Dropdown Profile --}}
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block text-start lh-sm">
                                <span
                                    class="fw-semibold d-block text-dark small">{{ auth()->user()->name ?? 'Agent' }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;">Licensed Agent</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border mt-2 rounded-3 py-1"
                            style="min-width: 220px;">
                            <li class="px-3 py-2.5 border-bottom">
                                <p class="mb-0 fw-semibold text-dark small">{{ auth()->user()->name ?? 'Agent' }}</p>
                                <small
                                    class="text-muted text-truncate d-block" style="font-size: 0.75rem;">{{ auth()->user()->email ?? 'agent@estatepro.com' }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 small"
                                    href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person text-muted"></i> Profile Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 small"
                                    href="{{ route('agent.properties.index') }}">
                                    <i class="bi bi-houses text-muted"></i> My Listings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 small"
                                    href="{{ route('agent.properties.create') }}">
                                    <i class="bi bi-plus-circle text-muted"></i> Add Property
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2 small"
                                    href="{{ route('agent.inquiries') }}">
                                    <i class="bi bi-chat-left-dots text-muted"></i> Client Inquiries
                                    @if (($inquiryCount ?? 0) > 0)
                                        <span class="badge bg-primary-subtle text-primary ms-auto" style="font-size: 0.7rem;">{{ $inquiryCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item py-2 text-danger d-flex align-items-center gap-2 small">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>

            </header>

            {{-- MAIN CONTENT AREA --}}
            <main class="p-3 p-md-4 flex-grow-1">

                @hasSection('content')
                    @yield('content')
                @else
                    {{-- DEFAULT AGENT DASHBOARD OVERVIEW --}}
                    <div class="container-fluid p-0">

                        {{-- Welcome Banner --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
                            style="background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(37,99,235,0.12)); border: 1px solid var(--card-border) !important;">
                            <div class="card-body p-4 p-md-5">
                                <div class="row align-items-center g-3">
                                    <div class="col-lg-8">
                                        <span
                                            class="badge bg-success bg-opacity-20 text-success px-3 py-1 rounded-pill mb-2 fw-semibold">
                                            <i class="bi bi-patch-check-fill me-1"></i> AGENT PORTAL
                                        </span>
                                        <h2 class="fw-bold text-dark mb-2">
                                            Welcome back, {{ auth()->user()->name ?? 'Agent' }}! 👋
                                        </h2>
                                        <p class="text-muted fs-6 mb-0">
                                            Manage your active listings and publish properties to the real estate
                                            portal.
                                        </p>
                                    </div>
                                    <div class="col-lg-4 text-lg-end">
                                        <a href="{{ route('agent.properties.create') }}"
                                            class="btn btn-primary d-inline-flex align-items-center gap-2 px-4 py-2 rounded-3 shadow-sm">
                                            <i class="bi bi-plus-lg"></i>
                                            <span>Add New Property</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alert Notifications --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4"
                                role="alert">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- 4 KEY METRIC CARDS --}}
                        <div class="row g-3 mb-4">

                            {{-- Card 1: Total Managed Properties --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Total
                                                Properties</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">
                                                {{ $totalProperties ?? \App\Models\AgentProperty::count() }}</h3>
                                        </div>
                                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                            <i class="bi bi-houses-fill"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <a href="{{ route('agent.properties.index') }}"
                                            class="text-primary text-decoration-none fw-semibold">
                                            Manage listings <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 2: Active Listings --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Active
                                                Listings</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">
                                                {{ $activeProperties ?? \App\Models\AgentProperty::where('status', 'active')->count() }}
                                            </h3>
                                        </div>
                                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check2-circle"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="text-success fw-semibold"><i class="bi bi-broadcast"></i> Live on
                                            market</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 3: Featured Properties --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Featured
                                                Listings</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">
                                                {{ $featuredProperties ?? \App\Models\AgentProperty::where('featured', 1)->count() }}
                                            </h3>
                                        </div>
                                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="text-warning fw-semibold"><i class="bi bi-lightning-fill"></i>
                                            Highlighted</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 4: Total Platform Users --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Total
                                                Users</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">
                                                {{ $totalUsers ?? \App\Models\User::count() }}</h3>
                                        </div>
                                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="text-info fw-semibold"><i
                                                class="bi bi-person-check-fill me-1"></i> Registered network</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- RECENT PROPERTIES & QUICK ACTIONS ROW --}}
                        <div class="row g-4">

                            {{-- Recent Properties Table --}}
                            <div class="col-12 col-xl-8">
                                <div class="card border-0 shadow-sm h-100">
                                    <div
                                        class="card-header border-bottom py-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Recent Property Listings</h6>
                                            <small class="text-muted">Latest properties added under your
                                                account</small>
                                        </div>
                                        <a href="{{ route('agent.properties.index') }}"
                                            class="btn btn-outline-primary btn-sm rounded-3">
                                            View All
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-3">Property</th>
                                                        <th>Type & Purpose</th>
                                                        <th>Price (PKR)</th>
                                                        <th>Status</th>
                                                        <th class="text-end pe-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $propertiesList =
                                                            $property ??
                                                            \App\Models\AgentProperty::with('images')
                                                                ->latest()
                                                                ->take(6)
                                                                ->get();
                                                    @endphp
                                                    @if ($propertiesList && $propertiesList->count() > 0)
                                                        @foreach ($propertiesList as $item)
                                                            <tr>
                                                                <td class="ps-3">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        @if ($item->images && $item->images->first())
                                                                            <img src="{{ asset('storage/' . $item->images->first()->image) }}"
                                                                                alt="{{ $item->title }}"
                                                                                class="rounded-3" width="48"
                                                                                height="40"
                                                                                style="object-fit: cover;">
                                                                        @else
                                                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted"
                                                                                style="width: 48px; height: 40px;">
                                                                                <i class="bi bi-house"></i>
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <div class="fw-semibold text-dark text-truncate"
                                                                                style="max-width: 180px;">
                                                                                {{ $item->title }}</div>
                                                                            <small class="text-muted"><i
                                                                                    class="bi bi-geo-alt"></i>
                                                                                {{ $item->city ?? ($item->location ?? 'Pakistan') }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-light text-dark border">{{ $item->property_type }}</span>
                                                                    <span
                                                                        class="badge {{ $item->purpose == 'Sale' ? 'badge-soft-success' : 'badge-soft-primary' }} ms-1">
                                                                        For {{ $item->purpose }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="fw-bold text-dark">Rs.
                                                                        {{ number_format($item->price) }}</div>
                                                                </td>
                                                                <td>
                                                                    @if ($item->status == 'active')
                                                                        <span
                                                                            class="badge badge-soft-success rounded-pill px-2 py-1"><i
                                                                                class="bi bi-dot"></i> Active</span>
                                                                    @elseif($item->status == 'sold')
                                                                        <span
                                                                            class="badge badge-soft-danger rounded-pill px-2 py-1">Sold</span>
                                                                    @elseif($item->status == 'rented')
                                                                        <span
                                                                            class="badge badge-soft-info rounded-pill px-2 py-1">Rented</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-soft-warning rounded-pill px-2 py-1">Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end pe-3">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-end gap-1">
                                                                        <a href="{{ route('agent.properties.edit', $item->id) }}"
                                                                            class="btn btn-sm btn-outline-secondary rounded-2 p-1 px-2"
                                                                            title="Edit Listing">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center py-5">
                                                                <div class="text-muted mb-2"><i
                                                                        class="bi bi-house-door fs-1"></i></div>
                                                                <h6 class="fw-bold text-dark">No Properties Listed Yet
                                                                </h6>
                                                                <p class="text-muted small mb-3">Add your first
                                                                    property listing to get started.</p>
                                                                <a href="{{ route('agent.properties.create') }}"
                                                                    class="btn btn-primary btn-sm rounded-3 px-3">
                                                                    <i class="bi bi-plus-lg me-1"></i> Add Property
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Agent Quick Shortcuts Card --}}
                            <div class="col-12 col-xl-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-header border-bottom py-3">
                                        <h6 class="fw-bold text-dark mb-0">Agent Shortcuts</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('agent.properties.create') }}"
                                                class="btn btn-primary d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-white bg-opacity-25 rounded-2 p-2 d-flex">
                                                        <i class="bi bi-plus-circle-fill fs-5 text-white"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-white">Add New Listing</div>
                                                        <small class="text-white-50">Publish a new property</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-white"></i>
                                            </a>

                                            <a href="{{ route('agent.properties.index') }}"
                                                class="btn btn-light border d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div
                                                        class="bg-primary bg-opacity-10 text-primary rounded-2 p-2 d-flex">
                                                        <i class="bi bi-houses-fill fs-5"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-dark">Manage Properties</div>
                                                        <small class="text-muted">Edit and update listings</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </a>

                                            <a href="{{ route('home') }}" target="_blank"
                                                class="btn btn-light border d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div
                                                        class="bg-success bg-opacity-10 text-success rounded-2 p-2 d-flex">
                                                        <i class="bi bi-globe fs-5"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-dark">Live Website</div>
                                                        <small class="text-muted">View publicly published
                                                            listings</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                @endif

            </main>

            {{-- FOOTER --}}
            <footer
                class="mt-auto py-3 px-4 text-center text-md-start d-md-flex align-items-center justify-content-between text-muted small">
                <div>
                    &copy; {{ date('Y') }} <strong>EstatePro</strong>. All rights reserved.
                </div>
                <div class="mt-2 mt-md-0">
                    <span>Agent Management Console</span>
                </div>
            </footer>

        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dark / Light Mode Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            function applyTheme(theme) {
                document.documentElement.setAttribute('data-bs-theme', theme);
                localStorage.setItem('estatepro_agent_theme', theme);

                if (themeIcon && themeToggleBtn) {
                    if (theme === 'dark') {
                        themeIcon.className = 'bi bi-sun-fill text-warning';
                        themeToggleBtn.setAttribute('title', 'Switch to Light Mode');
                    } else {
                        themeIcon.className = 'bi bi-moon-stars-fill text-secondary';
                        themeToggleBtn.setAttribute('title', 'Switch to Dark Mode');
                    }
                }
            }

            // Read current theme or default to 'dark'
            const currentTheme = localStorage.getItem('estatepro_agent_theme') || 'dark';
            applyTheme(currentTheme);

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    const activeTheme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
                    const newTheme = activeTheme === 'dark' ? 'light' : 'dark';
                    applyTheme(newTheme);
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Buyer Dashboard') | EstatePro
    </title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --sidebar: #111827;
            --sidebar-light: #1f2937;
            --body-bg: #f5f7fb;
            --text-dark: #111827;
            --text-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--body-bg);
            color: var(--text-dark);
            font-family: "Inter", "Segoe UI", sans-serif;
        }

        /* =========================
           NAVBAR
        ========================= */

        .top-navbar {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            margin-right: 9px;
        }

        .user-dropdown-btn {
            background: transparent;
            border: 0;
            padding: 5px 8px;
        }

        .user-dropdown-btn:hover {
            background: #f3f4f6;
            border-radius: 10px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: linear-gradient(135deg,
                    #2563eb,
                    #7c3aed);

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
            font-size: 16px;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 260px;
            background: var(--sidebar);

            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;

            padding: 22px 15px;

            overflow-y: auto;
            z-index: 999;
        }

        .sidebar-title {
            color: #6b7280;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;

            padding: 0 12px;
            margin-bottom: 12px;
        }

        /* Profile */

        .sidebar-profile {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.06);

            border-radius: 14px;

            padding: 14px;
            margin-bottom: 25px;
        }

        .profile-avatar {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: linear-gradient(135deg,
                    #2563eb,
                    #7c3aed);

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }

        .profile-name {
            color: white;
            font-size: 14px;
            font-weight: 600;
        }

        .profile-role {
            color: #9ca3af;
            font-size: 12px;
        }

        /* Navigation */

        .sidebar .nav-link {
            color: #cbd5e1;

            padding: 11px 13px;
            border-radius: 10px;

            margin-bottom: 5px;

            font-size: 14px;
            font-weight: 500;

            transition: all 0.2s ease;
        }

        .sidebar .nav-link i {
            font-size: 17px;
            width: 24px;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255, 255, 255, 0.07);

            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: white;

            background: linear-gradient(135deg,
                    #2563eb,
                    #3b82f6);

            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.25);
        }

        .sidebar-divider {
            border-color: rgba(255, 255, 255, 0.08);
            margin: 20px 0;
        }

        /* Logout */

        .logout-btn {
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.25);

            border-radius: 10px;
            padding: 10px;

            transition: 0.2s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            margin-left: 260px;
            min-height: calc(100vh - 70px);

            padding: 30px;
        }

        /* Welcome Card */

        .welcome-card {
            border: 0;
            border-radius: 18px;

            background: linear-gradient(135deg,
                    #ffffff,
                    #f8faff);

            box-shadow: 0 5px 25px rgba(15, 23, 42, 0.06);
        }

        .welcome-icon {
            width: 58px;
            height: 58px;

            border-radius: 15px;

            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 27px;
        }

        .welcome-title {
            font-size: 23px;
            font-weight: 750;
        }

        .welcome-text {
            color: var(--text-muted);
            font-size: 14px;
        }

        .find-property-btn {
            background: var(--primary);
            border: 0;

            padding: 11px 20px;
            border-radius: 10px;

            font-weight: 600;

            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
        }

        .find-property-btn:hover {
            background: var(--primary-dark);
        }

        /* Breadcrumb */

        .breadcrumb-wrapper {
            margin: 25px 0;
        }

        .breadcrumb {
            margin-bottom: 0;
        }

        .breadcrumb-item a {
            color: var(--primary);
            font-weight: 500;
        }

        /* =========================
           MOBILE
        ========================= */

        .mobile-menu-btn {
            display: none;
        }

        @media (max-width: 991px) {

            .sidebar {
                width: 230px;
            }

            .main-content {
                margin-left: 230px;
                padding: 20px;
            }

        }

        @media (max-width: 767px) {

            .top-navbar {
                height: 65px;
            }

            .mobile-menu-btn {
                display: inline-flex;
            }

            .sidebar {
                top: 65px;

                left: -270px;

                width: 260px;

                transition: 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
            }

            .welcome-title {
                font-size: 20px;
            }

            .find-property-btn {
                width: 100%;
                margin-top: 15px;
            }

        }
    </style>

</head>


<body>


    {{-- =========================
     TOP NAVBAR
========================= --}}

    <nav class="navbar top-navbar">

        <div class="container-fluid px-3 px-lg-4">

            <div class="d-flex align-items-center">

                {{-- Mobile Menu --}}
                <button class="btn btn-light mobile-menu-btn me-2" id="sidebarToggle">

                    <i class="bi bi-list fs-5"></i>

                </button>


                {{-- Logo --}}
                <a href="{{ route('buyer.dashboard') }}" class="brand">

                    <span class="brand-icon">

                        <i class="bi bi-buildings"></i>

                    </span>

                    EstatePro

                </a>

            </div>


            {{-- Right Side --}}
            <div class="dropdown">

                <button class="btn user-dropdown-btn dropdown-toggle d-flex align-items-center gap-2" type="button"
                    data-bs-toggle="dropdown">

                    <div class="user-avatar">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>

                    <div class="text-start d-none d-md-block">

                        <div class="fw-semibold small">

                            {{ auth()->user()->name }}

                        </div>

                        <small class="text-muted">

                            Buyer

                        </small>

                    </div>

                </button>


                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">

                    <li>

                        <div class="dropdown-header">

                            <strong>
                                {{ auth()->user()->name }}
                            </strong>

                            <br>

                            <small>
                                {{ auth()->user()->email }}
                            </small>

                        </div>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>


                    <li>

                        <a href="#" class="dropdown-item">

                            <i class="bi bi-person me-2"></i>

                            My Profile

                        </a>

                    </li>


                    <li>

                        <a href="#" class="dropdown-item">

                            <i class="bi bi-heart me-2"></i>

                            Saved Properties

                        </a>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    <li>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button type="submit" class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right me-2"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

    </nav>



    {{-- =========================
     SIDEBAR
========================= --}}

    <aside class="sidebar" id="sidebar">


        <div class="sidebar-title">

            Buyer Panel

        </div>


        {{-- Profile Card --}}

        <div class="sidebar-profile">

            <div class="d-flex align-items-center">

                <div class="profile-avatar me-3">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>


                <div>

                    <div class="profile-name">

                        {{ auth()->user()->name }}

                    </div>

                    <div class="profile-role">

                        <i class="bi bi-patch-check-fill me-1"></i>

                        Verified Buyer

                    </div>

                </div>

            </div>

        </div>


        {{-- Navigation --}}

        <nav class="nav flex-column">


            {{-- Dashboard --}}

            <a href="{{ route('buyer.dashboard') }}"
                class="nav-link
            {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid-1x2-fill me-2"></i>

                Dashboard

            </a>


            {{-- Browse Properties --}}

            <a href="{{ route('buyer.properties') }}" class="nav-link">

                <i class="bi bi-search me-2"></i>

                Browse Properties

            </a>


            {{-- Saved Properties --}}
            @php
                $buyerSavedCount = \App\Models\SavedProperty::where('buyer_id', auth()->id())->count();
            @endphp
            <a href="{{ route('saved-properties.index') }}"
                class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs('saved-properties.index') ? 'active' : '' }}">
                <div>
                    <i class="bi bi-heart me-2"></i>
                    <span>Saved Properties</span>
                </div>
                @if($buyerSavedCount > 0)
                    <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">
                        {{ $buyerSavedCount }}
                    </span>
                @endif
            </a>


            {{-- My Inquiries --}}

            {{-- <a
            href="{{route('buyer.inquiries.index')}}"
            class="nav-link">

            <i class="bi bi-chat-left-text me-2"></i>

            My Inquiries

        </a> --}}


            <a href="{{ route('buyer.inquiries.index') }}"
                class="nav-link {{ request()->routeIs('buyer.inquiries.indexs') ? 'active' : '' }}">

                <i class="bi bi-chat-left-text me-2"></i>

                <span> My Inquiries</span>


                <span class="badge bg-primary rounded-pill ms-auto" style="font-size: 0.7rem;">
                    {{ \App\Models\BuyerInquiry::where('buyer_id', Auth::id())->whereNotNull('reply')->where('reply', '!=', '')->count() }}
                </span>

            </a>


            {{-- Recently Viewed --}}

            <a href="{{ route('buyer.properties.recently-viewed') }}" class="nav-link">

                <i class="bi bi-clock-history me-2"></i>

                Recently Viewed

            </a>


            {{-- Profile --}}

            <a href="#" class="nav-link">

                <i class="bi bi-person me-2"></i>

                My Profile

            </a>

        </nav>


        <hr class="sidebar-divider">


        {{-- Logout --}}

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="btn logout-btn w-100">

                <i class="bi bi-box-arrow-right me-2"></i>

                Logout

            </button>

        </form>


    </aside>



    {{-- =========================
     MAIN CONTENT
========================= --}}

    <main class="main-content">


        {{-- Welcome Card --}}

        <div class="card welcome-card mb-4">

            <div class="card-body p-4">

                <div class="row align-items-center">


                    <div class="col-lg-8">

                        <div class="d-flex align-items-center">

                            <div class="welcome-icon me-3">

                                <i class="bi bi-house-heart"></i>

                            </div>


                            <div>

                                <div class="text-primary small fw-semibold mb-1">

                                    BUYER PORTAL

                                </div>

                                <h4 class="welcome-title mb-1">

                                    Welcome back,
                                    {{ auth()->user()->name }} 👋

                                </h4>

                                <p class="welcome-text mb-0">

                                    Find your perfect property
                                    from our latest listings.

                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4 text-lg-end">

                        <a href="#" class="btn btn-primary find-property-btn">

                            <i class="bi bi-search me-2"></i>

                            Find Property

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Breadcrumb + Date --}}

        <div class="breadcrumb-wrapper">

            <div class="d-flex justify-content-between align-items-center">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">

                        <li class="breadcrumb-item">

                            <a href="{{ route('buyer.dashboard') }}" class="text-decoration-none">

                                Buyer

                            </a>

                        </li>

                        <li class="breadcrumb-item active">

                            @yield('page-title', 'Dashboard')

                        </li>

                    </ol>

                </nav>


                <div class="text-muted small">

                    <i class="bi bi-calendar3 me-1"></i>

                    {{ now()->format('d M, Y') }}

                </div>

            </div>

        </div>


        {{-- Page Content --}}

        @yield('content')


    </main>



    {{-- Bootstrap JS --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Mobile Sidebar --}}

    <script>
        const sidebar = document.getElementById('sidebar');

        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle?.addEventListener('click', function() {

            sidebar.classList.toggle('show');

        });
    </script>


    @stack('scripts')


</body>

</html>

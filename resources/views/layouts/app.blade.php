<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EstatePro - Premium Real Estate Marketplace')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-body-font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            --primary-hover: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            --primary-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            --dark-bg: #090d16;
            --dark-surface: #111827;
        }

        body {
            font-family: var(--bs-body-font-family);
            background-color: #f8fafc;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Modern Navbar */
        .site-navbar {
            background-color: rgba(9, 13, 22, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .site-navbar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 0.9rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .site-navbar .nav-link:hover,
        .site-navbar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        /* Beautiful Buttons */
        .btn-modern-primary {
            background: var(--primary-gradient);
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 0.65rem;
            box-shadow: var(--primary-shadow);
            transition: all 0.25s ease;
        }

        .btn-modern-primary:hover {
            background: var(--primary-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.45);
        }

        .btn-modern-outline {
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            background: transparent;
            font-weight: 600;
            border-radius: 0.65rem;
            transition: all 0.25s ease;
        }

        .btn-modern-outline:hover {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Avatar */
        .nav-avatar {
            width: 36px;
            height: 36px;
            border-radius: 0.5rem;
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top py-3">
        <div class="container">
            
            {{-- Brand Logo --}}
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white fs-4" href="{{ route('home') }}">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                    <i class="bi bi-buildings-fill fs-5"></i>
                </div>
                <span>Estate<span class="text-primary">Pro</span></span>
            </a>

            <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-2 text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                
                {{-- Center Links --}}
                <ul class="navbar-nav mx-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured-properties">
                            <i class="bi bi-star me-1"></i> Featured
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#all-properties">
                            <i class="bi bi-grid me-1"></i> Properties
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            <i class="bi bi-info-circle me-1"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            <i class="bi bi-envelope me-1"></i> Contact
                        </a>
                    </li>
                </ul>

                {{-- Right Actions --}}
                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    
                    @auth
                        {{-- Saved Properties Shortcut --}}
                        <a href="{{ route('user.saved.properties') }}" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-xs" title="My Saved Properties">
                            <i class="bi bi-heart-fill text-danger"></i>
                            <span class="fw-semibold">Saved</span>
                            @php
                                $savedCount = \App\Models\SavedProperty::where('buyer_id', auth()->id())->count();
                            @endphp
                            @if($savedCount > 0)
                                <span class="badge bg-danger rounded-pill px-2 py-1 ms-1" style="font-size: 0.7rem;">{{ $savedCount }}</span>
                            @endif
                        </a>

                        @php
                            $user = auth()->user();
                            $dashboardRoute = 'dashboard';
                            $roleLabel = 'User';

                            if ($user->hasRole('admin') || $user->role == 1) {
                                $dashboardRoute = 'admin.dashboard';
                                $roleLabel = 'Admin';
                            } elseif ($user->hasRole('owner') || $user->role == 'owner') {
                                $dashboardRoute = 'owner.dashboard';
                                $roleLabel = 'Owner';
                            } elseif ($user->hasRole('agent') || $user->role == 'agent') {
                                $dashboardRoute = 'agent.dashboard';
                                $roleLabel = 'Agent';
                            } elseif ($user->hasRole('buyer') || $user->role == 'buyer') {
                                $dashboardRoute = 'buyer.dashboard';
                                $roleLabel = 'Buyer';
                            } else {
                                $dashboardRoute = 'user.dashboard';
                                $roleLabel = 'User';
                            }
                        @endphp

                        <a href="{{ route($dashboardRoute) }}" class="btn btn-modern-primary btn-sm d-flex align-items-center gap-2 px-3 py-2">
                            <i class="bi bi-speedometer2"></i>
                            <span>{{ $roleLabel }} Portal</span>
                        </a>

                        {{-- User Dropdown --}}
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-white" data-bs-toggle="dropdown">
                                <div class="nav-avatar">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-3" style="min-width: 210px; background-color: #111827;">
                                <li class="px-3 py-2 border-bottom border-secondary border-opacity-25 mb-1">
                                    <div class="fw-bold text-white">{{ $user->name }}</div>
                                    <small class="text-secondary text-truncate d-block">{{ $user->email }}</small>
                                </li>
                                <li>
                                    <a class="dropdown-item text-secondary py-2 rounded-2 d-flex align-items-center gap-2" href="{{ route('user.saved.properties') }}">
                                        <i class="bi bi-heart text-danger"></i> Saved Properties
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-secondary py-2 rounded-2 d-flex align-items-center gap-2" href="{{ route($dashboardRoute) }}">
                                        <i class="bi bi-grid"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-secondary py-2 rounded-2 d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear"></i> Settings
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1 border-secondary border-opacity-25"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2 rounded-2 d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3 py-2 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-modern-primary btn-sm px-4 py-2 rounded-pill">
                            Register
                        </a>
                    @endauth

                </div>

            </div>

        </div>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <main>
        @yield('content')
    </main>

    <!-- ================= FOOTER ================= -->
    <footer id="contact" class="bg-dark text-white pt-5 pb-4 border-top border-secondary border-opacity-25">
        <div class="container pb-4">
            <div class="row g-4">
                
                {{-- Col 1 --}}
                <div class="col-12 col-lg-4">
                    <a class="d-flex align-items-center gap-2 fw-bold text-white text-decoration-none mb-3 fs-4" href="{{ route('home') }}">
                        <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-buildings-fill fs-5"></i>
                        </div>
                        <span>Estate<span class="text-primary">Pro</span></span>
                    </a>
                    <p class="text-secondary small mb-4" style="line-height: 1.8;">
                        Find your dream home with our premier real estate platform. We connect verified buyers, sellers, and licensed agents across prime locations.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px;"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px;"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px;"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle" style="width: 36px; height: 36px;"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                {{-- Col 2 --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Navigation</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-secondary">
                        <li><a href="{{ route('home') }}" class="text-secondary text-decoration-none hover-white">Home</a></li>
                        <li><a href="#featured-properties" class="text-secondary text-decoration-none hover-white">Featured</a></li>
                        <li><a href="#all-properties" class="text-secondary text-decoration-none hover-white">All Properties</a></li>
                        <li><a href="{{ route('user.saved.properties') }}" class="text-secondary text-decoration-none hover-white">Saved Properties</a></li>
                        <li><a href="#about" class="text-secondary text-decoration-none hover-white">About Us</a></li>
                    </ul>
                </div>

                {{-- Col 3 --}}
                <div class="col-6 col-md-3 col-lg-2">
                    <h6 class="fw-bold text-white mb-3">Categories</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-secondary">
                        <li>Modern Houses</li>
                        <li>Luxury Apartments</li>
                        <li>Commercial Plazas</li>
                        <li>Residential Plots</li>
                        <li>Villas & Farmhouses</li>
                    </ul>
                </div>

                {{-- Col 4 --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <h6 class="fw-bold text-white mb-3">Contact Information</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-secondary">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt text-primary"></i>
                            <span>DHA Phase 5, Lahore, Pakistan</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-telephone text-primary"></i>
                            <span>+92 300 1234567</span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-primary"></i>
                            <span>support@estatepro.com</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="border-top border-secondary border-opacity-25 pt-3 mt-3">
            <div class="container text-center text-secondary small">
                &copy; {{ date('Y') }} <strong>EstatePro</strong>. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>

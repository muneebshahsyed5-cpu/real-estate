<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Agent Panel')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #111827;
            position: fixed;
            left: 0;
            top: 0;
            padding: 25px 15px;
        }

        .sidebar h4 {
            color: white;
            margin-bottom: 30px;
            padding-left: 12px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2563eb;
            color: white;
        }

        .sidebar .section-title {
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            margin: 25px 12px 10px;
        }

        .main {
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            height: 70px;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }
    </style>

    @yield('styles')

</head>

<body>


    <!-- ================= SIDEBAR ================= -->

    <div class="sidebar">

        <h4>
            <i class="bi bi-building"></i>
            Agent Panel
        </h4>


        <a href="{{ route('agent.dashboard') }}" class="{{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid"></i>

            Dashboard

        </a>


        <div class="section-title">
            Properties
        </div>


        <a href="{{ route('agent.properties.index') }}"
            class="{{ request()->routeIs('agent.properties.index') ? 'active' : '' }}">

            <i class="bi bi-house"></i>

            My Properties

        </a>


        <a href="{{ route('agent.properties.create') }}"
            class="{{ request()->routeIs('agent.properties.create') ? 'active' : '' }}">

            <i class="bi bi-plus-circle"></i>

            Add Property

        </a>


        <div class="section-title">
            Management
        </div>


        {{-- <a href="#">

            <i class="bi bi-chat-left-text"></i>

            Buyer Inquiries

        </a> --}}


        <a href="#">

            <i class="bi bi-star"></i>

            Featured Properties

        </a>


        <div class="section-title">
            Account
        </div>


        <a href="{{ route('profile.edit') }}">

            <i class="bi bi-person"></i>

            My Profile

        </a>


        <a href="{{ route('home') }}">

            <i class="bi bi-globe"></i>

            View Website

        </a>


        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="btn text-start w-100 text-light mt-2">

                <i class="bi bi-box-arrow-right me-2"></i>

                Logout

            </button>

        </form>

    </div>


    <!-- ================= MAIN ================= -->

    <div class="main">


        <!-- TOPBAR -->

        <div class="topbar">

            <div>

                <h5 class="mb-0">

                    @yield('page-title', 'Agent Panel')

                </h5>

                <small class="text-muted">

                    Manage your properties

                </small>

            </div>


            @yield('topbar-action')

        </div>


        <!-- CONTENT -->

        <div class="content">


            <!-- SUCCESS MESSAGE -->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">

                    <i class="bi bi-check-circle me-2"></i>

                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>

                </div>
            @endif


            <!-- PAGE CONTENT -->

            @yield('content')


        </div>


        <!-- FOOTER -->

        <footer class="text-center text-muted py-4">

            © {{ date('Y') }} Real Estate Agent Panel

        </footer>


    </div>


    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')


</body>

</html>

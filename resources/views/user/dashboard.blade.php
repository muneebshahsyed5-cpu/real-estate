<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background-color: #343a40 !important;
            color: #fff !important;
        }

        .sidebar-link.active {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        .main-content {
            min-height: calc(100vh - 56px);
        }

        .property-card img {
            height: 200px;
            object-fit: cover;
        }
    </style>

</head>

<body class="bg-light">

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar navbar-dark bg-primary shadow">

        <div class="container-fluid">

            <a class="navbar-brand fw-bold" href="{{ route('user.dashboard') }}">
                <i class="bi bi-buildings me-1"></i>
                RealEstate
            </a>

            <div class="d-flex align-items-center text-white">

                <div class="text-end me-3">

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <br>

                    <small>
                        User
                    </small>

                </div>

                <div class="bg-white text-primary rounded-circle
                            d-flex align-items-center justify-content-center"
                    style="width: 42px; height: 42px;">

                    <strong>
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </strong>

                </div>

            </div>

        </div>

    </nav>


    <!-- ================= MAIN LAYOUT ================= -->

    <div class="container-fluid">

        <div class="row">

            <!-- ================= SIDEBAR ================= -->

            <div class="col-md-2 bg-dark p-3 sidebar">

                <div class="list-group list-group-flush">

                    <!-- Dashboard -->

                    <a href="{{ route('user.dashboard') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        {{ request()->routeIs('user.dashboard') ? 'active' : 'bg-dark text-white border-0' }}">

                        <i class="bi bi-speedometer2 me-2"></i>

                        Dashboard

                    </a>


                    <!-- Home -->

                    <a href="{{ route('home') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        bg-dark text-white border-0">

                        <i class="bi bi-house me-2"></i>

                        Home

                    </a>


                    <!-- Properties -->
                    @php

                        $property = \App\Models\Property::count();
                    @endphp
                    <a href="{{ route('home') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        bg-dark text-white border-0">

                        <i class="bi bi-buildings me-2"></i>

                        properties

                    </a>


                    <!-- Favorites -->

                    <a href="{{ route('user.saved.properties') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        bg-dark text-white border-0">

                        <i class="bi bi-heart me-2"></i>

                        Favorites

                    </a>


                    <!-- My Inquiries -->

                    <a href="{{ route('user.inquiries.index') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        {{ request()->routeIs('user.inquiries.index') ? 'active' : 'bg-dark text-white border-0' }}">

                        <i class="bi bi-chat-dots me-2"></i>

                        My Inquiries

                    </a>


                    <!-- Profile -->

                    <a href="{{ route('profile.edit') }}"
                        class="list-group-item list-group-item-action sidebar-link
                        bg-dark text-white border-0">

                        <i class="bi bi-person me-2"></i>

                        Profile

                    </a>


                    <hr class="border-secondary">


                    <!-- Logout -->

                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button type="submit"
                            class="list-group-item list-group-item-action
                            bg-dark text-danger border-0 w-100 text-start">

                            <i class="bi bi-box-arrow-right me-2"></i>

                            Logout

                        </button>

                    </form>

                </div>

            </div>


            <!-- ================= MAIN CONTENT ================= -->
            <div class="col-md-10 p-4 main-content">

                @yield('content')

            </div>

        </div>

    </div>


    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

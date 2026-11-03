<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>RealEstate</title>
</head>

<body class="bg-light">

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow border-bottom border-primary border-2">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold text-info" href="{{ route('home') }}">
            🏠 RealEstate
        </a>

        <!-- Mobile Button -->
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <!-- Properties -->
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                        Properties
                    </a>
                </li>

                <!-- About -->
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                        About
                    </a>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                        Contact
                    </a>
                </li>


                @auth

                    <!-- Role Based Dashboard -->
                    @if(auth()->user()->role == 1)

                        <li class="nav-item ms-lg-2">
                            <a class="nav-link text-warning fw-semibold"
                               href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>
                        </li>

                    @else

                        <li class="nav-item ms-lg-2">
                            <a class="nav-link text-info fw-semibold"
                               href="{{ route('user.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                    @endif


                    <!-- Logout -->
                    <li class="nav-item ms-lg-2">

                        <form action="{{ route('logout') }}" method="POST">

                            @csrf

                            <button type="submit"
                                    class="btn btn-danger btn-sm px-3">
                                Logout
                            </button>

                        </form>

                    </li>


                @else

                    <!-- Login -->
                    <li class="nav-item ms-lg-2">

                        <a href="{{ route('login') }}"
                           class="btn btn-outline-info btn-sm px-3">

                            Login

                        </a>

                    </li>


                    <!-- Register -->
                    <li class="nav-item ms-lg-2">

                        <a href="{{ route('register') }}"
                           class="btn btn-primary btn-sm px-3">

                            Register

                        </a>

                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>


<!-- ================= CONTENT ================= -->

@yield('content')


<!-- ================= FOOTER ================= -->

<footer class="bg-dark text-white mt-5 border-top border-primary border-2">

    <div class="container py-5">

        <div class="row">


            <!-- About -->
            <div class="col-md-4 mb-4">

                <h4 class="fw-bold text-info">
                    🏠 RealEstate
                </h4>

                <p class="text-secondary">

                    Find your dream home with our trusted real estate
                    platform. Buy, sell and rent properties easily.

                </p>

            </div>


            <!-- Quick Links -->
            <div class="col-md-2 mb-4">

                <h5 class="text-white">
                    Quick Links
                </h5>

                <ul class="list-unstyled">

                    <li class="mb-2">

                        <a href="{{ route('home') }}"
                           class="text-secondary text-decoration-none">

                            Home

                        </a>

                    </li>


                    <li class="mb-2">

                        <a href="#"
                           class="text-secondary text-decoration-none">

                            Properties

                        </a>

                    </li>


                    <li class="mb-2">

                        <a href="#"
                           class="text-secondary text-decoration-none">

                            About

                        </a>

                    </li>


                    <li>

                        <a href="#"
                           class="text-secondary text-decoration-none">

                            Contact

                        </a>

                    </li>

                </ul>

            </div>


            <!-- Properties -->
            <div class="col-md-3 mb-4">

                <h5 class="text-white">
                    Properties
                </h5>

                <ul class="list-unstyled text-secondary">

                    <li class="mb-2">
                        Houses
                    </li>

                    <li class="mb-2">
                        Apartments
                    </li>

                    <li class="mb-2">
                        Commercial Properties
                    </li>

                    <li>
                        Plots
                    </li>

                </ul>

            </div>


            <!-- Contact -->
            <div class="col-md-3 mb-4">

                <h5 class="text-white">
                    Contact Us
                </h5>

                <p class="text-secondary mb-2">
                    📍 Lahore, Pakistan
                </p>

                <p class="text-secondary mb-2">
                    📞 +92 300 1234567
                </p>

                <p class="text-secondary">
                    ✉️ info@realestate.com
                </p>

            </div>

        </div>

    </div>


    <!-- Copyright -->

    <div class="border-top border-secondary">

        <div class="container py-3 text-center">

            <p class="mb-0 text-secondary">

                © {{ date('Y') }} RealEstate. All Rights Reserved.

            </p>

        </div>

    </div>

</footer>


<!-- Bootstrap JS -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

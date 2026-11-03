{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Syed Muneeb Ahamd | PHP Laravel Developer</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

   <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: #eef2f7;
        font-family: "Inter", sans-serif;
        color: #263238;
    }

    /* ================= MAIN CV ================= */

    .cv-container {
        max-width: 1050px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 25px 70px rgba(15, 23, 42, 0.15);
    }


    /* ================= HEADER ================= */

    .cv-header {
        position: relative;
        overflow: hidden;
        background:
            linear-gradient(135deg, #0f172a, #172554, #1e3a8a);
        color: white;
        padding: 55px 50px;
    }

    .cv-header::before {
        content: "";
        position: absolute;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(96, 165, 250, 0.12);
        top: -140px;
        right: -80px;
    }

    .cv-header::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.10);
        bottom: -100px;
        left: -50px;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }


    /* ================= PROFILE IMAGE ================= */

    .image-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-img {
        width: 165px;
        height: 165px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.95);
        box-shadow:
            0 0 0 8px rgba(96, 165, 250, 0.18),
            0 15px 40px rgba(0, 0, 0, 0.30);
    }


    /* ================= HEADER TEXT ================= */

    .name {
        font-size: 42px;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 8px;
    }

    .job-title {
        display: inline-block;
        color: #93c5fd;
        font-size: 19px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .job-title::after {
        content: "";
        display: block;
        width: 55px;
        height: 3px;
        background: #60a5fa;
        margin-top: 7px;
        border-radius: 10px;
    }


    /* ================= CONTACT ================= */

    .contact-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.10);
        padding: 9px 13px;
        border-radius: 8px;
        font-size: 13px;
    }

    .contact-item i {
        color: #60a5fa;
    }


    /* ================= BODY ================= */

    .cv-body {
        padding: 45px 50px;
    }


    /* ================= SECTION ================= */

    .section {
        margin-bottom: 38px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0f172a;
        font-size: 21px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .section-title i {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 10px;
        font-size: 18px;
        flex-shrink: 0;
    }

    .section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }


    /* ================= SUMMARY ================= */

    .summary {
        color: #475569;
        font-size: 15px;
        line-height: 1.85;
    }


    /* ================= EDUCATION ================= */

    .education-card {
        position: relative;
        padding: 22px 25px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #2563eb;
        border-radius: 10px;
    }

    .education-title {
        color: #0f172a;
        font-size: 17px;
        font-weight: 700;
    }

    .education-subtitle {
        color: #64748b;
        margin-top: 5px;
    }

    .education-badge {
        display: inline-block;
        margin-top: 12px;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }


    /* ================= SKILLS ================= */

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }

    .skill-card {
        padding: 15px 17px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #ffffff;
    }

    .skill-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .skill-name {
        font-weight: 600;
        color: #334155;
        font-size: 14px;
    }

    .skill-level {
        font-size: 11px;
        color: #64748b;
    }

    .progress {
        height: 5px;
        background: #e2e8f0;
    }

    .progress-bar {
        background: linear-gradient(90deg, #2563eb, #60a5fa);
        border-radius: 10px;
    }


    /* ================= PROJECTS ================= */

    .project-card {
        position: relative;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 18px;
        overflow: hidden;
    }

    .project-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(#2563eb, #60a5fa);
    }

    .project-title {
        color: #0f172a;
        font-size: 17px;
        font-weight: 750;
        margin-bottom: 8px;
    }

    .technology {
        display: inline-block;
        color: #2563eb;
        background: #eff6ff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .project-card ul {
        margin: 0;
        padding-left: 20px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.8;
    }


    /* ================= EXPERIENCE ================= */

    .experience-card {
        padding: 22px 25px;
        border-radius: 12px;
        background: linear-gradient(135deg, #f8fafc, #eff6ff);
        border: 1px solid #dbeafe;
    }

    .experience-title {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
    }

    .experience-status {
        display: inline-block;
        margin-top: 8px;
        padding: 5px 10px;
        background: #dcfce7;
        color: #15803d;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
    }


    /* ================= ADDITIONAL SKILLS ================= */

    .additional-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        list-style: none;
        padding: 0;
    }

    .additional-list li {
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 11px 14px;
        border-radius: 7px;
        font-size: 13px;
    }

    .additional-list li::before {
        content: "✓";
        color: #2563eb;
        font-weight: 800;
        margin-right: 8px;
    }


    /* ================= FOOTER ================= */

    .cv-footer {
        text-align: center;
        padding: 22px;
        background: #0f172a;
        color: #94a3b8;
        font-size: 12px;
    }


    /* ================= RESPONSIVE ================= */

    @media (max-width: 768px) {

        .cv-container {
            margin: 15px;
            border-radius: 12px;
        }

        .cv-header {
            padding: 40px 25px;
            text-align: center;
        }

        .name {
            font-size: 31px;
            margin-top: 20px;
        }

        .job-title::after {
            margin-left: auto;
            margin-right: auto;
        }

        .contact-list {
            justify-content: center;
        }

        .cv-body {
            padding: 35px 25px;
        }

        .skills-grid,
        .additional-list {
            grid-template-columns: 1fr;
        }
    }


    /* ================= PRINT ================= */

    @media print {

        @page {
            size: A4;
            margin: 10mm;
        }

        html {
            scroll-behavior: auto;
        }

        body {
            background: #ffffff;
        }

        .cv-container {
            max-width: 100%;
            margin: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .cv-header {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .cv-footer {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .project-card,
        .skill-card,
        .education-card,
        .experience-card {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    }
</style>

</head>


<body>


<div class="cv-container">


    <!-- =====================================================
                         HEADER
    ====================================================== -->

    <header class="cv-header">

        <div class="header-content">

            <div class="row align-items-center">

                <!-- IMAGE -->

                <div class="col-md-3 text-center">

                    <div class="image-wrapper">

                        <img
                            src="{{ asset('storage/agents/agent1.jpg') }}"
                            alt="Syed Muneeb Ahamd"
                            class="profile-img">

                    </div>

                </div>


                <!-- INFORMATION -->

                <div class="col-md-9">

                    <h1 class="name">
                        Syed Muneeb Ahamd
                    </h1>

                    <div class="job-title">
                        PHP / Laravel Web Developer
                    </div>


                    <div class="contact-list">

                        <div class="contact-item">

                            <i class="bi bi-telephone-fill"></i>

                            <span>
                                03284512561
                            </span>

                        </div>


                        <div class="contact-item">

                            <i class="bi bi-envelope-fill"></i>

                            <span>
                                muneebshahsyed5@gmail.com
                            </span>

                        </div>


                        <div class="contact-item">

                            <i class="bi bi-geo-alt-fill"></i>

                            <span>
                                Lahore, Pakistan
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </header>



    <!-- =====================================================
                          BODY
    ====================================================== -->

    <main class="cv-body">


        <!-- ================= SUMMARY ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-person-fill"></i>

                Professional Summary

            </h2>


            <p class="summary">

                Motivated and passionate BSCS student currently studying
                in the 3rd semester at Virtual University of Pakistan.
                I have hands-on experience in web development using
                PHP and Laravel, along with HTML, CSS, Bootstrap,
                JavaScript and basic React.js.

                I enjoy developing responsive and user-friendly web
                applications and continuously improving my programming
                and development skills.

                Currently seeking a Web Development / PHP Laravel
                internship opportunity to gain professional industry
                experience and contribute to real-world projects.

            </p>

        </section>



        <!-- ================= EDUCATION ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-mortarboard-fill"></i>

                Education

            </h2>


            <div class="education-card">

                <div class="education-title">

                    Bachelor of Science in Computer Science (BSCS)

                </div>

                <div class="education-subtitle">

                    Virtual University of Pakistan

                </div>

                <span class="education-badge">

                    Currently Studying — 3rd Semester

                </span>

            </div>

        </section>



        <!-- ================= SKILLS ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-code-slash"></i>

                Technical Skills

            </h2>


            <div class="skills-grid">


                <!-- PHP -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            PHP
                        </span>

                        <span class="skill-level">
                            Intermediate
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 75%">
                        </div>

                    </div>

                </div>


                <!-- Laravel -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            Laravel
                        </span>

                        <span class="skill-level">
                            Intermediate
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 78%">
                        </div>

                    </div>

                </div>


                <!-- MySQL -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            MySQL
                        </span>

                        <span class="skill-level">
                            Basic / Intermediate
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 65%">
                        </div>

                    </div>

                </div>


                <!-- HTML -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            HTML5
                        </span>

                        <span class="skill-level">
                            Good
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 85%">
                        </div>

                    </div>

                </div>


                <!-- CSS -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            CSS3
                        </span>

                        <span class="skill-level">
                            Good
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 75%">
                        </div>

                    </div>

                </div>


                <!-- Bootstrap -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            Bootstrap
                        </span>

                        <span class="skill-level">
                            Good
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 82%">
                        </div>

                    </div>

                </div>


                <!-- JavaScript -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            JavaScript
                        </span>

                        <span class="skill-level">
                            Basic
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 55%">
                        </div>

                    </div>

                </div>


                <!-- React -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            React.js
                        </span>

                        <span class="skill-level">
                            Basic
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 40%">
                        </div>

                    </div>

                </div>


                <!-- Git -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            Git / GitHub
                        </span>

                        <span class="skill-level">
                            Basic
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 50%">
                        </div>

                    </div>

                </div>


                <!-- Responsive -->

                <div class="skill-card">

                    <div class="skill-top">

                        <span class="skill-name">
                            Responsive Design
                        </span>

                        <span class="skill-level">
                            Good
                        </span>

                    </div>

                    <div class="progress">

                        <div
                            class="progress-bar"
                            style="width: 80%">
                        </div>

                    </div>

                </div>


            </div>

        </section>



        <!-- ================= PROJECTS ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-folder-fill"></i>

                Projects

            </h2>


            <!-- REAL ESTATE -->

            <div class="project-card">

                <div class="project-title">

                    Real Estate Management System

                </div>

                <span class="technology">

                    PHP · Laravel · MySQL · Bootstrap · JavaScript

                </span>

                <ul>

                    <li>
                        Developed a Laravel-based real estate management
                        system.
                    </li>

                    <li>
                        Implemented property listing and detailed
                        property pages.
                    </li>

                    <li>
                        Added Admin, Owner, Agent and Buyer roles.
                    </li>

                    <li>
                        Implemented authentication and role-based access.
                    </li>

                    <li>
                        Added property images and property management.
                    </li>

                    <li>
                        Added buyer inquiries and saved properties.
                    </li>

                    <li>
                        Created separate dashboards and management
                        interfaces.
                    </li>

                </ul>

            </div>


            <!-- ECOMMERCE -->

            <div class="project-card">

                <div class="project-title">

                    E-Commerce Website

                </div>

                <span class="technology">

                    PHP · Laravel · MySQL · Bootstrap · JavaScript

                </span>

                <ul>

                    <li>
                        Developed an e-commerce website for displaying
                        and managing products.
                    </li>

                    <li>
                        Created product listing and product detail pages.
                    </li>

                    <li>
                        Implemented product management functionality.
                    </li>

                    <li>
                        Designed responsive interfaces using Bootstrap.
                    </li>

                    <li>
                        Used Laravel and MySQL for backend and database
                        operations.
                    </li>

                </ul>

            </div>


            <!-- PRODUCT SELLING -->

            <div class="project-card">

                <div class="project-title">

                    Product Selling / Sale-Out Website

                </div>

                <span class="technology">

                    PHP · Laravel · MySQL · Bootstrap · JavaScript

                </span>

                <ul>

                    <li>
                        Developed a product selling web application.
                    </li>

                    <li>
                        Created product display and information pages.
                    </li>

                    <li>
                        Implemented product management features.
                    </li>

                    <li>
                        Worked with Laravel backend and MySQL database.
                    </li>

                    <li>
                        Created a clean and responsive Bootstrap interface.
                    </li>

                </ul>

            </div>

        </section>



        <!-- ================= EXPERIENCE ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-briefcase-fill"></i>

                Experience

            </h2>


            <div class="experience-card">

                <div class="experience-title">

                    Fresher / Internship Seeker

                </div>

                <span class="experience-status">

                    OPEN TO INTERNSHIP

                </span>

                <p class="summary mt-3 mb-0">

                    Currently seeking a Web Development / PHP Laravel
                    internship opportunity to gain practical industry
                    experience, work on real-world applications and
                    improve professional development skills.

                </p>

            </div>

        </section>



        <!-- ================= CAREER OBJECTIVE ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-bullseye"></i>

                Career Objective

            </h2>


            <p class="summary">

                To obtain a Web Development or PHP Laravel internship
                where I can apply my existing technical knowledge,
                learn from experienced developers, contribute to
                real-world projects and grow into a professional
                full-stack web developer.

            </p>

        </section>



        <!-- ================= ADDITIONAL SKILLS ================= -->

        <section class="section">

            <h2 class="section-title">

                <i class="bi bi-stars"></i>

                Additional Skills

            </h2>


            <ul class="additional-list">

                <li>
                    Problem Solving
                </li>

                <li>
                    Database Management Basics
                </li>

                <li>
                    Responsive Web Design
                </li>

                <li>
                    Front-End Development Basics
                </li>

                <li>
                    Back-End Development Basics
                </li>

                <li>
                    Willingness to Learn
                </li>

            </ul>

        </section>


    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="cv-footer">

        <i class="bi bi-code-slash"></i>

        PHP / Laravel Web Developer · Syed Muneeb Ahamd

    </footer>


</div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html> --}}
@extends('agent.dashboard')

@section('title', 'Properties Management')
@section('page-title', 'Properties Management')

@section('content')

    <div class="container-fluid p-0">

        {{-- Header Section --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">All Properties</h3>
                <p class="text-muted mb-0">Manage, update and organize your real estate listings.</p>
            </div>

            <a href="{{ route('properties.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm">
                <i class="bi bi-plus-lg"></i>
                <span>Add Property</span>
            </a>
        </div>

        {{-- Success Notification --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Properties Table Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2">
                <span class="fw-bold text-dark">Property Listings <span class="badge bg-primary bg-opacity-10 text-primary ms-1">{{ count($properties) }}</span></span>
                <span class="text-muted small">Showing all active and listed properties</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width: 50px;">#</th>
                                <th>Property Details</th>
                                <th>Type</th>
                                <th>Purpose</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($properties as $property)
                                <tr>
                                    {{-- ID --}}
                                    <td class="ps-3 text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Property Image + Title --}}
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($property->images && $property->images->count() > 0)
                                                <img src="{{ asset('storage/' . $property->images->first()->image) }}"
                                                    alt="{{ $property->title }}" width="60" height="50"
                                                    class="rounded-3 shadow-xs" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted border"
                                                    style="width: 60px; height: 50px;">
                                                    <i class="bi bi-house fs-5"></i>
                                                </div>
                                            @endif

                                            <div>
                                                <strong class="text-dark d-block text-truncate" style="max-width: 200px;">
                                                    {{ $property->title }}
                                                </strong>
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i> {{ $property->city ?? 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Type --}}
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $property->property_type }}
                                        </span>
                                    </td>

                                    {{-- Purpose --}}
                                    <td>
                                        @if ($property->purpose == 'Sale')
                                            <span class="badge badge-soft-success rounded-pill px-2 py-1">
                                                For Sale
                                            </span>
                                        @else
                                            <span class="badge badge-soft-warning rounded-pill px-2 py-1">
                                                For Rent
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Location --}}
                                    <td>
                                        <span class="text-secondary small">{{ $property->location ?? '-' }}</span>
                                    </td>

                                    {{-- Price --}}
                                    <td>
                                        <strong class="text-dark">
                                            Rs. {{ number_format($property->price) }}
                                        </strong>
                                    </td>

                                    {{-- Area --}}
                                    <td>
                                        <span class="text-secondary small">
                                            {{ $property->area }} {{ $property->area_unit }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if ($property->status == 'active')
                                            <span class="badge badge-soft-success rounded-pill px-2 py-1">
                                                Active
                                            </span>
                                        @elseif($property->status == 'pending')
                                            <span class="badge badge-soft-warning rounded-pill px-2 py-1">
                                                Pending
                                            </span>
                                        @elseif($property->status == 'sold')
                                            <span class="badge badge-soft-danger rounded-pill px-2 py-1">
                                                Sold
                                            </span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-2 py-1">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Featured --}}
                                    <td>
                                        @if ($property->featured)
                                            <span class="badge bg-warning bg-opacity-20 text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-1">
                                                <i class="bi bi-star-fill text-warning me-1"></i> Featured
                                            </span>
                                        @else
                                            <span class="text-muted small">No</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-light border text-primary rounded-2" title="Edit Property">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('agent.properties.destroy', $property->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this property listing?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger rounded-2" title="Delete Property">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted mb-3">
                                            <i class="bi bi-house-door fs-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">No Properties Found</h5>
                                        <p class="text-muted small mb-3">You have not added any properties to your listings yet.</p>
                                        <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm rounded-3 px-3 py-2">
                                            <i class="bi bi-plus-lg"></i> Add Your First Property
                                        </a>
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


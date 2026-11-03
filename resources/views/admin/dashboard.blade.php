<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - EstatePro</title>

    <!-- Inline script to set theme before DOM render (avoids flash) -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('estatepro_admin_theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

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
        .table > :not(caption) > * > * {
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
            color: #ffffff !important;
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
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
        [data-bs-theme="light"] strong:not(.badge *),
        [data-bs-theme="light"] b,
        [data-bs-theme="light"] label,
        [data-bs-theme="light"] .form-label,
        [data-bs-theme="light"] .modal-title,
        [data-bs-theme="light"] .card-title,
        [data-bs-theme="light"] .dropdown-item {
            color: #0f172a !important;
        }

        /* Prevent white text on light backgrounds in main content */
        [data-bs-theme="light"] .main-content .text-white:not(.btn *):not(.badge *):not([style*="background"] *):not([style*="gradient"] *),
        [data-bs-theme="light"] .card:not(.bg-primary):not(.bg-danger):not(.bg-success):not([style*="background"]) > .card-header .text-white,
        [data-bs-theme="light"] .card:not(.bg-primary):not(.bg-danger):not(.bg-success):not([style*="background"]) > .card-body > div > div > .text-white,
        [data-bs-theme="light"] .btn-light .text-white,
        [data-bs-theme="light"] .table .text-white {
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
            transition: color 0.15s ease, background-color 0.15s ease;
        }

        /* Light Mode Table Row Hover -> Black / Dark Text */
        [data-bs-theme="light"] .table tbody tr {
            transition: background-color 0.15s ease;
        }

        [data-bs-theme="light"] .table tbody tr:hover,
        [data-bs-theme="light"] .table-hover tbody tr:hover {
            background-color: #f1f5f9 !important;
        }

        [data-bs-theme="light"] .table tbody tr:hover > td,
        [data-bs-theme="light"] .table tbody tr:hover > th,
        [data-bs-theme="light"] .table-hover tbody tr:hover > td,
        [data-bs-theme="light"] .table-hover tbody tr:hover > th,
        [data-bs-theme="light"] .table tbody tr:hover a:not(.btn),
        [data-bs-theme="light"] .table tbody tr:hover span:not(.badge),
        [data-bs-theme="light"] .table tbody tr:hover small,
        [data-bs-theme="light"] .table tbody tr:hover p,
        [data-bs-theme="light"] .table tbody tr:hover strong,
        [data-bs-theme="light"] .table tbody tr:hover b,
        [data-bs-theme="light"] .table tbody tr:hover .text-muted,
        [data-bs-theme="light"] .table tbody tr:hover .text-dark,
        [data-bs-theme="light"] .table tbody tr:hover i:not(.btn *):not(.badge *) {
            color: #0f172a !important;
        }

        /* Light Mode Buttons & Cards */
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
        [data-bs-theme="dark"] strong:not(.badge *),
        [data-bs-theme="dark"] b,
        [data-bs-theme="dark"] label:not(.btn),
        [data-bs-theme="dark"] .form-label,
        [data-bs-theme="dark"] .modal-title,
        [data-bs-theme="dark"] .card-title {
            color: #f8fafc !important;
        }

        /* Dark mode overrides for common bootstrap utility classes */
        [data-bs-theme="dark"] .bg-white {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #1a2333 !important;
            color: #cbd5e1 !important;
            border-color: #334155 !important;
        }

        [data-bs-theme="dark"] .input-group-text {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #cbd5e1 !important;
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

        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #111827;
            border-color: #1e293b;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #cbd5e1;
        }

        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #1e293b;
            color: #ffffff;
        }

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

        [data-bs-theme="dark"] .alert-light {
            background-color: #111827;
            border-color: #1e293b;
            color: #cbd5e1;
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
            transition: color 0.15s ease, background-color 0.15s ease;
        }

        /* Dark Mode Table Row Hover -> Pure White Text */
        [data-bs-theme="dark"] .table tbody tr {
            transition: background-color 0.15s ease;
        }

        [data-bs-theme="dark"] .table tbody tr:hover,
        [data-bs-theme="dark"] .table-hover tbody tr:hover {
            background-color: #1e293b !important;
        }

        [data-bs-theme="dark"] .table tbody tr:hover > td,
        [data-bs-theme="dark"] .table tbody tr:hover > th,
        [data-bs-theme="dark"] .table-hover tbody tr:hover > td,
        [data-bs-theme="dark"] .table-hover tbody tr:hover > th,
        [data-bs-theme="dark"] .table tbody tr:hover a:not(.btn),
        [data-bs-theme="dark"] .table tbody tr:hover span:not(.badge),
        [data-bs-theme="dark"] .table tbody tr:hover small,
        [data-bs-theme="dark"] .table tbody tr:hover p,
        [data-bs-theme="dark"] .table tbody tr:hover strong,
        [data-bs-theme="dark"] .table tbody tr:hover b,
        [data-bs-theme="dark"] .table tbody tr:hover .text-muted,
        [data-bs-theme="dark"] .table tbody tr:hover .text-dark,
        [data-bs-theme="dark"] .table tbody tr:hover i:not(.btn *):not(.badge *) {
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

        /* Ensure .text-light is ALWAYS a clean, bright, legible light color */
        .text-light,
        [data-bs-theme="dark"] .text-light,
        .badge.text-light,
        .badge.text-light *,
        .badge .text-light {
            color: #f8fafc !important;
        }

        /* Edit Header Badge & Icon: Dark in Light Mode, Light in Dark Mode */
        [data-bs-theme="light"] .edit-header-badge {
            background-color: #ffffff !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
        }
        [data-bs-theme="light"] .edit-header-icon {
            color: #0f172a !important;
        }

        [data-bs-theme="dark"] .edit-header-badge {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
        }
        [data-bs-theme="dark"] .edit-header-icon {
            color: #ffffff !important;
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
        [data-bs-theme="dark"] .btn-light span {
            color: #f8fafc !important;
        }

        /* Protect Action Buttons icon colors inside table rows (both themes) */
        .table .btn-light i.text-primary,
        [data-bs-theme="dark"] .table .btn-light i.text-primary {
            color: #3b82f6 !important;
        }
        .table .btn-light i.text-warning,
        [data-bs-theme="dark"] .table .btn-light i.text-warning {
            color: #f59e0b !important;
        }
        .table .btn-light i.text-danger,
        [data-bs-theme="dark"] .table .btn-light i.text-danger {
            color: #ef4444 !important;
        }
        .table .btn-light i.text-success,
        [data-bs-theme="dark"] .table .btn-light i.text-success {
            color: #10b981 !important;
        }
        .table .btn-light i.text-info,
        [data-bs-theme="dark"] .table .btn-light i.text-info {
            color: #06b6d4 !important;
        }

        [data-bs-theme="dark"] .btn-outline-secondary {
            border-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
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

        /* Distinct Theme Toggle Button Icons */
        #themeToggleBtn #themeIcon.bi-sun-fill {
            color: #fbbf24 !important;
        }
        #themeToggleBtn #themeIcon.bi-moon-stars-fill {
            color: #3b82f6 !important;
        }
        #themeToggleBtn:hover #themeIcon {
            color: #ffffff !important;
        }

        /* Stat Icon Highlights in Light & Dark Mode */
        [data-bs-theme="dark"] .stat-icon.bg-primary {
            background-color: rgba(59, 130, 246, 0.2) !important;
            color: #60a5fa !important;
        }
        [data-bs-theme="dark"] .stat-icon.bg-success {
            background-color: rgba(16, 185, 129, 0.2) !important;
            color: #34d399 !important;
        }
        [data-bs-theme="dark"] .stat-icon.bg-warning {
            background-color: rgba(245, 158, 11, 0.2) !important;
            color: #fbbf24 !important;
        }
        [data-bs-theme="dark"] .stat-icon.bg-info {
            background-color: rgba(6, 182, 212, 0.2) !important;
            color: #38bdf8 !important;
        }
        [data-bs-theme="dark"] .btn-primary .bg-white {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
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
        <aside class="sidebar offcanvas-lg offcanvas-start d-flex flex-column flex-shrink-0" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">

            {{-- Brand Logo Header --}}
            <div class="sidebar-brand d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-buildings-fill fs-5"></i>
                    </div>
                    <div>
                        <span class="fs-5 fw-bold text-dark tracking-tight">Estate<span class="text-primary">Pro</span></span>
                        <span class="badge bg-dark border border-secondary text-secondary ms-1 py-0 px-1" style="font-size: 0.65rem;">@yield('dashboard-badge', 'ADMIN')</span>
                    </div>
                </a>
                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>

            {{-- Navigation Items --}}
            <div class="sidebar-menu flex-grow-1 overflow-y-auto">

                <div class="sidebar-heading">Core</div>
                <div class="nav flex-column">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="sidebar-heading mt-3">Listings & Properties</div>
                <div class="nav flex-column">
                    <a href="{{ route('properties.index') }}" class="nav-link {{ request()->routeIs('properties.index') ? 'active' : '' }}">
                        <i class="bi bi-houses-fill"></i>
                        <span>All Properties</span>
                    </a>
                    <a href="{{ route('properties.create') }}" class="nav-link {{ request()->routeIs('properties.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Add Property</span>
                    </a>
                    <a href="{{route('admin.featured')}}" class="nav-link {{ request()->routeIs('admin.featured') ? 'active': ''}}">
                        <i class="bi bi-star-fill"></i>
                        <span>Featured Listings</span>
                    </a>
                </div>

                <div class="sidebar-heading mt-3">User Management</div>
                <div class="nav flex-column">
                    <a href="{{route('admin.agents')}}" class="nav-link {{ request()->routeIs('admin.agents') ? 'active': ''}}">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Agents</span>
                    </a>
                    <a href="{{route('admin.clients')}}" class="nav-link {{ request()->routeIs('admin.clients') ? 'active': ''}}">
                        <i class="bi bi-people-fill"></i>
                        <span>Clients & Buyers</span>
                    </a>
                    @php
    use App\Models\BuyerInquiry;
@endphp

<a href="{{ route('admin.inquiries') }}"
   class="nav-link {{ request()->routeIs('admin.inquiries') ? 'active' : '' }}">

    <i class="bi bi-chat-left-dots-fill"></i>

    <span>Inquiries</span>

    <span class="badge bg-primary rounded-pill ms-auto"
          style="font-size: 0.7rem;">
        {{ BuyerInquiry::count() }}
    </span>

</a>
                </div>

                <div class="sidebar-heading mt-3">Settings & System</div>
                <div class="nav flex-column">
                    <a href="{{ route('home') }}" target="_blank" class="nav-link">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>View Website</span>
                    </a>
                    <a href="{{route('admin.profile.index')}}" class="nav-link">
                        <i class="bi bi-gear-fill"></i>
                        <span>Profile Settings</span>
                    </a>
                </div>

            </div>

            {{-- Sidebar Footer / User Profile Summary --}}
            <div class="p-3 border-top border-dark border-opacity-50">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center gap-2 py-2">
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
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none d-flex align-items-center justify-content-center p-2 rounded-3 border" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <div class="d-none d-md-block">
                        <h5 class="fw-bold mb-0 text-dark">@yield('page-title', 'Admin Portal')</h5>
                    </div>

                    {{-- Search Input Box --}}
                    <div class="search-box d-none d-lg-block ms-3">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Quick search properties...">
                    </div>
                </div>

                {{-- Right: Actions & Theme Toggle & User Dropdown --}}
                <div class="d-flex align-items-center gap-2 gap-md-3">

                    {{-- Quick Front Link --}}
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm d-none d-sm-flex align-items-center gap-1 rounded-3">
                        <i class="bi bi-globe"></i>
                        <span>Live Site</span>
                    </a>

                    {{-- Dark / Light Theme Toggle Button --}}
                    <button class="notification-btn" id="themeToggleBtn" type="button" title="Toggle Theme" onclick="toggleAdminTheme()">
                        <i class="bi bi-sun-fill" id="themeIcon"></i>
                    </button>

                    {{-- Inquiries Notification Dropdown --}}
                    @php
                        $adminInquiryCount = \App\Models\BuyerInquiry::count();
                    @endphp
                    <div class="dropdown">
                        <button class="notification-btn position-relative" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false" title="Client Inquiries">
                            <i class="bi bi-chat-left-dots"></i>
                            @if ($adminInquiryCount > 0)
                                <span class="notification-badge">
                                    {{ $adminInquiryCount > 99 ? '99+' : $adminInquiryCount }}
                                </span>
                            @endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border mt-2 rounded-3 p-0"
                            style="min-width: 290px;">
                            <li class="px-3 py-2.5 border-bottom d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-dark d-flex align-items-center gap-1.5">
                                    <i class="bi bi-chat-left-text text-primary"></i> Client Inquiries
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $adminInquiryCount }} total</span>
                            </li>
                            <li class="p-3 text-center">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                        style="width: 44px; height: 44px;">
                                        <i class="bi bi-chat-dots-fill fs-5"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-1 text-dark">
                                    {{ $adminInquiryCount }} Inquir{{ $adminInquiryCount === 1 ? 'y' : 'ies' }} Received
                                </h6>
                                <p class="text-muted small mb-3">Manage messages and inquiries from interested buyers.</p>
                                <a href="{{ route('admin.inquiries') }}" class="btn btn-primary btn-sm w-100 rounded-2 fw-medium">
                                    <i class="bi bi-arrow-right-circle me-1"></i> View All Inquiries
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="vr mx-1 d-none d-sm-block"></div>

                    {{-- User Dropdown Profile --}}
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block text-start lh-sm">
                                <span class="fw-semibold d-block text-dark small">{{ auth()->user()->name ?? 'Administrator' }}</span>
                                <span class="text-muted" style="font-size: 0.75rem;">Super Admin</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border mt-2 rounded-3">
                            <li class="px-3 py-2 border-bottom">
                                <p class="mb-0 fw-semibold text-dark">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <small class="text-muted text-truncate d-block">{{ auth()->user()->email ?? 'admin@estatepro.com' }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('admin.profile.index') }}">
                                    <i class="bi bi-person text-muted"></i> Profile Settings
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('properties.index') }}">
                                    <i class="bi bi-houses text-muted"></i> Properties
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
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
                    {{-- DEFAULT DASHBOARD HOME VIEW --}}
                    <div class="container-fluid p-0">

                        {{-- Welcome Banner --}}
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                            <div>
                                <h3 class="fw-bold text-dark mb-1">Dashboard Overview</h3>
                                <p class="text-muted mb-0">Welcome back, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>! Here is what's happening with your properties today.</p>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('properties.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 shadow-sm rounded-3">
                                    <i class="bi bi-plus-lg"></i>
                                    <span>Add Property</span>
                                </a>
                            </div>
                        </div>

                        {{-- Alert Notifications --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                <div>{{ session('success') }}</div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- 4 KEY METRIC CARDS --}}
                        <div class="row g-3 mb-4">

                            {{-- Card 1: Total Properties --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Total Properties</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">{{ $totalProperties ?? 0 }}</h3>
                                        </div>
                                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="badge bg-success-subtle text-success fw-semibold">
                                            <i class="bi bi-arrow-up"></i> Active
                                        </span>
                                        <span class="ms-1">In your inventory</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 2: Active Listings --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Active Listings</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">{{ $activeProperties ?? 0 }}</h3>
                                        </div>
                                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check2-circle"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="text-success fw-semibold">Published</span>
                                        <span class="ms-1">on live website</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 3: Featured Listings --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Featured</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">{{ $featuredProperties ?? 0 }}</h3>
                                        </div>
                                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                            <i class="bi bi-star"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="badge bg-warning-subtle text-warning fw-semibold">High Priority</span>
                                        <span class="ms-1">Highlighted</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card 4: Registered Users --}}
                            <div class="col-12 col-sm-6 col-xl-3">
                                <div class="stat-card p-3 p-md-4 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="text-muted fw-semibold small text-uppercase">Total Users</span>
                                            <h3 class="fw-bold text-dark mt-2 mb-0">{{ $totalUsers ?? 1 }}</h3>
                                        </div>
                                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                                            <i class="bi bi-people"></i>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-1 small text-muted">
                                        <span class="text-primary fw-semibold">Platform</span>
                                        <span class="ms-1">Registered accounts</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- MAIN DASHBOARD ROW: RECENT PROPERTIES & QUICK ACTIONS --}}
                        <div class="row g-4">

                            {{-- Recent Properties List --}}
                            <div class="col-12 col-xl-8">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header border-bottom py-3 d-flex align-items-center justify-content-between">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">Recent Property Listings</h6>
                                            <small class="text-muted">Latest listings added to the platform</small>
                                        </div>
                                        <a href="{{ route('properties.index') }}" class="btn btn-outline-primary btn-sm rounded-3">
                                            View All
                                        </a>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="ps-3">Property</th>
                                                        <th>Type</th>
                                                        <th>Price</th>
                                                        <th>Status</th>
                                                        <th class="text-end pe-3">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($recentProperties) && $recentProperties->count() > 0)
                                                        @foreach($recentProperties as $property)
                                                            <tr>
                                                                <td class="ps-3">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        @if($property->images && $property->images->first())
                                                                            <img src="{{ asset('storage/' . $property->images->first()->image) }}" alt="{{ $property->title }}" class="rounded-3" width="48" height="48" style="object-fit: cover;">
                                                                        @else
                                                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width:48px; height:48px;">
                                                                                <i class="bi bi-house fs-5"></i>
                                                                            </div>
                                                                        @endif
                                                                        <div>
                                                                            <div class="fw-semibold text-dark text-truncate" style="max-width: 220px;">{{ $property->title }}</div>
                                                                            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $property->city ?? $property->location ?? 'N/A' }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-light text-dark border">{{ $property->property_type }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="fw-bold text-dark">Rs. {{ number_format($property->price) }}</span>
                                                                </td>
                                                                <td>
                                                                    @if($property->status == 'active')
                                                                        <span class="badge badge-soft-success rounded-pill px-2 py-1">Active</span>
                                                                    @elseif($property->status == 'pending')
                                                                        <span class="badge badge-soft-warning rounded-pill px-2 py-1">Pending</span>
                                                                    @elseif($property->status == 'sold')
                                                                        <span class="badge badge-soft-danger rounded-pill px-2 py-1">Sold</span>
                                                                    @else
                                                                        <span class="badge bg-secondary rounded-pill px-2 py-1">{{ ucfirst($property->status) }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end pe-3">
                                                                    <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-light btn-sm text-primary rounded-2 border">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" class="text-center py-5">
                                                                <div class="text-muted mb-2"><i class="bi bi-house-slash fs-1"></i></div>
                                                                <h6 class="fw-bold text-dark">No Properties Added Yet</h6>
                                                                <p class="text-muted small mb-3">Get started by creating your first property listing.</p>
                                                                <a href="{{ route('properties.create') }}" class="btn btn-primary btn-sm rounded-3 px-3">
                                                                    <i class="bi bi-plus-lg"></i> Add First Property
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

                            {{-- Quick Actions & System Info Widget --}}
                            <div class="col-12 col-xl-4">

                                {{-- Quick Actions Card --}}
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header border-bottom py-3">
                                        <h6 class="fw-bold text-dark mb-0">Quick Actions</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('properties.create') }}" class="btn btn-primary d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-white bg-opacity-25 rounded-2 p-2 d-flex">
                                                        <i class="bi bi-plus-circle fs-5"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-white">Create New Listing</div>
                                                        <small class="text-white-50">Add houses, plots, flats</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-white"></i>
                                            </a>

                                            <a href="{{ route('properties.index') }}" class="btn btn-light border d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-2 p-2 d-flex">
                                                        <i class="bi bi-houses fs-5"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-dark">Manage Listings</div>
                                                        <small class="text-muted">Edit, update status, delete</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </a>

                                            <a href="{{ route('home') }}" target="_blank" class="btn btn-light border d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-success bg-opacity-10 text-success rounded-2 p-2 d-flex">
                                                        <i class="bi bi-box-arrow-up-right fs-5"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div class="fw-bold text-dark">Live Website Preview</div>
                                                        <small class="text-muted">View visitor experience</small>
                                                    </div>
                                                </div>
                                                <i class="bi bi-chevron-right text-muted"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- System Status Card --}}
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header border-bottom py-3">
                                        <h6 class="fw-bold text-dark mb-0">System Status</h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="text-muted small">Application Status</span>
                                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1"><i class="bi bi-check-circle-fill me-1"></i> Operational</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="text-muted small">PHP Version</span>
                                            <span class="badge bg-light text-dark border">{{ PHP_VERSION }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                            <span class="text-muted small">Framework</span>
                                            <span class="badge bg-light text-dark border">Laravel {{ app()->version() }}</span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between py-2">
                                            <span class="text-muted small">Database</span>
                                            <span class="badge bg-light text-dark border">SQLite Connected</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                @endif

            </main>

            {{-- FOOTER --}}
            <footer class="mt-auto py-3 px-4 text-center text-md-start d-md-flex align-items-center justify-content-between text-muted small">
                <div>
                    &copy; {{ date('Y') }} <strong>EstatePro</strong>. All rights reserved.
                </div>
                <div class="mt-2 mt-md-0">
                    <span>Designed for Real Estate Management</span>
                </div>
            </footer>

        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dark / Light Mode Script -->
    <script>
        function updateThemeUI(theme) {
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            if (themeIcon) {
                if (theme === 'dark') {
                    themeIcon.className = 'bi bi-sun-fill';
                    if (themeToggleBtn) themeToggleBtn.setAttribute('title', 'Switch to Light Mode');
                } else {
                    themeIcon.className = 'bi bi-moon-stars-fill';
                    if (themeToggleBtn) themeToggleBtn.setAttribute('title', 'Switch to Dark Mode');
                }
            }
        }

        function applyAdminTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('estatepro_admin_theme', theme);
            updateThemeUI(theme);
        }

        function toggleAdminTheme() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyAdminTheme(newTheme);
        }

        // Initialize immediately & attach fallback listener
        (function initAdminTheme() {
            const savedTheme = localStorage.getItem('estatepro_admin_theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function () {
                    updateThemeUI(savedTheme);
                });
            } else {
                updateThemeUI(savedTheme);
            }
        })();
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-agent-btn').forEach(button => {

        button.addEventListener('click', function () {

            const form = this.closest('.delete-agent-form');

            Swal.fire({
                title: 'Delete Agent?',
                text: 'Are you sure you want to delete this agent?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });
</script>
</body>

</html>

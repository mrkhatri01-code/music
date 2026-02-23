<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Nepali Lyrics</title>

    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $mimeType = 'image/x-icon';
        if ($siteLogo && file_exists(public_path($siteLogo))) {
            $faviconUrl = asset($siteLogo) . '?v=' . filemtime(public_path($siteLogo));
            $ext = pathinfo(public_path($siteLogo), PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                $mimeType = 'image/' . (strtolower($ext) === 'jpg' ? 'jpeg' : strtolower($ext));
            }
        } else {
            $faviconUrl = asset('favicon.ico');
        }
    @endphp
    <link rel="icon" type="{{ $mimeType }}" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            /* Colors - Neutrals */
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-border: #e5e7eb;
            --color-divider: #f3f4f6;

            /* Colors - Text */
            --color-text-primary: #111827;
            --color-text-secondary: #6b7280;
            --color-text-muted: #9ca3af;

            /* Colors - Brand */
            --color-primary: #2563eb;
            --color-primary-hover: #1d4ed8;
            --color-accent: #7c3aed;

            /* Colors - Feedback */
            --color-success: #059669;
            --color-success-bg: #d1fae5;
            --color-warning: #d97706;
            --color-error: #dc2626;
            --color-error-bg: #fee2e2;

            /* Typography */
            --font-size-h1: 1.875rem;
            --font-size-h2: 1.5rem;
            --font-size-h3: 1.125rem;
            --font-size-base: 1rem;
            --font-size-sm: 0.875rem;
            --font-size-xs: 0.75rem;

            --line-height-tight: 1.25;
            --line-height-normal: 1.5;
            --line-height-relaxed: 1.75;

            --font-weight-normal: 400;
            --font-weight-medium: 500;
            --font-weight-semibold: 600;
            --font-weight-bold: 700;

            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-12: 3rem;

            /* Layout */
            --sidebar-width: 260px;
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 12px;

            /* Modern Shadows - Multi-layered */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 25px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07), 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 30px 60px rgba(0, 0, 0, 0.12);

            /* Gradients */
            --gradient-sidebar: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(90deg, #667eea 0%, #7c3aed 100%);

            /* Animation Timings */
            --transition-fast: 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg);
            color: var(--color-text-primary);
            line-height: var(--line-height-normal);
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - Modern */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar-header {
            padding: var(--space-6);
            background: var(--gradient-sidebar);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: var(--font-size-h3);
            color: white;
            font-weight: var(--font-weight-bold);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .sidebar-header h2 i {
            font-size: 1.25rem;
        }

        .sidebar-header p {
            font-size: var(--font-size-xs);
            color: rgba(255, 255, 255, 0.8);
            margin-top: var(--space-1);
        }

        .sidebar-menu {
            list-style: none;
            padding: var(--space-4) 0;
        }

        .sidebar-menu li {
            margin-bottom: var(--space-1);
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-6);
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.2s;
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-medium);
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 3px solid var(--color-primary);
        }

        .sidebar-menu form {
            margin: 0;
        }

        .sidebar-menu form button {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-6);
            background: none;
            border: none;
            color: #cbd5e0;
            cursor: pointer;
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-medium);
            font-family: inherit;
            width: 100%;
            text-align: left;
            transition: all 0.2s;
        }

        .sidebar-menu form button i {
            width: 20px;
            text-align: center;
        }

        .sidebar-menu form button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Sidebar Submenu */
        .sidebar-dropdown {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-submenu {
            display: none;
            padding-left: var(--space-8);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-submenu.show {
            display: block;
        }

        .sidebar-submenu li {
            margin-bottom: 0;
        }

        .sidebar-submenu a {
            padding: var(--space-2) var(--space-6) var(--space-2) 0;
            font-size: 0.8rem;
        }

        .sidebar-dropdown .fa-chevron-down {
            font-size: 0.75rem;
            transition: transform 0.2s;
        }

        .sidebar-dropdown.active .fa-chevron-down {
            transform: rotate(180deg);
        }

        /* Main Content - Modern */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: var(--space-8);
            max-width: 100%;
            background: linear-gradient(to bottom, var(--color-bg) 0%, #ffffff 100%);
        }

        .page-header {
            margin-bottom: var(--space-8);
        }

        .page-header h1 {
            font-size: var(--font-size-h1);
            color: var(--color-text-primary);
            margin-bottom: var(--space-2);
            font-weight: var(--font-weight-bold);
        }

        .page-header p {
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
        }

        /* Alerts */
        .alert {
            padding: var(--space-4) var(--space-6);
            border-radius: var(--radius-sm);
            margin-bottom: var(--space-6);
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .alert i {
            font-size: 1.25rem;
        }

        .alert-success {
            background: var(--color-success-bg);
            color: #065f46;
            border-color: var(--color-success);
        }

        .alert-error {
            background: var(--color-error-bg);
            color: #991b1b;
            border-color: var(--color-error);
        }

        /* Card */
        .card {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: var(--space-6);
            margin-bottom: var(--space-6);
            border: 1px solid var(--color-border);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--space-4);
        }

        .card-header h2 {
            font-size: var(--font-size-h3);
            font-weight: var(--font-weight-semibold);
            color: var(--color-text-primary);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: var(--color-divider);
        }

        table th {
            padding: var(--space-4);
            text-align: left;
            font-weight: var(--font-weight-semibold);
            color: var(--color-text-secondary);
            border-bottom: 2px solid var(--color-border);
            font-size: var(--font-size-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: var(--space-4);
            border-bottom: 1px solid var(--color-border);
            font-size: var(--font-size-sm);
        }

        table tr:hover {
            background: var(--color-divider);
        }

        table tr:last-child td {
            border-bottom: none;
        }

        .empty-table {
            text-align: center;
            padding: var(--space-12);
            color: var(--color-text-muted);
        }

        .empty-table i {
            font-size: 3rem;
            opacity: 0.3;
            margin-bottom: var(--space-4);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: var(--font-weight-semibold);
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-size: var(--font-size-sm);
        }

        .btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-success {
            background: var(--color-success);
            color: white;
        }

        .btn-success:hover {
            background: #047857;
        }

        .btn-danger {
            background: var(--color-error);
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-sm {
            padding: var(--space-2) var(--space-4);
            font-size: var(--font-size-xs);
        }

        /* Form */
        .form-group {
            margin-bottom: var(--space-6);
        }

        .form-group label {
            display: block;
            margin-bottom: var(--space-2);
            font-weight: var(--font-weight-medium);
            color: var(--color-text-primary);
            font-size: var(--font-size-sm);
        }

        .form-control {
            width: 100%;
            padding: var(--space-3);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-size: var(--font-size-sm);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-weight: var(--font-weight-normal);
        }

        .checkbox-label input {
            width: auto;
        }

        /* Stats Grid - Modern */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .stat-card {
            background: var(--color-surface);
            padding: var(--space-6);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--color-border);
            transition: all var(--transition-base);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .stat-card h3 {
            font-size: var(--font-size-xs);
            color: var(--color-text-secondary);
            margin-bottom: var(--space-2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: var(--font-weight-semibold);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: var(--font-weight-bold);
            color: var(--color-text-primary);
        }

        .stat-card .stat-value.success {
            color: var(--color-success);
        }

        /* Pagination */
        /* Pagination Support */
        nav[role="navigation"] {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        /* Hide mobile pagination controls on desktop */
        nav[role="navigation"]>div:first-child {
            display: none;
        }

        /* Desktop Layout */
        nav[role="navigation"]>div:last-child {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 1rem;
        }

        /* Showing results text */
        nav[role="navigation"] p.small {
            margin: 0;
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
        }

        /* Pagination List Reset */
        ul.pagination {
            display: flex;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            gap: var(--space-2);
        }

        /* Page Items */
        li.page-item {
            margin: 0;
            padding: 0;
        }

        /* Links styling matching theme */
        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-2) var(--space-3);
            min-width: 32px;
            height: 32px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-medium);
            background: var(--color-surface);
            transition: all 0.2s;
        }

        .page-item.active .page-link {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .page-item.disabled .page-link {
            color: var(--color-text-muted);
            pointer-events: none;
            background: var(--color-bg);
            opacity: 0.6;
        }

        .page-link:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
            text-decoration: none;
        }

        /* Responsive Pagination */
        @media (max-width: 640px) {
            nav[role="navigation"]>div:first-child {
                display: flex;
                justify-content: space-between;
                width: 100%;
                margin-bottom: 1rem;
            }

            nav[role="navigation"]>div:last-child {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            nav[role="navigation"]>div:last-child>div:first-child {
                display: none;
                /* Hide 'Showing results' on very small screens to save space */
            }
        }

        /* Select2 Customization - Admin */
        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 0.5rem;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-size: var(--font-size-sm);
            font-family: inherit;
            background-color: var(--color-surface);
            transition: all 0.2s;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            color: var(--color-text-primary);
            padding-left: 0.25rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 10px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db;
            /* A slightly darker border for dropdown */
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-lg);
            font-size: var(--font-size-sm);
            font-family: inherit;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: var(--color-primary);
            color: white;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--color-border);
            border-radius: 4px;
            padding: 6px;
            font-family: inherit;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
                padding: var(--space-4);
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ========== MODERN DASHBOARD ENHANCEMENTS ========== */

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Modern Stats Grid */
        .stats-grid-modern {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card-modern {
            position: relative;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            color: white;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .stat-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .stat-card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card-modern .stat-icon {
            font-size: 2.5rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .stat-card-modern .stat-content {
            position: relative;
            z-index: 1;
        }

        .stat-card-modern .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            opacity: 0.95;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-modern .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
        }

        /* Modern Card */
        .card-modern {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: box-shadow 0.3s;
        }

        .card-modern:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .card-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--color-divider);
        }

        .card-header-modern h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--color-text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .card-header-modern h2 i {
            color: var(--color-primary);
        }

        .view-all-link {
            color: var(--color-primary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.2s;
        }

        .view-all-link:hover {
            gap: 0.5rem;
        }

        .table-container {
            overflow-x: auto;
        }

        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead {
            background: #f9fafb;
        }

        .modern-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--color-text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--color-divider);
        }

        .modern-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-divider);
            font-size: 0.875rem;
        }

        .modern-table tbody tr {
            transition: background-color 0.15s;
        }

        .modern-table tbody tr:hover {
            background: #f9fafb;
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
        }

        .badge i {
            font-size: 0.7rem;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        /* Rank Badge */
        .rank-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.875rem;
            background: var(--color-divider);
            color: var(--color-text-secondary);
        }

        .rank-badge.rank-1 {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #92400e;
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        .rank-badge.rank-2 {
            background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
            color: #4a5568;
            box-shadow: 0 2px 8px rgba(192, 192, 192, 0.3);
        }

        .rank-badge.rank-3 {
            background: linear-gradient(135deg, #cd7f32 0%, #e9a768 100%);
            color: #744210;
            box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
        }

        /* Empty State */
        .empty-state-table {
            text-align: center !important;
            padding: 3rem 1rem !important;
            color: var(--color-text-muted);
        }

        .empty-state-table i {
            font-size: 2.5rem;
            opacity: 0.3;
            display: block;
            margin-bottom: 0.75rem;
        }

        .empty-state-table p {
            margin: 0;
            font-size: 0.875rem;
        }

        /* Modern Page Header */
        .page-header-modern {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Mini Stat Cards (for list pages) */
        .stat-mini-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .stat-mini-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-mini-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .stat-mini-label {
            font-size: 0.75rem;
            color: var(--color-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .stat-mini-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-text-primary);
            line-height: 1;
        }

        /* Icon Buttons */
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-icon:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                @php
                    $siteLogo = \App\Models\SiteSetting::get('site_logo');
                    $siteName = \App\Models\SiteSetting::get('site_name', 'Music App Backend');
                    
                    $findAdminAsset = function($filename) {
                        $paths = [public_path($filename), base_path('public/' . $filename), base_path($filename)];
                        foreach ($paths as $path) {
                            if ($path && file_exists($path)) return ['path' => $path, 'version' => @filemtime($path)];
                        }
                        return ['path' => null, 'version' => time()];
                    };

                    $favicon = $findAdminAsset('favicon.ico');
                    if (!$favicon['path']) {
                        $logoAsset = $findAdminAsset($siteLogo);
                        $faviconUrl = $logoAsset['path'] ? asset($siteLogo) . '?v=' . $logoAsset['version'] : asset('favicon.ico');
                    } else {
                        $faviconUrl = asset('favicon.ico') . '?v=' . $favicon['version'];
                    }
                @endphp
                <h2>
                    @if($siteLogo)
                        @php
                            $logoInfo = $findAdminAsset($siteLogo);
                        @endphp
                        <img src="{{ asset($siteLogo) . '?v=' . ($logoInfo['version'] ?? time()) }}" alt="{{ $siteName }}"
                            style="height: 40px; margin-right: 0.5rem; border-radius: 4px;">
                    @else
                        <i class="fa-solid fa-music"></i>
                    @endif
                    <span style="font-size: 1.25rem;">{{ $siteName }}</span>
                </h2>
                <p>Content Management</p>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-gauge"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.songs.index') }}"
                        class="{{ request()->routeIs('admin.songs.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-music"></i>
                        Songs
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.artists.index') }}"
                        class="{{ request()->routeIs('admin.artists.*') || request()->routeIs('admin.artist-requests.*') || request()->routeIs('admin.password-requests.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-microphone"></i>
                        Artists
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.albums.index') }}"
                        class="{{ request()->routeIs('admin.albums.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-compact-disc"></i>
                        Albums
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.movies.index') }}"
                        class="{{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-clapperboard"></i>
                        Movies
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.subscriptions.index') }}"
                        class="{{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-bell"></i>
                        Subscriptions
                        @if(\App\Models\SongSubscription::where('status', 'pending')->count() > 0)
                            <span class="badge badge-warning"
                                style="margin-left: auto; font-size: 0.7rem; padding: 2px 6px;">
                                {{ \App\Models\SongSubscription::where('status', 'pending')->count() }}
                            </span>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.visitors.index') }}"
                        class="{{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-earth-americas"></i>
                        Visitors
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.genres.index') }}"
                        class="{{ request()->routeIs('admin.genres.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-guitar"></i>
                        Genres
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}"
                        class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-flag"></i>
                        Reports
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.contacts.index') }}"
                        class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-envelope"></i>
                        Contacts
                    </a>
                </li>
                <li
                    class="{{ request()->routeIs('admin.settings.about') || request()->routeIs('admin.team-members.*') || request()->routeIs('admin.settings.dmca') || request()->routeIs('admin.settings.privacy-policy') || request()->routeIs('admin.settings.disclaimer') ? 'active-group' : '' }}">
                    <a href="#"
                        class="sidebar-dropdown {{ request()->routeIs('admin.settings.about') || request()->routeIs('admin.team-members.*') || request()->routeIs('admin.settings.dmca') || request()->routeIs('admin.settings.privacy-policy') || request()->routeIs('admin.settings.disclaimer') ? 'active' : '' }}"
                        onclick="toggleSubmenu(event, 'about-submenu')">
                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                            <i class="fa-solid fa-address-card"></i>
                            About Us
                        </div>
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul id="about-submenu"
                        class="sidebar-submenu {{ request()->routeIs('admin.settings.about') || request()->routeIs('admin.team-members.*') || request()->routeIs('admin.settings.dmca') || request()->routeIs('admin.settings.privacy-policy') || request()->routeIs('admin.settings.disclaimer') ? 'show' : '' }}">
                        <li>
                            <a href="{{ route('admin.settings.about') }}"
                                class="{{ request()->routeIs('admin.settings.about') ? 'active' : '' }}">
                                <i class="fa-solid fa-file-pen"></i>
                                About Us Content
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.dmca') }}"
                                class="{{ request()->routeIs('admin.settings.dmca') ? 'active' : '' }}">
                                <i class="fa-solid fa-gavel"></i>
                                DMCA Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.privacy-policy') }}"
                                class="{{ request()->routeIs('admin.settings.privacy-policy') ? 'active' : '' }}">
                                <i class="fa-solid fa-user-shield"></i>
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings.disclaimer') }}"
                                class="{{ request()->routeIs('admin.settings.disclaimer') ? 'active' : '' }}">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Disclaimer
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.team-members.index') }}"
                                class="{{ request()->routeIs('admin.team-members.*') ? 'active' : '' }}">
                                <i class="fa-solid fa-users"></i>
                                Team Members
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}"
                        class="{{ request()->routeIs('admin.settings.index') || request()->routeIs('admin.settings.update') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.system.index') }}"
                        class="{{ request()->routeIs('admin.system.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        System
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.ads.index') }}"
                        class="{{ request()->routeIs('admin.ads.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-rectangle-ad"></i>
                        Ad Manager
                    </a>
                </li>
                <li>
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        View Site
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            {{-- Toast notifications now shown via SweetAlert at bottom-right --}}
            {{-- Inline alerts hidden for cleaner UI --}}
            <div style="display: none;">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <ul style="margin-left: var(--space-6); list-style: disc;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

    {{-- jQuery & Select2 Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')

    <script>
        // Check for session flash messages and show SweetAlert Toast (bottom-right)
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif

        // Global Delete Confirmation
        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.method && form.method.toUpperCase() === 'POST') {
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput && methodInput.value === 'DELETE') {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626', // var(--color-error)
                        cancelButtonColor: '#6b7280', // var(--color-text-secondary)
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        focusCancel: true,
                        background: '#ffffff',
                        showClass: {
                            popup: 'swal2-show',
                            backdrop: 'swal2-backdrop-show',
                            icon: 'swal2-icon-show'
                        },
                        hideClass: {
                            popup: 'swal2-hide',
                            backdrop: 'swal2-backdrop-hide',
                            icon: 'swal2-icon-hide'
                        },
                        customClass: {
                            popup: 'rounded-xl shadow-xl',
                            confirmButton: 'px-4 py-2 rounded-lg text-sm font-medium',
                            cancelButton: 'px-4 py-2 rounded-lg text-sm font-medium'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            }
        });

        // Logout Confirmation
        document.getElementById('logoutForm')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;

            Swal.fire({
                title: 'Logout?',
                text: "Are you sure you want to logout from admin panel?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-xl shadow-xl',
                    confirmButton: 'px-4 py-2 rounded-lg text-sm font-medium',
                    cancelButton: 'px-4 py-2 rounded-lg text-sm font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
    <script src="{{ asset('js/admin/transliterate.js') }}"></script>
    <script>
        function toggleSubmenu(e, id) {
            e.preventDefault();
            const submenu = document.getElementById(id);
            const dropdown = e.currentTarget;

            submenu.classList.toggle('show');
            dropdown.classList.toggle('active');
        }

        // Persist Sidebar Scroll Position
        (function () {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                const scrollPos = localStorage.getItem('sidebarScrollPos');
                if (scrollPos) {
                    sidebar.style.scrollBehavior = 'auto'; // Disable smooth scroll if enabled
                    sidebar.scrollTop = parseInt(scrollPos, 10);
                    sidebar.style.removeProperty('scroll-behavior'); // Revert
                }

                window.addEventListener('beforeunload', function () {
                    localStorage.setItem('sidebarScrollPos', sidebar.scrollTop);
                });
            }
        })();
    </script>
</body>

</html>
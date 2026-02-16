@php
    $mimeType = 'image/x-icon';
    // Use shared variable $siteLogo if available
    $currentSiteLogo = $siteLogo ?? null;

    if ($currentSiteLogo && file_exists(public_path($currentSiteLogo))) {
        $faviconUrl = asset($currentSiteLogo) . '?v=' . filemtime(public_path($currentSiteLogo));
        $ext = pathinfo(public_path($currentSiteLogo), PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
            $mimeType = 'image/' . (strtolower($ext) === 'jpg' ? 'jpeg' : strtolower($ext));
        }
    } else {
        $faviconUrl = file_exists(public_path('favicon.ico')) ? asset('favicon.ico') : asset('images/logo.png');
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    {{-- SEO Meta Tags --}}
    <title>@yield('title')@unless(View::hasSection('hide_site_name')) | {{ $siteName }}@endunless</title>
    <meta name="description"
        content="@yield('description', 'Read and download latest Nepali songs lyrics in Unicode and Romanized format. Trending songs, new releases, and complete lyrics collection.')">
    <meta name="keywords" content="@yield('keywords', 'nepali lyrics, nepali songs, lyrics unicode, romanized lyrics')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- OpenGraph Tags --}}
    {{-- OpenGraph Tags --}}


    <meta property="og:title" content="@yield('og_title', $siteName)">
    <meta property="og:description" content="@yield('og_description', 'Latest Nepali Songs Lyrics')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', $siteLogo ? asset($siteLogo) : asset('images/logo.png'))">
    <link rel="icon" type="{{ $mimeType }}" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    {{-- Structured Data --}}
    @stack('structured-data')

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Styles --}}
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
            --color-gradient-start: #667eea;
            --color-gradient-end: #764ba2;

            /* Colors - Feedback */
            --color-success: #059669;
            --color-warning: #d97706;
            --color-error: #dc2626;

            /* Modern Gradients */
            --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --gradient-card: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-accent: linear-gradient(90deg, #667eea 0%, #7c3aed 100%);

            /* Typography - Sizes */
            --font-size-h1: 3.5rem;
            --font-size-h2: 2.25rem;
            --font-size-h3: 1.5rem;
            --font-size-base: 1rem;
            --font-size-sm: 0.875rem;
            --font-size-xs: 0.75rem;

            /* Typography - Line Heights */
            --line-height-tight: 1.25;
            --line-height-normal: 1.5;
            --line-height-relaxed: 1.75;
            --line-height-lyrics: 2;

            /* Typography - Weights */
            --font-weight-normal: 400;
            --font-weight-medium: 500;
            --font-weight-semibold: 600;
            --font-weight-bold: 700;
            --font-weight-extrabold: 800;

            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            --space-24: 6rem;

            /* Layout */
            --container-width: 1140px;
            --container-padding: 1.5rem;

            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;

            /* Modern Shadows - Multi-layered for depth */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 25px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07), 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1), 0 30px 60px rgba(0, 0, 0, 0.12);
            --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1), 0 40px 80px rgba(0, 0, 0, 0.15);

            /* Glassmorphism */
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(255, 255, 255, 0.18);

            /* Animation Timings */
            --transition-fast: 0.15s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-base: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg);
            color: var(--color-text-primary);
            line-height: var(--line-height-normal);
            font-size: var(--font-size-base);
            overflow-x: hidden;
        }

        .nepali-text {
            font-family: 'Noto Sans Devanagari', 'Poppins', sans-serif;
        }

        /* Hide bottom nav by default (Desktop) */
        .bottom-nav {
            display: none;
        }

        .search-overlay {
            display: none;
        }

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }

        /* Header - Glassmorphism */
        header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
        }



        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--space-4);
            padding-bottom: var(--space-4);
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: var(--font-weight-bold);
            color: var(--color-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            transition: transform 0.2s;
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo i {
            font-size: 1.75rem;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: var(--space-8);
            align-items: center;
        }

        nav a {
            color: var(--color-text-secondary);
            text-decoration: none;
            font-weight: var(--font-weight-semibold);
            font-size: var(--font-size-sm);
            transition: all var(--transition-base);
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-accent);
            transition: width var(--transition-base);
        }

        nav a:not(.btn):hover {
            color: var(--color-primary);
            transform: translateY(-1px);
        }

        nav a:not(.btn):hover::after {
            width: 100%;
        }

        /* Mobile Search Toggle (Hidden on Desktop) */
        .mobile-search-toggle {
            display: none;
        }

        /* Desktop Search Bar */
        .desktop-search {
            flex: 1;
            max-width: 350px;
            margin: 0 2rem;
            position: relative;
        }

        .desktop-search form {
            width: 100%;
            display: flex;
            align-items: center;
        }

        .desktop-search input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.8rem;
            border-radius: 99px;
            border: 1px solid transparent;
            background: #f1f5f9;
            font-size: 0.95rem;
            color: var(--color-text-primary);
            transition: all 0.3s ease;
        }

        .desktop-search input:focus {
            background: white;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .desktop-search button {
            position: absolute;
            left: 12px;
            background: none;
            border: none;
            color: #a0aec0;
            font-size: 1rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .desktop-search input:focus+button {
            color: var(--color-primary);
        }

        /* Mobile Menu Toggle (Hamburger) */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            z-index: 1001;
            margin-left: auto;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: var(--color-text-primary);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(7px, 7px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Mobile Navigation Header */
        .mobile-nav-header {
            display: none;
        }

        .mobile-close-btn {
            display: none;
        }

        /* Mobile Navigation Styles */
        @media (max-width: 768px) {

            /* Hide Desktop/Old Mobile Elements */
            #mainNav,
            .mobile-overlay,
            .desktop-search {
                display: none !important;
            }

            /* Header Layout: Logo Left, Search Right */
            header .container {
                justify-content: space-between !important;
                padding: 0 1rem;
            }

            /* Mobile Search Toggle Button */
            .mobile-search-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #f7fafc;
                border: none;
                color: #4a5568;
                font-size: 1.2rem;
                cursor: pointer;
                transition: background 0.2s;
            }

            .mobile-search-toggle:hover {
                background: #edf2f7;
                color: var(--color-primary);
            }

            /* Full Screen Search Overlay */
            .search-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: white;
                z-index: 2000;
                display: flex;
                flex-direction: column;
                padding: 1rem;
                opacity: 0;
                visibility: hidden;
                transition: all 0.2s ease;
                transform: translateY(-10px);
            }

            .search-overlay.active {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .close-search {
                align-self: flex-end;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: #718096;
                padding: 0.5rem;
                cursor: pointer;
                margin-bottom: 1rem;
            }

            .mobile-search-form {
                display: flex;
                border-bottom: 2px solid var(--color-primary);
                padding-bottom: 0.5rem;
                width: 100%;
            }

            .mobile-search-form input {
                flex: 1;
                border: none;
                font-size: 1.2rem;
                outline: none;
                padding: 0.5rem;
            }

            .mobile-search-form button {
                background: none;
                border: none;
                font-size: 1.2rem;
                color: var(--color-primary);
            }

            .search-suggestions {
                margin-top: 2rem;
                color: #718096;
                font-size: 0.95rem;
            }

            .search-suggestions a {
                color: var(--color-primary);
                text-decoration: none;
                margin: 0 0.2rem;
            }

            /* Prevent content behind fixed nav */
            body {
                padding-bottom: 80px;
            }

            /* Bottom Navigation Bar */
            .bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 65px;
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                display: flex;
                justify-content: space-around;
                align-items: center;
                border-top: 1px solid var(--glass-border);
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.04);
                z-index: 1000;
            }

            .nav-item {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                color: var(--color-text-secondary);
                font-size: 11px;
                padding: 4px 0;
                height: 100%;
                background: none;
                border: none;
                cursor: pointer;
                position: relative;
            }

            .nav-item i {
                font-size: 20px;
                margin-bottom: 4px;
                transition: transform 0.2s;
            }

            .nav-item.active {
                color: var(--color-primary);
                font-weight: 600;
            }

            .nav-item.active i {
                transform: translateY(-2px);
            }

            /* More Dropdown */
            .more-menu {
                position: absolute;
                bottom: 70px;
                right: 16px;
                background: var(--color-surface);
                border-radius: var(--radius-lg);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                padding: 8px 0;
                width: 160px;
                display: none;
                z-index: 1001;
                text-align: left;
                border: 1px solid var(--color-border);
            }

            .more-menu::after {
                content: '';
                position: absolute;
                bottom: -6px;
                right: 24px;
                width: 12px;
                height: 12px;
                background: var(--color-surface);
                transform: rotate(45deg);
                border-right: 1px solid var(--color-border);
                border-bottom: 1px solid var(--color-border);
            }

            .more-menu a {
                display: block;
                padding: 12px 20px;
                text-decoration: none;
                color: var(--color-text-primary);
                font-size: 14px;
                border-bottom: 1px solid var(--color-divider);
            }

            .more-menu a:last-child {
                border-bottom: none;
            }

            .more-menu a:hover {
                background: var(--color-bg);
                color: var(--color-primary);
            }

            .more-menu.show {
                display: block;
                animation: slideUp 0.2s ease forwards;
            }

            @keyframes slideUp {
                from {
                    transform: translateY(10px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            /* Adjustments */




            /* Mobile Hero Section */
            .search-container {
                min-height: 320px;
                padding: 3rem 0 2rem;
            }

            .search-header h1 {
                font-size: 1.75rem;
            }

            .search-header p {
                font-size: 0.95rem;
            }

            /* Mobile Content Spacing */
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            /* Mobile Song Cards */
            .song-card,
            .artist-card,
            .album-card {
                flex-direction: column;
                text-align: center;
            }

            /* Mobile Grid Adjustments */
            .song-grid,
            .artist-grid,
            .album-grid {
                grid-template-columns: 1fr !important;
            }

            /* Mobile Tables */
            .song-list {
                font-size: 0.9rem;
            }

            .song-list th,
            .song-list td {
                padding: 0.75rem 0.5rem;
            }

            /* Mobile Footer */
            footer {
                display: none;
                /* Hidden by default on mobile */
                padding: 1.5rem 0 100px;
                /* Reduced padding */
                margin-top: 1rem;
                text-align: left;
                position: relative;
                z-index: 1;
            }

            footer.active-mobile {
                display: block !important;
                animation: fadeIn 0.5s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .footer-content {
                grid-template-columns: 1fr 1fr !important;
                /* Force 2 Columns override global */
                gap: 1rem 0.5rem;
            }

            /* Brand Section (First) - Full Width */
            .footer-section:first-child {
                grid-column: 1 / -1;
                text-align: center;
                margin-bottom: 0;
            }

            /* Hide Description Text for Compactness */
            .footer-section p {
                display: none;
            }

            .footer-section h3 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
                color: var(--color-text-primary);
            }

            .footer-section li {
                margin-bottom: 0.25rem;
            }

            .footer-section a {
                font-size: 0.85rem;
                color: var(--color-text-secondary);
            }


            .footer-bottom {
                padding: 0.75rem 0.5rem;
                padding-bottom: 90px;
                /* Extra space for mobile bottom nav */
                background: rgba(0, 0, 0, 0.2);
                margin: 0 -1rem;
                /* Full width */
                font-size: 0.75rem;
                color: #ffffff !important;
                display: block !important;
                opacity: 1 !important;
                text-align: center;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }
        }

        /* Search Hero - Modern Gradient */
        .search-container {
            background: var(--gradient-hero);
            padding: var(--space-20) 0;
            position: relative;
            overflow: hidden;
            min-height: 420px;
            display: flex;
            align-items: center;
        }

        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.05) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .search-container .container {
            position: relative;
            z-index: 1;
        }

        .search-header {
            text-align: center;
            margin-bottom: var(--space-8);
        }

        .search-header h1 {
            font-size: var(--font-size-h1);
            color: white;
            margin-bottom: var(--space-3);
            font-weight: var(--font-weight-extrabold);
            letter-spacing: -0.02em;
            line-height: var(--line-height-tight);
        }

        .search-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.05rem;
        }

        .search-form {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
        }

        .search-form input {
            width: 100%;
            padding: var(--space-4) var(--space-6);
            padding-right: 140px;
            font-size: 1.05rem;
            border: none;
            border-radius: var(--radius-lg);
            outline: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            transition: box-shadow 0.3s;
        }

        .search-form input:focus {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .search-form button {
            position: absolute;
            right: var(--space-2);
            top: 50%;
            transform: translateY(-50%);
            background: var(--color-primary);
            color: white;
            border: none;
            padding: var(--space-3) var(--space-8);
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-weight: var(--font-weight-semibold);
            transition: all 0.3s;
        }

        .search-form button:hover {
            background: var(--color-primary-hover);
            transform: translateY(-50%) scale(1.05);
        }

        /* Main Content */
        main {
            padding: var(--space-12) 0;
            min-height: calc(100vh - 400px);
        }

        /* Section */
        .section {
            margin-bottom: var(--space-20);
        }

        .section-divider {
            height: 1px;
            background: var(--color-divider);
            margin: var(--space-12) 0;
        }

        /* Section Heading */
        .section-heading {
            font-size: var(--font-size-h2);
            font-weight: var(--font-weight-bold);
            color: var(--color-text-primary);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .section-heading i {
            color: var(--color-primary);
            font-size: 1.25rem;
        }

        .section-intro {
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
            margin-top: calc(var(--space-2) * -1);
            margin-bottom: var(--space-6);
        }

        /* Card Styles - Modern */
        .card {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            padding: var(--space-6);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-base);
            border: 1px solid var(--color-border);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: rgba(37, 99, 235, 0.2);
        }

        /* Song Card - Enhanced */
        .song-card {
            background: var(--color-surface);
            border-radius: var(--radius-md);
            padding: var(--space-4);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-base);
            border: 1px solid var(--color-border);
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .song-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
            border-color: var(--color-primary);
        }

        .song-title {
            font-size: 1.05rem;
            font-weight: var(--font-weight-semibold);
            color: var(--color-text-primary);
            margin-bottom: var(--space-2);
            line-height: var(--line-height-tight);
        }

        .song-meta {
            color: var(--color-text-secondary);
            font-size: var(--font-size-sm);
            display: flex;
            align-items: center;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .song-meta span {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .song-meta i {
            font-size: 0.85rem;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: var(--space-1) var(--space-3);
            border-radius: 20px;
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-medium);
            gap: var(--space-1);
        }

        .badge-primary {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge i {
            font-size: 0.7rem;
        }

        /* Button */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: var(--font-weight-semibold);
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: var(--font-size-sm);
        }

        .btn-primary {
            background: var(--color-primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
        }

        .btn-outline:hover {
            background: var(--color-primary);
            color: white;
        }

        /* Grid */
        .grid {
            display: grid;
            gap: var(--space-6);
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .grid-4 {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        /* Ad Container */
        .ad-container {
            background: var(--color-divider);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: var(--space-4);
            margin: var(--space-8) 0;
            text-align: center;
        }

        .ad-label {
            font-size: var(--font-size-xs);
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: var(--space-2);
        }

        /* Footer */
        footer {
            background: #1a202c;
            color: white;
            padding: var(--space-12) 0 var(--space-6);
            margin-top: var(--space-16);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-8);
            margin-bottom: var(--space-8);
        }

        .footer-section h3 {
            margin-bottom: var(--space-4);
            color: #fff;
            font-size: var(--font-size-h3);
            font-weight: var(--font-weight-semibold);
        }

        .footer-section p {
            color: #cbd5e0;
            line-height: var(--line-height-relaxed);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section li {
            margin-bottom: var(--space-3);
        }

        .footer-section a {
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .footer-section a:hover {
            color: white;
            transform: translateX(3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: var(--space-8);
            border-top: 1px solid #2d3748;
            color: #a0aec0;
            font-size: var(--font-size-sm);
        }

        /* Alert */
        .alert {
            padding: var(--space-4) var(--space-6);
            border-radius: var(--radius-sm);
            margin-bottom: var(--space-6);
            border-left: 4px solid;
        }

        .alert-info {
            background: #dbeafe;
            border-color: var(--color-primary);
            color: #1e40af;
        }

        .alert-warning {
            background: #fef3c7;
            border-color: var(--color-warning);
            color: #92400e;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: var(--space-16) var(--space-6);
            color: var(--color-text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: var(--space-4);
            opacity: 0.3;
            color: var(--color-text-secondary);
        }

        .empty-state h3 {
            font-size: var(--font-size-h3);
            margin-bottom: var(--space-2);
            color: var(--color-text-secondary);
            font-weight: var(--font-weight-semibold);
        }

        .empty-state p {
            color: var(--color-text-muted);
        }

        /* Responsive */
        @media (max-width: 768px) {
            :root {
                --container-padding: 1rem;
                --space-12: 2rem;
                --space-16: 3rem;
            }



            nav ul {
                gap: var(--space-4);
                flex-wrap: wrap;
                justify-content: center;
            }

            .search-header h1 {
                font-size: 1.75rem;
            }

            .search-form input {
                padding-right: var(--space-6);
            }

            .search-form button {
                position: static;
                transform: none;
                margin-top: var(--space-3);
                width: 100%;
            }

            .section-heading {
                font-size: 1.25rem;
            }

            .grid-2,
            .grid-3,
            .grid-4 {
                grid-template-columns: 1fr;
            }

            .hide-on-mobile {
                display: none !important;
            }
        }

        /* Header Login Button */
        .header-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--color-primary);
            color: white !important;
            padding: 0.6rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
            border: 1px solid transparent;
        }

        .header-login-btn:hover {
            background: var(--color-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2), 0 4px 6px -2px rgba(37, 99, 235, 0.1);
            color: white !important;
        }

        .header-login-btn i {
            font-size: 1rem;
        }
    </style>


</head>

<body>

    {{-- Header --}}
    <header>
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                @if($siteLogo)
                    <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}" style="height: 40px;">
                @else
                    <img src="{{ asset('images/logo.png') }}" alt="{{ $siteName }}" style="height: 40px;">
                @endif
            </a>

            {{-- Desktop Search --}}
            <div class="desktop-search">
                <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="q" placeholder="Search songs, artists..." autocomplete="off">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            {{-- Mobile Search Toggle --}}
            <button class="mobile-search-toggle" onclick="toggleSearch()" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <nav id="mainNav">
                {{-- Mobile Menu Header --}}
                <div class="mobile-nav-header">
                    <a href="{{ route('home') }}" class="mobile-logo">
                        @if($siteLogo)
                            <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}" style="height: 35px;">
                        @else
                            <i class="fa-solid fa-music"></i>
                            <span>{{ $siteName }}</span>
                        @endif
                    </a>
                    <button class="mobile-close-btn" id="mobileCloseBtn" aria-label="Close menu">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('trending') }}">Trending</a></li>
                    <li><a href="{{ route('new') }}">New</a></li>
                    <li><a href="{{ route('artists.top') }}">Artists</a></li>
                    <li><a href="{{ route('album.index') }}">Albums</a></li>
                    <li><a href="{{ route('movie.index') }}">Movies</a></li>
                    <li><a href="{{ route('genre.index') }}">Genres</a></li>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="btn btn-primary"
                                    style="padding: 0.5rem 1rem; color: white;">Admin Panel</a></li>
                        @elseif(auth()->user()->role === 'artist')
                            <li><a href="{{ route('artist.dashboard') }}" class="btn btn-primary"
                                    style="padding: 0.5rem 1rem; color: white;">Dashboard</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.5rem 1rem;">Artist
                                Login</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    {{-- Search Bar (Homepage only) --}}
    @if(request()->is('/'))
        <div class="search-container">
            <div class="container">
                <div class="search-header">
                    <h1>Explore Authentic Nepali Lyrics</h1>
                    <p>Classics, new releases, and viral hits — all in Unicode and Romanized format</p>
                </div>
                <form action="{{ route('search') }}" method="GET" class="search-form">
                    <input type="text" name="q" placeholder="Search for songs, artists..." autocomplete="off"
                        id="searchInput">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success"
                    style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #10b981; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-circle-check" style="margin-right: 0.5rem;"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger"
                    style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right: 0.5rem;"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer Ad Slot --}}
    @php
        $adsEnabled = \App\Models\SiteSetting::get('ads_enabled', '1');
        $footerAd = \App\Models\SiteSetting::get('ad_footer');
        $adsEnabled = \App\Models\SiteSetting::get('ads_enabled', '1');
    @endphp
    @if($adsEnabled && $footerAd)
        <div class="ad-container">
            <div class="ad-label">Advertisement</div>
            {!! $footerAd !!}
        </div>
    @endif

    {{-- Footer --}}
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    @php
                        $siteDescription = \App\Models\SiteSetting::get('site_description', 'Curated for Nepali music lovers worldwide — authentic lyrics, Unicode precision, and a growing collection of your favorite songs.');
                        $contactEmail = \App\Models\SiteSetting::get('contact_email', '');
                    @endphp
                    <h3>{{ $siteName }}</h3>
                    <p style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                        {{ $siteDescription }}
                    </p>

                    @if($contactEmail)
                        <div style="margin-top: 1rem;">
                            <a href="mailto:{{ $contactEmail }}"
                                style="color: #cbd5e0; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                                <i class="fa-solid fa-envelope"></i>
                                {{ $contactEmail }}
                            </a>
                        </div>
                    @endif

                    {{-- Social Links --}}
                    @php
                        $facebookUrl = \App\Models\SiteSetting::get('facebook_url', '');
                        $youtubeUrl = \App\Models\SiteSetting::get('youtube_url', '');
                        $instagramUrl = \App\Models\SiteSetting::get('instagram_url', '');
                        $tiktokUrl = \App\Models\SiteSetting::get('tiktok_url', '');
                    @endphp
                    @if($facebookUrl || $youtubeUrl || $instagramUrl || $tiktokUrl)
                        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                            @if($facebookUrl)
                                <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                                    style="color: #cbd5e0; font-size: 1.5rem; transition: all 0.2s;"
                                    onmouseover="this.style.color='#1877f2'" onmouseout="this.style.color='#cbd5e0'"
                                    title="Facebook">
                                    <i class="fa-brands fa-facebook"></i>
                                </a>
                            @endif
                            @if($youtubeUrl)
                                <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer"
                                    style="color: #cbd5e0; font-size: 1.5rem; transition: all 0.2s;"
                                    onmouseover="this.style.color='#ff0000'" onmouseout="this.style.color='#cbd5e0'"
                                    title="YouTube">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            @endif
                            @if($instagramUrl)
                                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                                    style="color: #cbd5e0; font-size: 1.5rem; transition: all 0.2s;"
                                    onmouseover="this.style.color='#e1306c'" onmouseout="this.style.color='#cbd5e0'"
                                    title="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif
                            @if($tiktokUrl)
                                <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer"
                                    style="color: #cbd5e0; font-size: 1.5rem; transition: all 0.2s;"
                                    onmouseover="this.style.color='#000000'" onmouseout="this.style.color='#cbd5e0'"
                                    title="TikTok">
                                    <i class="fa-brands fa-tiktok"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('trending') }}">Trending Songs</a></li>
                        <li><a href="{{ route('new') }}">New Releases</a></li>
                        <li><a href="{{ route('upcoming') }}">Upcoming Lyrics</a></li>
                        <li><a href="{{ route('artists.top') }}">Top Artists</a></li>
                        <li><a href="{{ route('genre.index') }}">Genres</a></li>
                        <li><a href="{{ route('artist.register') }}">Join as Artist</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('dmca') }}">DMCA</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom" style="margin-bottom: 20px;">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    {{-- Mobile Bottom Navigation --}}
    <nav class="bottom-nav">
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>

        <a href="{{ route('trending') }}" class="nav-item {{ request()->routeIs('trending') ? 'active' : '' }}">
            <i class="fa-solid fa-fire"></i>
            <span>Trending</span>
        </a>

        <a href="{{ route('new') }}" class="nav-item {{ request()->routeIs('new') ? 'active' : '' }}">
            <i class="fa-solid fa-music"></i>
            <span>New</span>
        </a>

        <a href="{{ route('artists.top') }}" class="nav-item {{ request()->routeIs('artists*') ? 'active' : '' }}">
            <i class="fa-solid fa-microphone"></i>
            <span>Artists</span>
        </a>

        <div class="nav-item" id="moreNavToggle" onclick="toggleMoreMenu()" style="cursor:pointer;">
            <i class="fa-solid fa-ellipsis"></i>
            <span>More</span>

            <div class="more-menu" id="moreMenu">
                <a href="{{ route('album.index') }}">Albums</a>
                <a href="{{ route('movie.index') }}">Movies</a>
                <a href="{{ route('genre.index') }}">Genres</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" style="color: var(--color-primary); font-weight: bold;">Admin
                            Panel</a>
                    @elseif(auth()->user()->role === 'artist')
                        <a href="{{ route('artist.dashboard') }}"
                            style="color: var(--color-primary); font-weight: bold;">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: block;">
                        @csrf
                        <button type="submit"
                            style="background: none; border: none; padding: 12px 20px; width: 100%; text-align: left; font-size: 14px; color: var(--color-text-primary); cursor: pointer;">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="color: var(--color-primary); font-weight: bold;">Artist Login</a>
                    <a href="{{ route('artist.register') }}">Join as Artist</a>
                @endauth
                <a href="javascript:void(0)" onclick="toggleFooter()">Footer</a>
            </div>
        </div>
    </nav>

    {{-- Full Screen Search Overlay --}}
    <div id="searchOverlay" class="search-overlay">
        <button class="close-search" onclick="toggleSearch()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="search-overlay-content">
            <form action="{{ route('search') }}" method="GET" class="mobile-search-form">
                <input type="text" name="q" placeholder="Search songs, artists..." id="mobileSearchInput"
                    autocomplete="off">
                <button type="submit" class="search-submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div class="search-suggestions">
                <p>Try: <a href="{{ route('trending') }}">Trending</a>, <a href="{{ route('new') }}">New Releases</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function toggleMoreMenu() {
            const menu = document.getElementById('moreMenu');
            if (menu) menu.classList.toggle('show');
        }

        function toggleFooter() {
            const footer = document.querySelector('footer');
            if (footer) {
                // Toggle visibility class
                footer.classList.toggle('active-mobile');

                // If visible, scroll to it
                if (footer.classList.contains('active-mobile')) {
                    setTimeout(() => {
                        footer.scrollIntoView({ behavior: 'smooth' });
                    }, 100);
                }
            }
            // Close more menu
            const menu = document.getElementById('moreMenu');
            if (menu) menu.classList.remove('show');
        }

        function toggleSearch() {
            const overlay = document.getElementById('searchOverlay');
            const input = document.getElementById('mobileSearchInput');
            if (overlay) {
                overlay.classList.toggle('active');
                if (overlay.classList.contains('active') && input) {
                    setTimeout(() => input.focus(), 100);
                }
            }
        }

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            const toggle = document.getElementById('moreNavToggle');
            const menu = document.getElementById('moreMenu');
            if (menu && toggle && !toggle.contains(e.target) && menu.classList.contains('show')) {
                menu.classList.remove('show');
            }
        });
    </script>

    {{-- Global Popup Ad --}}
    @php
        $popupImage = \App\Models\SiteSetting::get('ad_popup_image');
        $popupLink = \App\Models\SiteSetting::get('ad_popup_link');
        $adsEnabled = $adsEnabled ?? \App\Models\SiteSetting::get('ads_enabled', '1');
    @endphp
    @if($adsEnabled && $popupImage)
        <div id="globalPopupAd" class="popup-ad-overlay" style="display: none;">
            <div class="popup-ad-content">
                <button class="popup-ad-close" onclick="closePopupAd()">&times;</button>
                <div class="popup-ad-body">
                    @if($popupLink)
                        <a href="{{ $popupLink }}" target="_blank">
                            <img src="{{ asset($popupImage) }}" alt="Special Offer"
                                style="max-width: 100%; height: auto; display: block; border-radius: 4px;">
                        </a>
                    @else
                        <img src="{{ asset($popupImage) }}" alt="Special Offer"
                            style="max-width: 100%; height: auto; display: block; border-radius: 4px;">
                    @endif
                </div>
            </div>
        </div>

        <style>
            .popup-ad-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.7);
                z-index: 9999;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                backdrop-filter: blur(5px);
            }

            .popup-ad-content {
                background: transparent;
                padding: 0;
                border-radius: 8px;
                position: relative;
                max-width: 90%;
                max-height: 90%;
            }

            .popup-ad-close {
                position: absolute;
                top: -15px;
                right: -15px;
                background: white;
                border: 2px solid #333;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                font-size: 20px;
                line-height: 26px;
                text-align: center;
                cursor: pointer;
                color: #333;
                font-weight: bold;
                z-index: 10;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .popup-ad-close:hover {
                background: #f0f0f0;
            }

            @media (min-width: 768px) {
                .popup-ad-content {
                    max-width: 600px;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (!sessionStorage.getItem('popupAdShown')) {
                    setTimeout(function () {
                        const popup = document.getElementById('globalPopupAd');
                        if (popup) {
                            popup.style.display = 'flex';
                        }
                    }, 2000);
                }
            });

            function closePopupAd() {
                const popup = document.getElementById('globalPopupAd');
                if (popup) {
                    popup.style.display = 'none';
                    sessionStorage.setItem('popupAdShown', 'true');
                }
            }
        </script>
    @endif
</body>

</html>
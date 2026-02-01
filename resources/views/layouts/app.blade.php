<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Nepali Lyrics - Latest Nepali Songs Lyrics in Unicode & Romanized')</title>
    <meta name="description"
        content="@yield('description', 'Read and download latest Nepali songs lyrics in Unicode and Romanized format. Trending songs, new releases, and complete lyrics collection.')">
    <meta name="keywords" content="@yield('keywords', 'nepali lyrics, nepali songs, lyrics unicode, romanized lyrics')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- OpenGraph Tags --}}
    {{-- OpenGraph Tags --}}
    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $siteName = \App\Models\SiteSetting::get('site_name', 'Nepali Lyrics');
        $faviconUrl = $siteLogo ? asset($siteLogo) : asset('favicon.ico');
    @endphp

    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Latest Nepali Songs Lyrics')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', $siteLogo ? asset($siteLogo) : asset('images/logo.png'))">
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">

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
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg);
            color: var(--color-text-primary);
            line-height: var(--line-height-normal);
            font-size: var(--font-size-base);
        }

        .nepali-text {
            font-family: 'Noto Sans Devanagari', 'Poppins', sans-serif;
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

        nav a:hover {
            color: var(--color-primary);
            transform: translateY(-1px);
        }

        nav a:hover::after {
            width: 100%;
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
            .mobile-menu-toggle {
                display: flex;
            }

            nav {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                box-shadow: -4px 0 20px rgba(0, 0, 0, 0.15);
                transition: right 0.3s ease;
                z-index: 1002;
                overflow-y: auto;
                padding-top: 70px;
            }

            nav.active {
                right: 0;
            }

            nav ul {
                flex-direction: column;
                gap: 0;
                padding: 1rem 0;
            }

            nav ul li {
                width: 100%;
                border-bottom: 1px solid #eee;
            }

            nav ul li a {
                display: block;
                padding: 1.25rem 1.5rem;
                font-size: 1rem;
                width: 100%;
                color: var(--color-text-primary);
            }

            nav a::after {
                display: none;
            }

            nav a:hover {
                background: #f7fafc;
                transform: none;
                color: var(--color-primary);
            }

            /* Mobile Overlay */
            body.menu-open::after {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1001;
            }

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

            header .container {
                flex-direction: column;
                gap: var(--space-4);
                padding-top: var(--space-3);
                padding-bottom: var(--space-3);
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
        }
    </style>


</head>

<body>
    {{-- Header Ad Slot --}}
    @php
        $headerAd = \App\Models\SiteSetting::get('ad_header');
    @endphp
    @if($headerAd)
        <div class="ad-container">
            <div class="ad-label">Advertisement</div>
            {!! $headerAd !!}
        </div>
    @endif

    {{-- Header --}}
    <header>
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                @if($siteLogo)
                    <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}" style="height: 40px;">
                @else
                    <i class="fa-solid fa-music"></i>
                    <span>{{ $siteName }}</span>
                @endif
            </a>

            {{-- Hamburger Menu Button (Mobile Only) --}}
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
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
            @yield('content')
        </div>
    </main>

    {{-- Footer Ad Slot --}}
    @php
        $footerAd = \App\Models\SiteSetting::get('ad_footer');
    @endphp
    @if($footerAd)
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
                    <h3>Nepali Lyrics</h3>
                    <p>Curated for Nepali music lovers worldwide — authentic lyrics, Unicode precision, and a growing
                        collection of your favorite songs.</p>
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ route('trending') }}">Trending Songs</a></li>
                        <li><a href="{{ route('new') }}">New Releases</a></li>
                        <li><a href="{{ route('artists.top') }}">Top Artists</a></li>
                        <li><a href="{{ route('genre.index') }}">Genres</a></li>
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

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Nepali Lyrics. Built with care for Nepali music lovers.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')

    {{-- Popup Ad Modal --}}
    @php
        $popupActive = \App\Models\SiteSetting::get('ad_popup_active', 0);
        $popupImage = \App\Models\SiteSetting::get('ad_popup_image', '');
        $popupLink = \App\Models\SiteSetting::get('ad_popup_link', '#');
    @endphp

    @if($popupActive && $popupImage)
        <div id="ad-popup-modal"
            style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center;">
            <div style="position: relative; max-width: 90%; max-height: 90%;">
                <button onclick="closeAdPopup()"
                    style="position: absolute; top: -15px; right: -15px; background: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(0,0,0,0.2); font-weight: bold; color: #333;">&times;</button>
                <a href="{{ $popupLink }}" target="_blank" onclick="closeAdPopup()">
                    <img src="{{ asset($popupImage) }}" alt="Special Offer"
                        style="max-width: 100%; max-height: 80vh; border-radius: 8px; box-shadow: 0 5px 25px rgba(0,0,0,0.5);">
                </a>
            </div>
        </div>

        <script>
            function showAdPopup() {
                // Check if user has closed it in this session
                if (!sessionStorage.getItem('ad_popup_closed')) {
                    document.getElementById('ad-popup-modal').style.display = 'flex';
                }
            }

            function closeAdPopup() {
                document.getElementById('ad-popup-modal').style.display = 'none';
                sessionStorage.setItem('ad_popup_closed', 'true');
            }

            // Show popup after 3 seconds
            setTimeout(showAdPopup, 3000);
        </script>
    @endif

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.getElementById('mobileMenuToggle');
            const mainNav = document.getElementById('mainNav');
            const body = document.body;

            if (menuToggle && mainNav) {
                // Toggle menu on button click
                menuToggle.addEventListener('click', function () {
                    menuToggle.classList.toggle('active');
                    mainNav.classList.toggle('active');
                    body.classList.toggle('menu-open');
                });

                // Close menu when clicking on a link
                const navLinks = mainNav.querySelectorAll('a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        menuToggle.classList.remove('active');
                        mainNav.classList.remove('active');
                        body.classList.remove('menu-open');
                    });
                });

                // Close menu when clicking outside (on overlay)
                document.addEventListener('click', function (event) {
                    if (body.classList.contains('menu-open') &&
                        !mainNav.contains(event.target) &&
                        !menuToggle.contains(event.target)) {
                        menuToggle.classList.remove('active');
                        mainNav.classList.remove('active');
                        body.classList.remove('menu-open');
                    }
                });
            }
        });
    </script>
</body>

</html>
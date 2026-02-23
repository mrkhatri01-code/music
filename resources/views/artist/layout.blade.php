<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Artist Panel</title>

    {{-- Favicon --}}
    @php
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $siteName = \App\Models\SiteSetting::get('site_name', 'Nepali Lyrics');
        
        $findArtistAsset = function($filename) {
            $paths = [public_path($filename), base_path('public/' . $filename), base_path($filename)];
            foreach ($paths as $path) {
                if ($path && file_exists($path)) return ['path' => $path, 'version' => @filemtime($path)];
            }
            return ['path' => null, 'version' => time()];
        };

        $mimeType = 'image/x-icon';
        $favicon = $findArtistAsset('favicon.ico');
        if (!$favicon['path']) {
            $logoAsset = $findArtistAsset($siteLogo);
            $faviconUrl = $logoAsset['path'] ? asset($siteLogo) . '?v=' . $logoAsset['version'] : asset('favicon.ico');
            if ($logoAsset['path']) {
                $ext = pathinfo($logoAsset['path'], PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                    $mimeType = 'image/' . (strtolower($ext) === 'jpg' ? 'jpeg' : strtolower($ext));
                }
            }
        } else {
            $faviconUrl = asset('favicon.ico') . '?v=' . $favicon['version'];
        }
    @endphp
    <link rel="icon" type="{{ $mimeType }}" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Colors - Neutrals */
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-border: #e2e8f0;
            --color-text-primary: #1e293b;
            --color-text-secondary: #64748b;
            --color-text-muted: #94a3b8;

            /* Colors - Brand */
            --primary-color: #E11D48;
            --primary-hover: #be123c;
            --sidebar-width: 280px;
            --header-height: 70px;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);

            /* Radius */
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text-primary);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--color-surface);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            z-index: 50;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            padding: 0 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            color: var(--color-text-secondary);
            text-decoration: none;
            border-radius: var(--radius-md);
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: #fff1f2;
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: #fff1f2;
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            background-color: var(--color-bg);
        }

        /* Top Header */
        .top-header {
            height: var(--header-height);
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--color-text-primary);
            margin: 0;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--color-text-primary);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1rem;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Utilities */
        .card {
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--color-border);
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            gap: 0.5rem;
            border: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--color-border);
            color: var(--color-text-secondary);
        }

        .btn-outline:hover {
            background: var(--color-bg);
            color: var(--color-text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
        }

        /* Select2 Customization - Artist */
        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 0.5rem 0.5rem;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            font-family: inherit;
            background-color: var(--color-surface);
            transition: all 0.2s;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            color: var(--color-text-primary);
            padding-left: 0.5rem;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 12px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
            outline: none;
        }

        .select2-dropdown {
            border: 1px solid #cbd5e1;
            /* slightly darker sltate boundary */
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            font-family: inherit;
            font-size: 0.95rem;
            overflow: hidden;
            margin-top: 4px;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: var(--primary-color);
            color: white;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--color-border);
            border-radius: 4px;
            padding: 8px;
            font-family: inherit;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="{{ route('artist.dashboard') }}" class="sidebar-brand">
            <i class="fa-solid fa-music"></i>
            Artist Panel
        </a>

        <nav>
            <a href="{{ route('artist.dashboard') }}"
                class="nav-link {{ request()->routeIs('artist.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('artist.songs.index') }}"
                class="nav-link {{ request()->routeIs('artist.songs.*') ? 'active' : '' }}">
                <i class="fa-solid fa-microphone"></i> Songs
            </a>
            <a href="{{ route('artist.albums.index') }}"
                class="nav-link {{ request()->routeIs('artist.albums.*') ? 'active' : '' }}">
                <i class="fa-solid fa-compact-disc"></i> Albums
            </a>
            <a href="{{ route('artist.profile') }}"
                class="nav-link {{ request()->routeIs('artist.profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i> Profile
            </a>
            <form action="{{ route('artist.logout') }}" method="POST" style="margin-top: auto;">
                @csrf
                <button type="submit" class="nav-link"
                    style="width: 100%; border: none; background: none; cursor: pointer;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <h2 class="page-title">@yield('title')</h2>
            </div>
            <div class="header-right">
                <div class="user-menu">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <div class="user-avatar"
                        style="{{ Auth::user()->artist && Auth::user()->artist->profile_image_url ? 'background: none;' : '' }}">
                        @if(Auth::user()->artist && Auth::user()->artist->profile_image_url)
                            <img src="{{ Auth::user()->artist->profile_image_url }}" alt="{{ Auth::user()->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    {{-- jQuery & Select2 Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>

</html>
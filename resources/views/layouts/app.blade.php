    @php
        $siteLogo = $siteLogo ?? \App\Models\SiteSetting::get('site_logo');
        $siteName = $siteName ?? \App\Models\SiteSetting::get('site_name', 'Nepali Lyrics');
        $mimeType = 'image/x-icon';
        $faviconUrl = asset('images/logo.png');

        $possibleFaviconPaths = [
            public_path($siteLogo),
            base_path('public/' . $siteLogo),
            base_path($siteLogo),
            public_path('favicon.ico'),
            base_path('public/favicon.ico'),
            base_path('favicon.ico'),
        ];

        foreach ($possibleFaviconPaths as $path) {
            if ($path && file_exists($path)) {
                $faviconUrl = asset(str_replace([public_path(), base_path('public'), base_path()], '', $path)) . '?v=' . @filemtime($path);
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'webp'])) {
                    $mimeType = 'image/' . (strtolower($ext) === 'jpg' ? 'jpeg' : strtolower($ext));
                }
                break;
            }
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
    <meta name="google-adsense-account" content="ca-pub-1986505597365790">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KGESSQCKEQ"></script>
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

    {{-- Styles - Smart Asset Loader --}}
    @php
        $findAsset = function($filename) {
            $paths = [
                public_path($filename),
                base_path('public/' . $filename),
                base_path($filename),
            ];
            foreach ($paths as $path) {
                if (file_exists($path)) return ['path' => $path, 'version' => @filemtime($path)];
            }
            return ['path' => null, 'version' => time()];
        };

        $css = $findAsset('css/app.css');
        $js = $findAsset('js/app.js');
    @endphp
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ $css['version'] }}">
    <script src="{{ asset('js/app.js') }}?v={{ $js['version'] }}" defer></script>


</head>

<body>

    {{-- Header --}}
    <header>
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                @if($siteLogo)
                    <img src="{{ asset($siteLogo) . '?v=' . @filemtime(public_path($siteLogo)) }}" alt="{{ $siteName }}"
                        style="height: 40px;">
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
                            <img src="{{ asset($siteLogo) . '?v=' . filemtime(public_path($siteLogo)) }}"
                                alt="{{ $siteName }}" style="height: 35px;">
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

    {{-- Modern Footer --}}


    <footer class="modern-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <h3>{{ $siteName }}</h3>
                    <p>
                        @php
                            $siteDescription = \App\Models\SiteSetting::get('site_description', 'Curated for Nepali music lovers worldwide — authentic lyrics, Unicode precision, and a growing collection of your favorite songs.');
                        @endphp
                        {{ $siteDescription }}
                    </p>

                    @php
                        $contacts = [
                            'facebook' => \App\Models\SiteSetting::get('facebook_url'),
                            'youtube' => \App\Models\SiteSetting::get('youtube_url'),
                            'instagram' => \App\Models\SiteSetting::get('instagram_url'),
                            'tiktok' => \App\Models\SiteSetting::get('tiktok_url'),
                            'email' => \App\Models\SiteSetting::get('contact_email')
                        ];
                    @endphp

                    <div class="social-links">
                        @if($contacts['facebook'])
                            <a href="{{ $contacts['facebook'] }}" class="social-btn" target="_blank" title="Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($contacts['youtube'])
                            <a href="{{ $contacts['youtube'] }}" class="social-btn" target="_blank" title="YouTube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        @endif
                        @if($contacts['instagram'])
                            <a href="{{ $contacts['instagram'] }}" class="social-btn" target="_blank" title="Instagram">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif
                        @if($contacts['tiktok'])
                            <a href="{{ $contacts['tiktok'] }}" class="social-btn" target="_blank" title="TikTok">
                                <i class="fa-brands fa-tiktok"></i>
                            </a>
                        @endif
                        @if($contacts['email'])
                            <a href="mailto:{{ $contacts['email'] }}" class="social-btn" title="Email Us">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-heading">Discover</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('trending') }}">Trending Songs</a></li>
                        <li><a href="{{ route('new') }}">New Releases</a></li>
                        <li><a href="{{ route('upcoming') }}">Upcoming</a></li>
                        <li><a href="{{ route('artists.top') }}">Top Artists</a></li>
                        <li><a href="{{ route('album.index') }}">Albums</a></li>
                    </ul>
                </div>

                <!-- Community -->
                <div class="footer-section">
                    <h4 class="footer-heading">Community</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('artist.register') }}">Artist Signup</a></li>
                        <li><a href="{{ route('artist.login') }}">Artist Login</a></li>
                        <li><a href="{{ route('contact') }}">Suggest Song</a></li>
                        <li><a href="{{ route('contact') }}">Report Issue</a></li>
                    </ul>
                </div>

                <!-- Legal & Info -->
                <div class="footer-section">
                    <h4 class="footer-heading">Company</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                        <li><a href="{{ route('dmca') }}">DMCA</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $siteName }}. Made with <i class="fa-solid fa-heart"
                        style="color: #ef4444;"></i> for Nepali Music. Developed by <a
                        href="https://khatriprabhakar.com.np/" target="_blank"
                        style="color: var(--color-primary); text-decoration: none; font-weight: 600;">Prabhakar
                        Khatri</a></p>
                <div class="footer-bottom-links">
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="{{ route('sitemap') }}">Sitemap</a>
                </div>
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
                <a href="{{ route('about') }}">About Us</a>
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
                    <a href="{{ route('artist.login') }}" style="color: var(--color-primary); font-weight: bold;">Artist
                        Login</a>
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



    @endif
</body>

</html>
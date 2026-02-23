@extends('layouts.app')

@section('title', $artist->name_english . ' Songs & Lyrics')
@section('description', 'All songs and lyrics by ' . $artist->name_english . ' (' . $artist->name_nepali . '). Complete collection with Unicode and Romanized lyrics.')

@section('canonical', route('artist.show', $artist->slug))

@section('og_title', $artist->name_english . ' - Songs & Lyrics')
@section('og_description', 'View all songs by ' . $artist->name_english)
@section('og_type', 'profile')

@push('structured-data')
    <script type="application/ld+json">
                                                                                                                                            {
                                                                                                                                                "@context": "https://schema.org",
                                                                                                                                                "@type": "MusicGroup",
                                                                                                                                                "name": "{{ $artist->name_english }}",
                                                                                                                                                "alternateName": "{{ $artist->name_nepali }}",
                                                                                                                                                @if($artist->bio)
                                                                                                                                                    "description": "{{ $artist->bio }}",
                                                                                                                                                @endif
                                                                                                                                                "url": "{{ route('artist.show', $artist->slug) }}"
                                                                                                                                            }
                                                                                                                                            </script>

    <script type="application/ld+json">
                                                                                                                                            {
                                                                                                                                                "@context": "https://schema.org",
                                                                                                                                                "@type": "BreadcrumbList",
                                                                                                                                                "itemListElement": [{
                                                                                                                                                    "@type": "ListItem",
                                                                                                                                                    "position": 1,
                                                                                                                                                    "name": "Home",
                                                                                                                                                    "item": "{{ route('home') }}"
                                                                                                                                                },{
                                                                                                                                                    "@type": "ListItem",
                                                                                                                                                    "position": 2,
                                                                                                                                                    "name": "Artists",
                                                                                                                                                    "item": "{{ route('artists.top') }}"
                                                                                                                                                },{
                                                                                                                                                    "@type": "ListItem",
                                                                                                                                                    "position": 3,
                                                                                                                                                    "name": "{{ $artist->name_english }}",
                                                                                                                                                    "item": "{{ route('artist.show', $artist->slug) }}"
                                                                                                                                                }]
                                                                                                                                            }
                                                                                                                                            </script>
@endpush

@section('content')
    <style>
        .artist-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .artist-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            flex-shrink: 0;
        }

        .artist-info h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .artist-info .subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .social-links a {
            color: white;
            text-decoration: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: all 0.3s;
            font-size: 1.1rem;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
        }

        .social-links a:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
        }

        .social-links a.youtube:hover {
            background: rgba(255, 0, 0, 0.8);
        }

        .social-links a.facebook:hover {
            background: rgba(24, 119, 242, 0.8);
        }

        .social-links a.instagram:hover {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        }

        .social-links a.tiktok:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .social-links a.spotify:hover {
            background: rgba(30, 215, 96, 0.8);
        }

        .social-links a.apple-music:hover {
            background: rgba(252, 61, 57, 0.8);
        }

        .social-links a.website:hover {
            background: rgba(99, 102, 241, 0.8);
        }

        .social-links a.email:hover {
            background: rgba(234, 67, 53, 0.8);
        }

        .songs-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .songs-grid {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .song-item {
            padding: 1.5rem;
            background: #f7fafc;
            border-radius: 8px;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: all 0.3s;
        }

        .song-item:hover {
            background: #edf2f7;
            transform: translateX(5px);
        }

        .song-item-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2d3748;
        }

        .song-item-meta {
            font-size: 0.9rem;
            color: #718096;
        }

        /* Mobile Header Styles */
        .artist-header-mobile {
            display: none;
        }

        @media (max-width: 768px) {
            .artist-header {
                display: none !important;
            }

            .artist-header-mobile {
                display: block;
                margin-left: -1rem;
                margin-right: -1rem;
                margin-bottom: 2rem;
                margin-top: -2rem;
                /* Remove Main Padding Gap */
            }

            .artist-banner {
                height: 220px;
                background-size: cover;
                background-position: center;
                background-color: #667eea;
                position: relative;
            }

            .artist-content-card {
                background: white;
                border-radius: 24px 24px 0 0;
                margin-top: -50px;
                padding: 1.5rem;
                position: relative;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
            }

            .artist-mobile-avatar {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                border: 4px solid white;
                position: absolute;
                top: -50px;
                left: 20px;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                color: #667eea;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
                overflow: hidden;
                z-index: 10;
            }

            .artist-mobile-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .artist-mobile-name {
                padding-top: 0;
                margin-bottom: 0.5rem;
                padding-left: 105px;
            }

            .artist-mobile-name h1 {
                font-size: 1.25rem;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                line-height: 1.2;
                color: #2d3748;
                font-weight: 600;
                white-space: nowrap;
                max-width: 100%;
            }

            .artist-mobile-name h1>span {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .artist-mobile-stats {
                margin-top: 1.5rem;
                display: flex;
                gap: 1.5rem;
                color: #718096;
                font-size: 0.85rem;
                border-bottom: 1px solid #edf2f7;
                padding-bottom: 1rem;
                margin-bottom: 1rem;
            }

            /* Customize social links for mobile card */
            .artist-content-card .social-links a {
                background: #f7fafc;
                color: #4a5568;
                border: 1px solid #e2e8f0;
            }

            .artist-content-card .social-links a.youtube:hover {
                background: rgba(255, 0, 0, 0.1);
                color: #ff0000;
                border-color: #ff0000;
            }

            .artist-content-card .social-links a.facebook:hover {
                background: rgba(24, 119, 242, 0.1);
                color: #1877f2;
                border-color: #1877f2;
            }

            .artist-content-card .social-links a.instagram:hover {
                background: linear-gradient(45deg, rgba(240, 148, 51, 0.1) 0%, rgba(230, 104, 60, 0.1) 100%);
                color: #e1306c;
                border-color: #e1306c;
            }

            .artist-content-card .social-links a.tiktok:hover {
                background: rgba(0, 0, 0, 0.1);
                color: #000;
                border-color: #000;
            }

            .artist-content-card .social-links a.spotify:hover {
                background: rgba(30, 215, 96, 0.1);
                color: #1ed760;
                border-color: #1ed760;
            }

            .artist-content-card .social-links a.apple-music:hover {
                background: rgba(252, 61, 57, 0.1);
                color: #fc3d39;
                border-color: #fc3d39;
            }

            .artist-content-card .social-links a.website:hover {
                background: rgba(99, 102, 241, 0.1);
                color: #6366f1;
                border-color: #6366f1;
            }

            .artist-content-card .social-links a.email:hover {
                background: rgba(234, 67, 53, 0.1);
                color: #ea4335;
                border-color: #ea4335;
            }
        }
    </style>

    {{-- Mobile Artist Header --}}
    <div class="artist-header-mobile">
        <div class="artist-banner"
            style="{{ $artist->cover_image_url ? 'background-image: url(' . $artist->cover_image_url . ')' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
        </div>
        <div class="artist-content-card">
            <div class="artist-mobile-avatar">
                @if($artist->profile_image_url)
                    <img src="{{ $artist->profile_image_url }}" alt="{{ $artist->name_english }}">
                @else
                    {{ substr($artist->name_english, 0, 1) }}
                @endif
            </div>

            <div class="artist-mobile-name">
                <h1>
                    <span>{{ $artist->name_english }}</span>
                    @if($artist->is_verified)
                        <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 1rem; flex-shrink: 0;"></i>
                    @endif
                </h1>
                <div style="font-size: 0.8rem; color: #718096;">
                    {{ $artist->name_nepali }} &bull; <span
                        style="text-transform: capitalize;">{{ $artist->type ?? 'Singer' }}</span>
                </div>
            </div>

            <div class="artist-mobile-stats">
                <div>
                    <span style="font-weight: 700; color: #2d3748;">{{ $artist->songs->count() }}</span> Songs
                </div>
                <div>
                    <span style="font-weight: 700; color: #2d3748;">{{ number_format($artist->views_count) }}</span> Views
                </div>
                @if($artist->age)
                    <div>
                        <span style="font-weight: 700; color: #2d3748;">{{ $artist->age }}</span> Years Old
                    </div>
                @endif
            </div>

            @if($artist->social_links)
                <div class="social-links"
                    style="margin-top: 0; margin-bottom: 0; padding-bottom: 0.5rem; display: grid; grid-template-columns: repeat(auto-fit, 40px); gap: 0.75rem; max-width: 100%;">
                    @if(isset($artist->social_links['youtube']) && $artist->social_links['youtube'])
                        <a href="{{ $artist->social_links['youtube'] }}" target="_blank" class="youtube" title="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['facebook']) && $artist->social_links['facebook'])
                        <a href="{{ $artist->social_links['facebook'] }}" target="_blank" class="facebook" title="Facebook">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['instagram']) && $artist->social_links['instagram'])
                        <a href="{{ $artist->social_links['instagram'] }}" target="_blank" class="instagram" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['tiktok']) && $artist->social_links['tiktok'])
                        <a href="{{ $artist->social_links['tiktok'] }}" target="_blank" class="tiktok" title="TikTok">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['spotify']) && $artist->social_links['spotify'])
                        <a href="{{ $artist->social_links['spotify'] }}" target="_blank" class="spotify" title="Spotify">
                            <i class="fa-brands fa-spotify"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['apple_music']) && $artist->social_links['apple_music'])
                        <a href="{{ $artist->social_links['apple_music'] }}" target="_blank" class="apple-music"
                            title="Apple Music">
                            <i class="fa-brands fa-apple"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['website']) && $artist->social_links['website'])
                        <a href="{{ $artist->social_links['website'] }}" target="_blank" class="website" title="Website">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['public_email']) && $artist->social_links['public_email'])
                        <a href="mailto:{{ $artist->social_links['public_email'] }}" class="email" title="Email">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Artist Header --}}
    <div class="artist-header"
        style="{{ $artist->cover_image_url ? 'background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url(' . $artist->cover_image_url . '); background-size: cover; background-position: center;' : '' }}">
        <div class="artist-avatar" style="{{ $artist->profile_image_url ? 'padding: 0; overflow: hidden;' : '' }}">
            @if($artist->profile_image_url)
                <img src="{{ $artist->profile_image_url }}" alt="{{ $artist->name_english }}"
                    style="width: 100%; height: 100%; object-fit: cover;">
            @else
                {{ substr($artist->name_english, 0, 1) }}
            @endif
        </div>
        <div class="artist-info">
            <h1>
                {{ $artist->name_english }}
                @if($artist->is_verified)
                    <i class="fa-solid fa-circle-check" style="color: #4ade80; font-size: 2rem; margin-left: 0.5rem;"></i>
                @endif
            </h1>
            <div class="subtitle">
                {{ $artist->name_nepali }} &bull; <span
                    style="text-transform: capitalize; font-size: 0.9em; opacity: 0.8;">{{ $artist->type ?? 'Singer' }}</span>
            </div>
            <div style="font-size: 0.95rem; opacity: 0.9;">
                <i class="fa-solid fa-music"></i> {{ $artist->songs->count() }} songs | <i class="fa-solid fa-eye"></i>
                {{ number_format($artist->views_count) }} views
                @if($artist->age)
                    | <i class="fa-solid fa-cake-candles"></i> {{ $artist->age }} years old
                @endif
            </div>

            @if($artist->social_links)
                <div class="social-links">
                    @if(isset($artist->social_links['youtube']) && $artist->social_links['youtube'])
                        <a href="{{ $artist->social_links['youtube'] }}" target="_blank" class="youtube" title="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['facebook']) && $artist->social_links['facebook'])
                        <a href="{{ $artist->social_links['facebook'] }}" target="_blank" class="facebook" title="Facebook">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['instagram']) && $artist->social_links['instagram'])
                        <a href="{{ $artist->social_links['instagram'] }}" target="_blank" class="instagram" title="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['tiktok']) && $artist->social_links['tiktok'])
                        <a href="{{ $artist->social_links['tiktok'] }}" target="_blank" class="tiktok" title="TikTok">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['spotify']) && $artist->social_links['spotify'])
                        <a href="{{ $artist->social_links['spotify'] }}" target="_blank" class="spotify" title="Spotify">
                            <i class="fa-brands fa-spotify"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['apple_music']) && $artist->social_links['apple_music'])
                        <a href="{{ $artist->social_links['apple_music'] }}" target="_blank" class="apple-music"
                            title="Apple Music">
                            <i class="fa-brands fa-apple"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['website']) && $artist->social_links['website'])
                        <a href="{{ $artist->social_links['website'] }}" target="_blank" class="website" title="Website">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    @endif
                    @if(isset($artist->social_links['public_email']) && $artist->social_links['public_email'])
                        <a href="mailto:{{ $artist->social_links['public_email'] }}" class="email" title="Email">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Biography --}}
    @if($artist->bio)
        <div class="songs-section" style="margin-bottom: 2rem;">
            <h2>About {{ $artist->name_english }}</h2>
            <p style="margin-top: 1rem; line-height: 1.8; color: #4a5568;">{{ $artist->bio }}</p>
        </div>
    @endif

    {{-- Upcoming Songs --}}
    @if(isset($upcomingSongs) && $upcomingSongs->count() > 0)
        <div class="songs-section" style="margin-bottom: 2rem;">
            <h2>Upcoming Songs <span
                    style="font-size: 0.9rem; font-weight: normal; color: #718096; margin-left: 0.5rem;">(Lyrics Coming
                    Soon)</span></h2>
            <div class="songs-grid">
                @foreach($upcomingSongs as $song)
                    <a href="{{ route('song.show', [$artist->slug, $song->slug]) }}" class="song-item"
                        style="border-left: 4px solid #ed8936;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div class="song-item-title">{{ $song->title_nepali }}</div>
                            <span style="font-size: 0.7rem; color: #f59e0b; white-space: nowrap;">
                                <i class="fa-solid fa-clock"></i> Coming Soon
                            </span>
                        </div>
                        <div class="song-item-meta">
                            {{ $song->title_english }}
                            @if($song->release_date) | <i class="fa-solid fa-calendar-days"></i>
                            {{ $song->release_date->format('d M, Y') }} @elseif($song->year) | <i
                            class="fa-solid fa-calendar-days"></i> {{ $song->year }} @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Top Songs --}}
    <div class="songs-section">
        <h2>Top Songs by {{ $artist->name_english }}</h2>
        <div class="songs-grid">
            @forelse($topSongs as $song)
                <a href="{{ route('song.show', [$artist->slug, $song->slug]) }}" class="song-item">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div class="song-item-title">{{ $song->title_nepali }}</div>
                        @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                            <span style="font-size: 0.7rem; color: #f59e0b; white-space: nowrap;">
                                <i class="fa-solid fa-clock"></i> Coming Soon
                            </span>
                        @endif
                    </div>
                    <div class="song-item-meta">
                        {{ $song->title_english }}
                        @if($song->release_date) | <i class="fa-solid fa-calendar-days"></i>
                        {{ $song->release_date->format('d M, Y') }} @elseif($song->year) | <i
                        class="fa-solid fa-calendar-days"></i> {{ $song->year }} @endif
                        | <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }} views
                    </div>
                </a>
            @empty
                <p style="color: #718096;">No songs available.</p>
            @endforelse
        </div>
    </div>

    {{-- Written Songs --}}
    @if(isset($topWrittenSongs) && $topWrittenSongs->count() > 0)
        <div class="songs-section" style="margin-top: 2rem;">
            <h2>Songs Written by {{ $artist->name_english }}</h2>
            <div class="songs-grid">
                @foreach($topWrittenSongs as $song)
                    <a href="{{ route('song.show', [($song->artist ?? $artist)->slug ?? 'unknown', $song->slug]) }}"
                        class="song-item">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div class="song-item-title">{{ $song->title_nepali }}</div>
                            @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                <span style="font-size: 0.7rem; color: #f59e0b; white-space: nowrap;">
                                    <i class="fa-solid fa-clock"></i> Coming Soon
                                </span>
                            @endif
                        </div>
                        <div class="song-item-meta">
                            {{ $song->title_english }}
                            @if($song->artist_id) | <i class="fa-solid fa-microphone"></i>
                            Singer: {{ $song->artist->name_english }} @endif
                            @if($song->release_date) | <i class="fa-solid fa-calendar-days"></i>
                            {{ $song->release_date->format('d M, Y') }} @elseif($song->year) | <i
                            class="fa-solid fa-calendar-days"></i> {{ $song->year }} @endif
                            | <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }} views
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Albums --}}
    @if($albums->count() > 0)
        <div class="songs-section" style="margin-top: 2rem;">
            <h2>Albums</h2>
            <div
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                @foreach($albums as $album)
                    <a href="{{ route('album.show', $album->slug) }}"
                        style="padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px; text-decoration: none; display: block; transition: transform 0.2s;">
                        <img src="{{ $album->cover_image ? asset($album->cover_image) : asset('images/default-album.png') }}"
                            alt="{{ $album->name }}"
                            style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                            loading="lazy" decoding="async">
                        <div style="font-weight: 600; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $album->name }}</div>
                        @if($album->year)
                            <div style="opacity: 0.9; font-size: 0.9rem;">
                                <i class="fa-solid fa-calendar-days" style="margin-right: 0.25rem;"></i>
                                {{ $album->year }}
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection
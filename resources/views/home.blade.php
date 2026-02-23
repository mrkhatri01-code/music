@extends('layouts.app')

@section('title', $siteName . ' - Latest Songs Lyrics in Unicode & Romanized')
@section('hide_site_name', true)
@section('description', 'Read and download latest Nepali songs lyrics. Trending songs, new releases, top artists, and complete lyrics in Unicode and Romanized format.')

@push('structured-data')
    <script type="application/ld+json">
                                                                            {
                                                                                "@context": "https://schema.org",
                                                                                "@type": "WebSite",
                                                                                "name": "{{ config('app.name') }}",
                                                                                "url": "{{ route('home') }}",
                                                                                "potentialAction": {
                                                                                    "@type": "SearchAction",
                                                                                    "target": {
                                                                                        "@type": "EntryPoint",
                                                                                        "urlTemplate": "{{ route('search') }}?q={search_term_string}"
                                                                                    },
                                                                                    "query-input": "required name=search_term_string"
                                                                                }
                                                                            }
                                                                            </script>
@endpush

@section('content')
    {{-- Trending Now Section --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
            <div>
                <h2 class="section-heading" style="margin-bottom: var(--space-2);">
                    <i class="fa-solid fa-fire"></i>
                    Trending Now
                </h2>
                <p class="section-intro" style="margin-top: 0;">Discover what Nepal is listening to right now</p>
            </div>
            @if($trendingToday->count() > 0)
                <a href="{{ route('trending.today') }}" class="btn btn-outline"
                    style="white-space: nowrap; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                    View More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($trendingToday->count() > 0)
            <div class="grid grid-4">
                @foreach($trendingToday as $song)
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        class="song-card {{ $loop->iteration > 3 ? 'hide-on-mobile' : '' }}">
                        <div class="song-title nepali-text">
                            {{ $song->title_nepali }}
                            @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                <span
                                    style="font-size: 0.65rem; color: #f59e0b; display: inline-block; margin-left: 5px; vertical-align: middle;">
                                    <i class="fa-solid fa-clock"></i>
                                </span>
                            @endif
                        </div>
                        <div class="song-title"
                            style="font-size: 0.95rem; color: var(--color-text-secondary); font-weight: var(--font-weight-medium);">
                            {{ $song->title_english }}
                        </div>
                        <div class="song-meta">
                            <span style="color: var(--color-primary);">
                                <i class="fa-solid fa-microphone"></i>
                                {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                            </span>
                            <span>
                                <i class="fa-solid fa-eye"></i>
                                {{ number_format($song->views_count) }}
                            </span>
                            @if($song->release_date)
                                <span style="font-size: 0.8rem; color: #a0aec0;">
                                    <i class="fa-solid fa-calendar-days"></i> {{ $song->release_date->format('d M, Y') }}
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-fire"></i>
                <h3>No Trending Songs Yet</h3>
                <p>Check back soon to see what's popular</p>
            </div>
        @endif
    </div>

    {{-- Ad Slot --}}
    @php
        $midAd1 = \App\Models\SiteSetting::get('ad_mid1');
        $adsEnabled = \App\Models\SiteSetting::get('ads_enabled', '1');
    @endphp
    @if($adsEnabled && $midAd1)
        <div class="ad-container">
            <div class="ad-label">Advertisement</div>
            {!! $midAd1 !!}
        </div>
    @endif

    {{-- Most Viewed This Week --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
            <div>
                <h2 class="section-heading" style="margin-bottom: var(--space-2);">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    Most Viewed This Week
                </h2>
                <p class="section-intro" style="margin-top: 0;">Top songs capturing hearts across Nepal</p>
            </div>
            @if($trendingWeek->count() > 0)
                <a href="{{ route('trending.week') }}" class="btn btn-outline"
                    style="white-space: nowrap; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                    View More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($trendingWeek->count() > 0)
            <div class="grid grid-4">
                @foreach($trendingWeek as $song)
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        class="song-card {{ $loop->iteration > 3 ? 'hide-on-mobile' : '' }}">
                        <div class="song-title nepali-text">
                            {{ $song->title_nepali }}
                            @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                <span
                                    style="font-size: 0.65rem; color: #f59e0b; display: inline-block; margin-left: 5px; vertical-align: middle;">
                                    <i class="fa-solid fa-clock"></i>
                                </span>
                            @endif
                        </div>
                        <div class="song-title"
                            style="font-size: 0.95rem; color: var(--color-text-secondary); font-weight: var(--font-weight-medium);">
                            {{ $song->title_english }}
                        </div>
                        <div class="song-meta">
                            <span style="color: var(--color-primary);">
                                <i class="fa-solid fa-microphone"></i>
                                {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                            </span>
                            <span>
                                <i class="fa-solid fa-eye"></i>
                                {{ number_format($song->views_count) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-chart-line"></i>
                <h3>No Weekly Trends Yet</h3>
                <p>Come back soon for the latest hits</p>
            </div>
        @endif
    </div>

    <div class="section-divider"></div>

    {{-- New Releases --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
            <div>
                <h2 class="section-heading" style="margin-bottom: var(--space-2);">
                    <i class="fa-solid fa-bolt"></i>
                    New Releases
                </h2>
                <p class="section-intro" style="margin-top: 0;">Fresh lyrics from the latest Nepali songs</p>
            </div>
            @if($newSongs->count() > 0)
                <a href="{{ route('new') }}" class="btn btn-outline"
                    style="white-space: nowrap; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                    Browse All
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($newSongs->count() > 0)
            <div class="grid grid-4">
                @foreach($newSongs as $song)
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        class="song-card {{ $loop->iteration > 3 ? 'hide-on-mobile' : '' }}">
                        <div class="song-title nepali-text">{{ $song->title_nepali }}</div>
                        <div class="song-title"
                            style="font-size: 0.95rem; color: var(--color-text-secondary); font-weight: var(--font-weight-medium);">
                            {{ $song->title_english }}
                        </div>
                        <div class="song-meta">
                            <span style="color: var(--color-primary);">
                                <i class="fa-solid fa-microphone"></i>
                                {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                            </span>
                            <span>
                                <i class="fa-solid fa-eye"></i>
                                {{ number_format($song->views_count) }}
                            </span>
                            @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                <span class="badge" style="background: #e2e8f0; color: #4a5568;">
                                    <i class="fa-solid fa-clock"></i>
                                    Coming Soon
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="fa-solid fa-circle-check"></i>
                                    New
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-music"></i>
                <h3>No New Releases</h3>
                <p>Stay tuned for upcoming songs</p>
            </div>
        @endif
    </div>

    {{-- Festival Collections (if any) --}}
    @if($festivals->count() > 0)
        <div class="section">
            <h2 class="section-heading">
                <i class="fa-solid fa-calendar-days"></i>
                Festival Collections
            </h2>
            <p class="section-intro">Celebrate with songs for every occasion</p>

            <div class="grid grid-3">
                @foreach($festivals as $festival)
                    <a href="#" class="card"
                        style="text-decoration: none; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; text-align: center; padding: var(--space-8) var(--space-6);">
                        <i class="fa-solid fa-calendar-days" style="font-size: 2rem; margin-bottom: var(--space-4);"></i>
                        <div style="font-size: 1.25rem; font-weight: var(--font-weight-bold); margin-bottom: var(--space-2);">
                            {{ $festival->name }}
                        </div>
                        <div style="opacity: 0.9; font-size: var(--font-size-sm);">Special Collection</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="section-divider"></div>
    @endif

    {{-- Top Artists --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
            <div>
                <h2 class="section-heading" style="margin-bottom: var(--space-2);">
                    <i class="fa-solid fa-crown"></i>
                    Top Artists
                </h2>
                <p class="section-intro" style="margin-top: 0;">Voices that define Nepali music</p>
            </div>
            @if($topArtists->count() > 0)
                <a href="{{ route('artists.top') }}" class="btn btn-outline"
                    style="white-space: nowrap; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                    View All
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($topArtists->count() > 0)
            <div class="grid grid-4">
                @foreach($topArtists as $artist)
                    <a href="{{ route('artist.show', $artist->slug) }}"
                        class="card {{ $loop->iteration > 3 ? 'hide-on-mobile' : '' }}"
                        style="text-decoration: none; display: flex; align-items: center; gap: var(--space-4);">
                        <div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                            @if($artist->profile_image_url)
                                <img src="{{ $artist->profile_image_url }}" alt="{{ $artist->name_english }}"
                                    style="width: 100%; height: 100%; object-fit: cover;" loading="lazy" decoding="async">
                            @else
                                <div
                                    style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-gradient-start), var(--color-gradient-end)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: var(--font-weight-bold);">
                                    {{ strtoupper(substr($artist->name_english, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div
                                style="font-size: 1.05rem; font-weight: var(--font-weight-semibold); color: var(--color-text-primary); margin-bottom: var(--space-1);">
                                {{ $artist->name_english }}
                            </div>
                            <div style="font-size: var(--font-size-sm); color: var(--color-text-secondary);" class="nepali-text">
                                {{ $artist->name_nepali }}
                            </div>
                            @if($artist->is_verified)
                                <span class="badge badge-primary" style="margin-top: var(--space-2);">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Verified
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-microphone"></i>
                <h3>No Artists Yet</h3>
                <p>Artists will appear as the collection grows</p>
            </div>
        @endif
    </div>

    <div class="section-divider"></div>

    {{-- Popular Genres --}}
    <div class="section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
            <div>
                <h2 class="section-heading" style="margin-bottom: var(--space-2);">
                    <i class="fa-solid fa-guitar"></i>
                    Popular Genres
                </h2>
                <p class="section-intro" style="margin-top: 0;">Explore songs by mood and style</p>
            </div>
            @if($genres->count() > 0)
                <a href="{{ route('genre.index') }}" class="btn btn-outline"
                    style="white-space: nowrap; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                    View More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if($genres->count() > 0)
            <div class="genre-grid-home">
                @foreach($genres as $genre)
                    <a href="{{ route('genre.show', $genre->slug) }}" class="genre-card-home">
                        <div class="card-content">
                            <div class="genre-icon-wrapper">
                                <i class="fa-solid fa-guitar"></i>
                            </div>
                            <div class="genre-details">
                                <h3 class="genre-name">{{ $genre->name }}</h3>
                                <span class="song-count">
                                    {{ $genre->songs_count ?? 0 }} Songs
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <style>
                .genre-grid-home {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                    gap: 2rem;
                    padding-bottom: 2rem;
                }

                .genre-card-home {
                    position: relative;
                    background: white;
                    border-radius: 24px;
                    overflow: hidden;
                    aspect-ratio: 1/1;
                    text-decoration: none !important;
                    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                }

                .genre-card-home::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    opacity: 0.9;
                    transition: opacity 0.3s ease;
                }

                /* Dynamic Gradients */
                .genre-card-home:nth-child(4n+1)::before {
                    background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
                }

                .genre-card-home:nth-child(4n+2)::before {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                }

                .genre-card-home:nth-child(4n+3)::before {
                    background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
                }

                .genre-card-home:nth-child(4n+4)::before {
                    background: linear-gradient(135deg, #F97794 0%, #623AA2 100%);
                }

                .genre-card-home .card-content {
                    position: relative;
                    z-index: 2;
                    padding: 1.5rem;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    color: white;
                }

                .genre-card-home .genre-icon-wrapper {
                    font-size: 3rem;
                    margin-bottom: 0.5rem;
                    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
                    transition: transform 0.3s ease;
                }

                .genre-card-home .genre-name {
                    font-size: 1.25rem;
                    font-weight: 700;
                    margin-bottom: 0.25rem;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .genre-card-home .song-count {
                    font-size: 0.8rem;
                    background: rgba(255, 255, 255, 0.2);
                    padding: 0.2rem 0.6rem;
                    border-radius: 12px;
                    backdrop-filter: blur(4px);
                    font-weight: 500;
                }

                .genre-card-home:hover {
                    transform: translateY(-8px) scale(1.02);
                }

                .genre-card-home:hover::before {
                    opacity: 1;
                    filter: brightness(1.05);
                }

                .genre-card-home:hover .genre-icon-wrapper {
                    transform: scale(1.1) rotate(5deg);
                }

                @media (max-width: 768px) {
                    .genre-grid-home {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }

                    .genre-card-home .genre-icon-wrapper {
                        font-size: 2rem;
                    }

                    .genre-card-home .genre-name {
                        font-size: 0.9rem;
                        line-height: 1.2;
                    }

                    .genre-card-home .card-content {
                        padding: 1rem;
                    }
                }
            </style>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-list-music"></i>
                <h3>No Genres Available</h3>
                <p>Genres will populate as songs are added</p>
            </div>
        @endif
    </div>

@endsection
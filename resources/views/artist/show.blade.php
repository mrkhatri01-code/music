@extends('layouts.app')

@section('title', $artist->name_english . ' Songs & Lyrics - Nepali Lyrics')
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
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            transition: background 0.3s;
        }

        .social-links a:hover {
            background: rgba(255, 255, 255, 0.3);
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
    </style>

    {{-- Artist Header --}}
    <div class="artist-header">
        <div class="artist-avatar">
            {{ substr($artist->name_english, 0, 1) }}
        </div>
        <div class="artist-info">
            <h1>{{ $artist->name_english }}</h1>
            <div class="subtitle">{{ $artist->name_nepali }}</div>
            <div style="font-size: 0.95rem; opacity: 0.9;">
                <i class="fa-solid fa-music"></i> {{ $artist->songs->count() }} songs | <i class="fa-solid fa-eye"></i>
                {{ number_format($artist->views_count) }} views
                @if($artist->is_verified)
                    | <i class="fa-solid fa-circle-check" style="color: #4ade80;"></i> Verified
                @endif
            </div>

            @if($artist->social_links)
                <div class="social-links">
                    @if(isset($artist->social_links['youtube']))
                        <a href="{{ $artist->social_links['youtube'] }}" target="_blank"><i class="fa-brands fa-youtube"></i>
                            YouTube</a>
                    @endif
                    @if(isset($artist->social_links['facebook']))
                        <a href="{{ $artist->social_links['facebook'] }}" target="_blank"><i class="fa-brands fa-facebook"></i>
                            Facebook</a>
                    @endif
                    @if(isset($artist->social_links['instagram']))
                        <a href="{{ $artist->social_links['instagram'] }}" target="_blank"><i class="fa-brands fa-instagram"></i>
                            Instagram</a>
                    @endif
                    @if(isset($artist->social_links['spotify']))
                        <a href="{{ $artist->social_links['spotify'] }}" target="_blank"><i class="fa-brands fa-spotify"></i>
                            Spotify</a>
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

    {{-- Top Songs --}}
    <div class="songs-section">
        <h2>Top Songs by {{ $artist->name_english }}</h2>
        <div class="songs-grid">
            @forelse($topSongs as $song)
                <a href="{{ route('song.show', [$artist->slug, $song->slug]) }}" class="song-item">
                    <div class="song-item-title">{{ $song->title_nepali }}</div>
                    <div class="song-item-meta">
                        {{ $song->title_english }}
                        @if($song->year) | <i class="fa-solid fa-calendar-days"></i> {{ $song->year }} @endif
                        | <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }} views
                    </div>
                </a>
            @empty
                <p style="color: #718096;">No songs available.</p>
            @endforelse
        </div>
    </div>

    {{-- Albums --}}
    @if($albums->count() > 0)
        <div class="songs-section" style="margin-top: 2rem;">
            <h2>Albums</h2>
            <div
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                @foreach($albums as $album)
                    <div
                        style="padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px;">
                        <div style="font-weight: 600; font-size: 1.1rem;">{{ $album->name }}</div>
                        @if($album->year)
                            <div style="opacity: 0.9; font-size: 0.9rem;">{{ $album->year }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection
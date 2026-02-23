@extends('layouts.app')

@section('title', $album->name . ' - Album by ' . $album->artist->name_english)

@section('description', 'Listen to and view lyrics for songs from the album ' . $album->name . ' by ' . $album->artist->name_english . '.')

@section('canonical', route('album.show', $album->slug))

@section('og_title', $album->name . ' - ' . $album->artist->name_english)
@section('og_description', 'View all songs from the album ' . $album->name)
@section('og_type', 'music.album')
@if($album->cover_image)
@section('og_image', asset($album->cover_image))
@endif

@push('structured-data')
    <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "MusicAlbum",
                        "name": "{{ $album->name }}",
                        "byArtist": {
                            "@type": "MusicGroup",
                            "name": "{{ $album->artist->name_english }}"
                        },
                        @if($album->cover_image)
                            "image": "{{ asset($album->cover_image) }}",
                        @endif
                        @if($album->year)
                            "datePublished": "{{ $album->year }}",
                        @endif
                        "track": [
                            @foreach($album->songs as $index => $song)
                                {
                                    "@type": "MusicRecording",
                                    "name": "{{ $song->title_english }}",
                                    "alternateName": "{{ $song->title_nepali }}",
                                    "position": {{ $index + 1 }},
                                    "url": "{{ route('song.show', [$song->artist->slug, $song->slug]) }}"
                                }{{ $loop->last ? '' : ',' }}
                            @endforeach
                        ],
                        "url": "{{ route('album.show', $album->slug) }}"
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
                            "name": "Albums",
                            "item": "{{ route('album.index') }}"
                        },{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "{{ $album->name }}",
                            "item": "{{ route('album.show', $album->slug) }}"
                        }]
                    }
                    </script>
@endpush

@section('content')
    <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- Album Sidebar / Info --}}
        <div class="col-md-4" style="flex: 1; min-width: 300px; max-width: 400px;">
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;">
                @if($album->cover_image)
                    <img src="{{ asset($album->cover_image) }}" alt="{{ $album->name }}"
                        style="width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem;"
                        loading="lazy" decoding="async">
                @else
                    <div
                        style="width: 100%; aspect-ratio: 1; background: #f1f5f9; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 1.5rem; font-size: 4rem; color: #cbd5e0;">
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                @endif

                <h1 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 0.5rem;">{{ $album->name }}</h1>
                <div style="font-size: 1.1rem; color: #667eea; margin-bottom: 1rem;">
                    <a href="{{ route('artist.show', $album->artist->slug) }}"
                        style="text-decoration: none; color: inherit;">
                        By {{ $album->artist->name_english }}
                    </a>
                </div>

                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 1.5rem;">
                    @if($album->year) <i class="fa-solid fa-calendar-days"></i> {{ $album->year }} <br> @endif
                    <i class="fa-solid fa-music"></i> {{ $album->songs_count }} Songs
                </div>

                @if($album->description)
                    <p style="color: #4a5568; font-size: 0.95rem; line-height: 1.6; text-align: left;">
                        {{ $album->description }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Song List --}}
        <div class="col-md-8" style="flex: 2; min-width: 300px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #2d3748; display: flex; align-items: center;">
                <i class="fa-solid fa-list-ol" style="margin-right: 10px; color: #667eea;"></i> Tracklist
            </h2>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                @forelse($album->songs as $index => $song)
                    <a href="{{ route('song.show', [$album->artist->slug, $song->slug]) }}"
                        style="display: flex; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid #edf2f7; text-decoration: none; color: inherit; transition: background 0.2s;">
                        <span style="width: 30px; color: #a0aec0; font-weight: 600;">{{ $index + 1 }}</span>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                {{ $song->title_nepali }}
                                @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                    <span
                                        style="font-size: 0.7rem; background: #e2e8f0; color: #4a5568; padding: 2px 6px; border-radius: 4px; vertical-align: middle; margin-left: 5px;">
                                        <i class="fa-solid fa-clock"></i> Coming Soon
                                    </span>
                                @endif
                            </div>
                            <div style="font-size: 0.9rem; color: #718096;">{{ $song->title_english }}</div>
                        </div>
                        <div style="color: #cbd5e0;">
                            <i class="fa-solid fa-circle-play" style="font-size: 1.5rem; color: #667eea;"></i>
                        </div>
                    </a>
                @empty
                    <div style="padding: 2rem; text-align: center; color: #718096;">
                        No songs listed in this album yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
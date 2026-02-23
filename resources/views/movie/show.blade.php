@extends('layouts.app')

@section('title', $movie->name . ' - Movie Songs')

@section('description', 'Listen to and view lyrics for songs from the movie ' . $movie->name . '.')

@section('canonical', route('movie.show', $movie->slug))

@section('og_title', $movie->name . ' - Movie Songs')
@section('og_description', 'View all songs from the movie ' . $movie->name)
@section('og_type', 'video.movie')
@if($movie->cover_image)
@section('og_image', asset($movie->cover_image))
@endif

@push('structured-data')
    <script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "Movie",
                    "name": "{{ $movie->name }}",
                    @if($movie->cover_image)
                        "image": "{{ asset($movie->cover_image) }}",
                    @endif
                    @if($movie->year)
                        "datePublished": "{{ $movie->year }}",
                    @endif
                    @if($movie->description)
                        "description": "{{ $movie->description }}",
                    @endif
                    "url": "{{ route('movie.show', $movie->slug) }}"
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
                        "name": "Movies",
                        "item": "{{ route('movie.index') }}"
                    },{
                        "@type": "ListItem",
                        "position": 3,
                        "name": "{{ $movie->name }}",
                        "item": "{{ route('movie.show', $movie->slug) }}"
                    }]
                }
                </script>
@endpush

@section('content')
    <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- Movie Sidebar / Info --}}
        <div class="col-md-4" style="flex: 1; min-width: 300px; max-width: 400px;">
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center;">
                @if($movie->cover_image)
                    <img src="{{ asset($movie->cover_image) }}" alt="{{ $movie->name }}"
                        style="width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem;">
                @else
                    <div
                        style="width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 1.5rem; font-size: 4rem; color: white;">
                        <i class="fa-solid fa-clapperboard"></i>
                    </div>
                @endif

                <h1 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 0.5rem;">{{ $movie->name }}</h1>

                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 1.5rem;">
                    @if($movie->year)
                        <i class="fa-solid fa-calendar-days"></i> {{ $movie->year }} <br>
                    @endif
                    <i class="fa-solid fa-music"></i> {{ $movie->songs_count }} Songs
                </div>

                @if($movie->description)
                    <p style="color: #4a5568; font-size: 0.95rem; line-height: 1.6; text-align: left;">
                        {{ $movie->description }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Song List --}}
        <div class="col-md-8" style="flex: 2; min-width: 300px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #2d3748; display: flex; align-items: center;">
                <i class="fa-solid fa-list-ol" style="margin-right: 10px; color: #667eea;"></i> Songs from this Movie
            </h2>

            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                @forelse($songs as $index => $song)
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
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
                            <div style="font-size: 0.9rem; color: #718096;">
                                <i class="fa-solid fa-microphone" style="font-size: 0.75rem;"></i>
                                {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                                @if($song->genre)
                                    · <i class="fa-solid fa-music" style="font-size: 0.75rem;"></i> {{ $song->genre->name }}
                                @endif
                            </div>
                        </div>
                        <div style="color: #cbd5e0;">
                            <i class="fa-solid fa-circle-play" style="font-size: 1.5rem; color: #667eea;"></i>
                        </div>
                    </a>
                @empty
                    <div style="padding: 2rem; text-align: center; color: #718096;">
                        No songs listed in this movie yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
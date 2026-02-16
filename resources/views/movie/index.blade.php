@extends('layouts.app')

@section('title', 'Movies')

@section('description', 'Browse all Nepali movies with song lyrics available.')

@section('content')
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; color: #2d3748; margin-bottom: 0.5rem;">
            <i class="fa-solid fa-clapperboard" style="color: #667eea;"></i> Movies
        </h1>
        <p style="color: #718096;">Browse songs from Nepali movies</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
        @forelse($movies as $movie)
            <a href="{{ route('movie.show', $movie->slug) }}"
                style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.2s, box-shadow 0.2s; display: block;">
                @if($movie->cover_image)
                    <img src="{{ asset($movie->cover_image) }}" alt="{{ $movie->name }}"
                        style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                @else
                    <div
                        style="width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                        <i class="fa-solid fa-clapperboard"></i>
                    </div>
                @endif
                <div style="padding: 1rem;">
                    <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.25rem;">{{ $movie->name }}</div>
                    <div style="font-size: 0.875rem; color: #718096;">
                        @if($movie->year)
                            <i class="fa-solid fa-calendar-days"></i> {{ $movie->year }} ·
                        @endif
                        <i class="fa-solid fa-music"></i> {{ $movie->songs_count }} songs
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #718096;">
                <i class="fa-solid fa-clapperboard"
                    style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                No movies found.
            </div>
        @endforelse
    </div>

    @if($movies->hasPages())
        <div style="margin-top: 2rem;">
            {{ $movies->links() }}
        </div>
    @endif
@endsection
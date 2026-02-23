@extends('layouts.app')

@section('title', $genre->name . ' Songs')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .songs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .song-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.3s;
        }

        .song-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <div class="page-header">
        <h1>
            <i class="fa-solid fa-guitar" style="margin-right: 0.5rem;"></i>
            {{ $genre->name }} Songs
        </h1>
        @if($genre->description)
            <p style="opacity: 0.9; margin-top: 0.5rem;">
                <i class="fa-solid fa-circle-info" style="margin-right: 0.3rem;"></i>
                {{ $genre->description }}
            </p>
        @endif
        <p style="opacity: 0.9; margin-top: 0.5rem;">
            <i class="fa-solid fa-music" style="margin-right: 0.3rem;"></i>
            {{ $songs->total() }} songs in this genre
        </p>
    </div>

    <div class="songs-grid">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                class="song-card">
                <div style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: #2d3748;">
                    {{ $song->title_nepali }}
                    @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                        <div
                            style="font-size: 0.75rem; background: #e2e8f0; color: #4a5568; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-left: 5px;">
                            <i class="fa-solid fa-clock"></i> Coming Soon
                        </div>
                    @endif
                </div>
                <div style="color: #667eea; margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-microphone" style="margin-right: 0.2rem; font-size: 0.8rem;"></i>
                    {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                </div>
                <div style="font-size: 0.85rem; color: #718096;">
                    <i class="fa-solid fa-eye" style="margin-right: 0.2rem;"></i>
                    {{ number_format($song->views_count) }} views
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; color: #718096; text-align: center; padding: 3rem;">
                <i class="fa-solid fa-music" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                <p>No songs found in this genre.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 3rem;">
        {{ $songs->links() }}
    </div>

@endsection
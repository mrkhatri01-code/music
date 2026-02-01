@extends('layouts.app')

@section('title', $genre->name . ' Songs - Nepali Lyrics')

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
        <h1>{{ $genre->name }} Songs</h1>
        @if($genre->description)
            <p style="opacity: 0.9; margin-top: 0.5rem;">{{ $genre->description }}</p>
        @endif
        <p style="opacity: 0.9; margin-top: 0.5rem;">{{ $songs->total() }} songs in this genre</p>
    </div>

    <div class="songs-grid">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [$song->artist->slug, $song->slug]) }}" class="song-card">
                <div style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: #2d3748;">
                    {{ $song->title_nepali }}
                </div>
                <div style="color: #667eea; margin-bottom: 0.5rem;">{{ $song->artist->name_english }}</div>
                <div style="font-size: 0.85rem; color: #718096;">
                    👁 {{ number_format($song->views_count) }} views
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No songs found in this genre.</p>
        @endforelse
    </div>

    <div style="margin-top: 3rem;">
        {{ $songs->links() }}
    </div>

@endsection
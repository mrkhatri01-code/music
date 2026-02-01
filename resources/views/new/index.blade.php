@extends('layouts.app')

@section('title', 'New Nepali Songs - Latest Releases')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2.5rem;
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

        .song-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .song-artist {
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .song-meta {
            font-size: 0.85rem;
            color: #718096;
        }
    </style>

    <div class="page-header">
        <h1>New Nepali Songs</h1>
        @if(isset($year))
            <p style="opacity: 0.9;">Released in {{ $year }}</p>
        @else
            <p style="opacity: 0.9;">Latest releases</p>
        @endif
    </div>

    <div class="songs-grid">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [$song->artist->slug, $song->slug]) }}" class="song-card">
                <div class="song-title">{{ $song->title_nepali }}</div>
                <div class="song-artist">{{ $song->artist->name_english }}</div>
                <div class="song-meta">
                    {{ $song->created_at->diffForHumans() }}
                    @if($song->year) | {{ $song->year }} @endif
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No new songs found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 3rem; text-align: center;">
        {{ $songs->links() }}
    </div>

@endsection
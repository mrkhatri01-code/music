@extends('layouts.app')

@section('title', $title)

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
            color inherit;
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
        <h1><i class="fa-solid fa-fire" style="margin-right: 10px;"></i>{{ $title }}</h1>
        <p style="opacity: 0.9;">{{ $songs->total() }} songs</p>
    </div>

    <div class="songs-grid">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}" class="song-card">
                <div class="song-title">
                    {{ $song->title_nepali }}
                    @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                        <span
                            style="font-size: 0.75rem; color: #f59e0b; vertical-align: middle; margin-left: 5px; font-weight: normal;">
                            <i class="fa-solid fa-clock"></i> Coming Soon
                        </span>
                    @endif
                </div>
                <div class="song-artist">{{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}</div>
                <div class="song-meta">
                    @if($song->genre) <i class="fa-solid fa-music"></i> {{ $song->genre->name }} @endif
                    @if($song->release_date)
                        | <i class="fa-solid fa-calendar-days"></i> {{ $song->release_date->format('d M, Y') }}
                    @elseif($song->year)
                        | <i class="fa-solid fa-calendar-days"></i> {{ $song->year }}
                    @endif
                    | <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }} views
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No songs found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 3rem; text-align: center;">
        {{ $songs->links() }}
    </div>

@endsection
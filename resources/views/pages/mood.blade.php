@extends('layouts.app')

@section('title', $title . ' - Nepali Lyrics')
@section('description', $description)

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
        <h1 style="font-size: 2.5rem;">{{ $title }}</h1>
        <p style="opacity: 0.9; margin-top: 0.5rem;">{{ $description }}</p>
    </div>

    <div class="songs-grid">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                class="song-card">
                <div style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: #2d3748;">
                    {{ $song->title_nepali }}
                </div>
                <div style="color: #f5576c; margin-bottom: 0.5rem;">
                    {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}</div>
                <div style="font-size: 0.85rem; color: #718096;">
                    👁 {{ number_format($song->views_count) }} views
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No songs found in this collection.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($songs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div style="margin-top: 3rem;">
            {{ $songs->links() }}
        </div>
    @endif

@endsection
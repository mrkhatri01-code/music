@extends('layouts.app')

@section('title', 'All Albums')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .albums-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .album-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
            display: block;
            transition: transform 0.3s;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .album-card:hover {
            transform: translateY(-5px);
        }

        .album-cover-placeholder {
            height: 200px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #bdc3c7;
        }

        .album-content {
            padding: 1.5rem;
        }

        .album-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .album-artist {
            color: #667eea;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .album-meta {
            font-size: 0.85rem;
            color: #718096;
            margin-top: auto;
        }
    </style>

    <div class="page-header">
        <h1><i class="fa-solid fa-compact-disc" style="margin-right: 10px;"></i>All Albums</h1>
        <p style="opacity: 0.9;">Browse latest Nepali music albums</p>
    </div>

    <div class="albums-grid">
        @forelse($albums as $album)
            <a href="{{ route('album.show', $album->slug) }}" class="album-card">
                @if($album->cover_image)
                    <img src="{{ asset($album->cover_image) }}" alt="{{ $album->name }}"
                        style="height: 200px; width: 100%; object-fit: cover;">
                @else
                    <div class="album-cover-placeholder">
                        <i class="fa-solid fa-compact-disc"></i>
                    </div>
                @endif

                <div class="album-content">
                    <div class="album-title">{{ $album->name }}</div>
                    <div class="album-artist">{{ $album->artist->name_english }}</div>
                    <div class="album-meta">
                        @if($album->year) <i class="fa-solid fa-calendar-days"></i> {{ $album->year }} | @endif
                        <i class="fa-solid fa-music"></i> {{ $album->songs_count }} songs
                    </div>
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No albums found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 3rem; text-align: center;">
        {{ $albums->links() }}
    </div>

@endsection
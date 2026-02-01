@extends('layouts.app')

@section('title', 'All Genres - Nepali Lyrics')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .genres-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .genre-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: transform 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .genre-card:hover {
            transform: translateY(-5px);
        }
    </style>

    <div class="page-header">
        <h1>All Genres</h1>
        <p style="opacity: 0.9;">Browse songs by genre</p>
    </div>

    <div class="genres-grid">
        @forelse($genres as $genre)
            <a href="{{ route('genre.show', $genre->slug) }}" class="genre-card">
                <div style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem;">{{ $genre->name }}</div>
                <div style="opacity: 0.9;">{{ $genre->songs_count ?? 0 }} songs</div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No genres found.</p>
        @endforelse
    </div>

@endsection
@extends('layouts.app')

@section('title', 'Top Artists')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .artists-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .artist-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s;
        }

        .artist-card:hover {
            transform: scale(1.05);
        }

        .artist-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 600;
        }
    </style>

    <div class="page-header">
        <h1><i class="fa-solid fa-star" style="margin-right: 10px;"></i>Top Artists</h1>
        <p style="opacity: 0.9;">Most popular Nepali artists</p>
    </div>

    <div class="artists-grid">
        @forelse($artists as $artist)
            <a href="{{ route('artist.show', $artist->slug) }}" class="artist-card">
                <div class="artist-avatar"
                    style="{{ $artist->profile_image_url ? 'background: none; padding: 0; overflow: hidden;' : '' }}">
                    @if($artist->profile_image_url)
                        <img src="{{ $artist->profile_image_url }}" alt="{{ $artist->name_english }}"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        {{ substr($artist->name_english, 0, 1) }}
                    @endif
                </div>
                <div style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">{{ $artist->name_english }}</div>
                <div style="color: #718096; font-size: 0.9rem; margin-bottom: 0.5rem;">{{ $artist->name_nepali }}</div>
                <div style="color: #667eea; font-size: 0.85rem;">
                    <i class="fa-solid fa-music"></i> {{ $artist->songs_count ?? 0 }} songs
                    | <i class="fa-solid fa-eye"></i> {{ number_format($artist->views_count) }}
                </div>
            </a>
        @empty
            <p style="grid-column: 1 / -1; color: #718096;">No artists found.</p>
        @endforelse
    </div>

    <div style="margin-top: 3rem;">
        {{ $artists->links() }}
    </div>

@endsection
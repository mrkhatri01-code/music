@extends('layouts.app')

@section('title', 'Explore Music Genres')

@section('content')
    <div class="genre-header">
        <div class="header-content">
            <h1 class="page-title">Explore Genres</h1>
            <p class="page-subtitle">Discover the diverse world of Nepali music through our curated collections.</p>
            <div class="genre-count-badge">
                <i class="fa-solid fa-music"></i>
                <span>{{ $genres->count() }} Genres Available</span>
            </div>
        </div>
    </div>

    <div class="genre-grid">
        @forelse($genres as $genre)
            <a href="{{ route('genre.show', $genre->slug) }}" class="genre-card">
                <div class="card-content">
                    <div class="genre-icon-wrapper">
                        <i class="fa-solid fa-guitar"></i>
                    </div>
                    <div class="genre-details">
                        <h3 class="genre-name">{{ $genre->name }}</h3>
                        <span class="song-count">
                            {{ $genre->songs_count ?? 0 }} Songs
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="empty-state">
                    <i class="fa-solid fa-music fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">No genres found yet.</h3>
                    <p class="text-muted">Check back later for new additions!</p>
                </div>
            </div>
        @endforelse
    </div>

    <style>
        /* Header Section */
        .genre-header {
            text-align: center;
            padding: 4rem 1rem 3rem;
            position: relative;
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #718096;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .genre-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: white;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            color: #4a5568;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid #edf2f7;
        }

        .genre-count-badge i {
            color: #667eea;
        }

        /* Grid Layout */
        .genre-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
            padding-bottom: 5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Card Styles */
        .genre-card {
            position: relative;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            aspect-ratio: 1/1;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .genre-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            /* Default Gradient */
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        /* Dynamic Gradients using nth-child */
        .genre-card:nth-child(4n+1)::before {
            background: linear-gradient(135deg, #FF9A9E 0%, #FECFEF 100%);
            /* Pink/Pastel */
        }

        .genre-card:nth-child(4n+2)::before {
            background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
            /* Purple/Pink */
        }

        .genre-card:nth-child(4n+3)::before {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            /* Green/Blue */
        }

        .genre-card:nth-child(4n+4)::before {
            background: linear-gradient(135deg, #fccb90 0%, #d57eeb 100%);
            /* Orange/Purple */
        }

        /* Darker text version for light backgrounds, or white text for dark backgrounds */
        /* Let's go with a consistent colorful approach */
        .genre-card:nth-child(4n+1)::before {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);
        }

        .genre-card:nth-child(4n+2)::before {
            background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .genre-card:nth-child(4n+3)::before {
            background: linear-gradient(120deg, #d4fc79 0%, #96e6a1 100%);
        }

        .genre-card:nth-child(4n+4)::before {
            background: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);
        }

        /* Making them more vibrant/darker for white text contrast */
        .genre-card:nth-child(1n)::before {
            background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
        }

        .genre-card:nth-child(2n)::before {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .genre-card:nth-child(3n)::before {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
        }

        .genre-card:nth-child(4n)::before {
            background: linear-gradient(135deg, #F97794 0%, #623AA2 100%);
        }

        .genre-card:nth-child(5n)::before {
            background: linear-gradient(135deg, #FCCF31 0%, #F55555 100%);
        }

        .genre-card:nth-child(6n)::before {
            background: linear-gradient(135deg, #9796f0 0%, #fbc7d4 100%);
        }


        .card-content {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .genre-icon-wrapper {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .genre-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 0.02em;
        }

        .song-count {
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            backdrop-filter: blur(4px);
            font-weight: 500;
        }

        /* Hover Effects */
        .genre-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .genre-card:hover::before {
            opacity: 1;
            filter: brightness(1.05);
        }

        .genre-card:hover .genre-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }

            .genre-grid {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columns on mobile */
                gap: 1rem;
            }

            .genre-name {
                font-size: 1.2rem;
            }

            .genre-icon-wrapper {
                font-size: 2.5rem;
            }
        }
    </style>
@endsection
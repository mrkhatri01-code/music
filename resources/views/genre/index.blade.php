@extends('layouts.app')

@section('title', 'Explore Music Genres')

@section('content')
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h1 class="display-4 font-weight-bold text-dark mb-2">Explore Genres</h1>
            <p class="lead text-muted">Discover the diverse world of Nepali music through our curated genre collections.</p>
        </div>
        <div class="col-md-4 text-md-right">
            <div class="d-inline-flex align-items-center px-3 py-2 bg-white rounded-pill shadow-sm">
                <i class="fa-solid fa-music text-primary mr-2"></i>
                <span class="font-weight-bold text-dark">{{ $genres->count() }} Genres Available</span>
            </div>
        </div>
    </div>

    <div class="genre-grid">
        @forelse($genres as $genre)
            <a href="{{ route('genre.show', $genre->slug) }}" class="genre-card">
                <div class="genre-icon">
                    <i class="fa-solid fa-guitar"></i> <!-- Default icon, could be dynamic based on genre name -->
                </div>
                <div class="genre-info">
                    <h3 class="genre-name">{{ $genre->name }}</h3>
                    <div class="genre-stats">
                        <span class="badge badge-light">
                            <i class="fa-solid fa-music mr-1"></i> {{ $genre->songs_count ?? 0 }} Songs
                        </span>
                    </div>
                </div>
                <div class="genre-overlay"></div>
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
        .genre-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding-bottom: 3rem;
        }

        .genre-card {
            position: relative;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .genre-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .genre-icon {
            height: 140px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 3.5rem;
            position: relative;
            z-index: 1;
        }

        /* Specific gradients for variety (optional, using nth-child) */
        .genre-card:nth-child(3n+1) .genre-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .genre-card:nth-child(3n+2) .genre-icon {
            background: linear-gradient(135deg, #FF6B6B 0%, #FFE66D 100%);
        }

        /* Red-Yellow */
        .genre-card:nth-child(3n+3) .genre-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        /* Blue-Cyan */

        .genre-card:nth-child(3n+2) .genre-icon {
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Override specifically for better contrast if needed, but white usually works */


        .genre-info {
            padding: 1.5rem;
            background: white;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .genre-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .genre-stats .badge {
            font-size: 0.85rem;
            padding: 0.4em 0.8em;
            color: #4a5568;
            background-color: #f7fafc;
            border: 1px solid #edf2f7;
        }

        .genre-card:hover .genre-name {
            color: #667eea;
        }

        /* Responsive Tweaks */
        @media (max-width: 768px) {
            .genre-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 1rem;
            }

            .genre-icon {
                height: 100px;
                font-size: 2.5rem;
            }

            .genre-info {
                padding: 1rem;
            }

            .genre-name {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection
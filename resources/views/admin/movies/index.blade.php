@extends('admin.layout')

@section('title', 'Movies')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-clapperboard" style="color: var(--color-primary);"></i>
                Movies Management
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Manage movies and their associated songs</p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form action="{{ route('admin.movies.index') }}" method="GET">
                <div style="position: relative;">
                    <input type="text" name="q" placeholder="Search movies..." value="{{ request('q') }}"
                        style="padding: 0.5rem 1rem 0.5rem 2.2rem; border: 1px solid var(--color-border); border-radius: 99px; font-size: 0.875rem; width: 250px; outline: none;">
                    <i class="fa-solid fa-magnifying-glass"
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-text-secondary); font-size: 0.8rem;"></i>
                </div>
            </form>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary"
                style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-plus"></i> Add New Movie
            </a>
        </div>
    </div>

    {{-- Stats Summary Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);">
                <i class="fa-solid fa-clapperboard"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Movies</div>
                <div class="stat-mini-value">{{ number_format($movies->total()) }}</div>
            </div>
        </div>
        
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Songs</div>
                <div class="stat-mini-value">{{ number_format($movies->sum('songs_count')) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Movies</h2>
            <div style="display: flex; gap: 0.5rem;">
                <span class="badge badge-info">{{ $movies->total() }} total</span>
            </div>
        </div>
        
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Cover</th>
                        <th style="width: 30%;">Movie Name</th>
                        <th>Year</th>
                        <th>Songs</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                        <tr>
                            <td>
                                @if($movie->cover_image)
                                    <img src="{{ asset($movie->cover_image) }}" 
                                         alt="Cover" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                @else
                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; color: white;">
                                        <i class="fa-solid fa-clapperboard" style="font-size: 1.25rem;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary);">
                                    {{ $movie->name }}
                                </div>
                            </td>
                            <td>
                                @if($movie->year)
                                    <span style="color: var(--color-text-secondary);">{{ $movie->year }}</span>
                                @else
                                    <span style="color: var(--color-text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <i class="fa-solid fa-music"></i> {{ $movie->songs_count }} songs
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" 
                                       class="btn-icon" 
                                       style="background: #dbeafe; color: #1e40af;"
                                       title="Edit movie">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-icon" 
                                                style="background: #fee2e2; color: #991b1b;"
                                                title="Delete movie">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state-table">
                                <i class="fa-solid fa-clapperboard"></i>
                                <p>No movies found</p>
                                <a href="{{ route('admin.movies.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i class="fa-solid fa-plus"></i> Add Your First Movie
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movies->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $movies->links() }}
            </div>
        @endif
    </div>

@endsection

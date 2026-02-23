@extends('admin.layout')

@section('title', 'Manage Albums')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-compact-disc" style="color: var(--color-primary);"></i>
                Albums Management
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Create and manage music albums and compilations</p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form action="{{ route('admin.albums.index') }}" method="GET">
                <div style="position: relative;">
                    <input type="text" name="q" placeholder="Search albums..." value="{{ request('q') }}"
                        style="padding: 0.5rem 1rem 0.5rem 2.2rem; border: 1px solid var(--color-border); border-radius: 99px; font-size: 0.875rem; width: 250px; outline: none;">
                    <i class="fa-solid fa-magnifying-glass"
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-text-secondary); font-size: 0.8rem;"></i>
                </div>
            </form>
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-plus"></i> Add New Album
            </a>
        </div>
    </div>

    {{-- Stats Summary Cards --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fa-solid fa-compact-disc"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Albums</div>
                <div class="stat-mini-value">{{ number_format($albums->total()) }}</div>
            </div>
        </div>
        
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Songs</div>
                <div class="stat-mini-value">{{ number_format($albums->sum('songs_count')) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Albums</h2>
            <div style="display: flex; gap: 0.5rem;">
                <span class="badge badge-info">{{ $albums->total() }} total</span>
            </div>
        </div>
        
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Cover</th>
                        <th style="width: 30%;">Album Name</th>
                        <th>Artist</th>
                        <th>Year</th>
                        <th>Songs</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $album)
                        <tr>
                            <td>
                                @if($album->cover_image)
                                    <img src="{{ asset($album->cover_image) }}" 
                                         alt="Cover" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                @else
                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #94a3b8;">
                                        <i class="fa-solid fa-compact-disc" style="font-size: 1.25rem;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary);">
                                    {{ $album->name }}
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fa-solid fa-user" style="color: var(--color-text-muted); font-size: 0.75rem;"></i>
                                    @if($album->artist)
                                        <a href="{{ route('admin.artists.edit', $album->artist->id) }}" 
                                           style="color: var(--color-primary); text-decoration: none;">
                                            {{ $album->artist->name_english }}
                                        </a>
                                    @else
                                        <span style="color: var(--color-text-muted); font-style: italic;">Unknown Artist (ID: {{ $album->artist_id ?? 'N/A' }})</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($album->year)
                                    <span style="color: var(--color-text-secondary);">{{ $album->year }}</span>
                                @else
                                    <span style="color: var(--color-text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <i class="fa-solid fa-music"></i> {{ $album->songs_count }} songs
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.albums.edit', $album->id) }}" 
                                       class="btn-icon" 
                                       style="background: #dbeafe; color: #1e40af;"
                                       title="Edit album">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-icon" 
                                                style="background: #fee2e2; color: #991b1b;"
                                                title="Delete album">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state-table">
                                <i class="fa-solid fa-compact-disc"></i>
                                <p>No albums found</p>
                                <a href="{{ route('admin.albums.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i class="fa-solid fa-plus"></i> Create Your First Album
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($albums->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $albums->links() }}
            </div>
        @endif
    </div>

@endsection

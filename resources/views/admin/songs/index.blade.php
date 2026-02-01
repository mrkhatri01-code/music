@extends('admin.layout')

@section('title', 'Songs')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1
                style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-music" style="color: var(--color-primary);"></i>
                Songs Management
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Manage all songs, lyrics, and metadata</p>
        </div>
        <a href="{{ route('admin.songs.create') }}" class="btn btn-primary"
            style="display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-plus"></i> Add New Song
        </a>
    </div>

    {{-- Stats Summary Cards --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Songs</div>
                <div class="stat-mini-value">{{ number_format($songs->total()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="stat-mini-label">Published</div>
                <div class="stat-mini-value">{{ number_format($songs->where('is_published', 1)->count()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Views</div>
                <div class="stat-mini-value">{{ number_format($songs->sum('views_count')) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Songs</h2>
            <div style="display: flex; gap: 0.5rem;">
                <span class="badge badge-info">{{ $songs->total() }} total</span>
            </div>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Title</th>
                        <th>Artist</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($songs as $song)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.25rem;">
                                    {{ $song->title_nepali }}
                                </div>
                                <div style="font-size: 0.875rem; color: var(--color-text-secondary);">
                                    {{ $song->title_english }}
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fa-solid fa-user" style="color: var(--color-text-muted); font-size: 0.75rem;"></i>
                                    {{ $song->artist->name_english }}
                                </div>
                            </td>
                            <td>
                                @if($song->genre)
                                    <span class="badge badge-info" style="background: #f3f4f6; color: #4b5563;">
                                        {{ $song->genre->name }}
                                    </span>
                                @else
                                    <span style="color: var(--color-text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($song->year)
                                    <span style="color: var(--color-text-secondary);">{{ $song->year }}</span>
                                @else
                                    <span style="color: var(--color-text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }}
                                </span>
                            </td>
                            <td>
                                @if($song->is_published)
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-circle-check"></i> Published
                                    </span>
                                @else
                                    <span class="badge" style="background: #f3f4f6; color: #6b7280;">
                                        <i class="fa-solid fa-circle-dot"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('song.show', [$song->artist->slug, $song->slug]) }}" class="btn-icon"
                                        style="background: #e5e7eb; color: #4b5563;" target="_blank" title="View on site">
                                        <i class="fa-solid fa-external-link-alt"></i>
                                    </a>
                                    <a href="{{ route('admin.songs.edit', $song) }}" class="btn-icon"
                                        style="background: #dbeafe; color: #1e40af;" title="Edit song">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.songs.destroy', $song) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" style="background: #fee2e2; color: #991b1b;"
                                            title="Delete song">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state-table">
                                <i class="fa-solid fa-music"></i>
                                <p>No songs found</p>
                                <a href="{{ route('admin.songs.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i class="fa-solid fa-plus"></i> Add Your First Song
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($songs->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $songs->links() }}
            </div>
        @endif
    </div>

@endsection
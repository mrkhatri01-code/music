@extends('admin.layout')

@section('title', 'Artists')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1
                style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-microphone" style="color: var(--color-primary);"></i>
                Artists Management
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Manage artists, profiles, and verification
                status</p>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <form action="{{ route('admin.artists.index') }}" method="GET">
                <div style="position: relative;">
                    <input type="text" name="q" placeholder="Search artists..." value="{{ request('q') }}"
                        style="padding: 0.5rem 1rem 0.5rem 2.2rem; border: 1px solid var(--color-border); border-radius: 99px; font-size: 0.875rem; width: 250px; outline: none;">
                    <i class="fa-solid fa-magnifying-glass"
                        style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--color-text-secondary); font-size: 0.8rem;"></i>
                </div>
            </form>
            <a href="{{ route('admin.artists.create') }}" class="btn btn-primary"
                style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-user-plus"></i> Add New Artist
            </a>
        </div>
    </div>

    {{-- Stats Summary Cards --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fa-solid fa-microphone"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Artists</div>
                <div class="stat-mini-value">{{ number_format($artists->total()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="stat-mini-label">Verified</div>
                <div class="stat-mini-value">{{ number_format($artists->where('is_verified', 1)->count()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Songs</div>
                <div class="stat-mini-value">{{ number_format($artists->sum('songs_count')) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Artists</h2>
            <div style="display: flex; gap: 0.5rem;">
                <span class="badge badge-info">{{ $artists->total() }} total</span>
            </div>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Name (English)</th>
                        <th style="width: 25%;">Name (Nepali)</th>
                        <th>Songs</th>
                        <th>Views</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artists as $artist)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary);">
                                    {{ $artist->name_english }}
                                </div>
                            </td>
                            <td>
                                <div style="color: var(--color-text-secondary);">
                                    {{ $artist->name_nepali }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <i class="fa-solid fa-music"></i> {{ $artist->songs_count ?? 0 }} songs
                                </span>
                            </td>
                            <td>
                                <span class="badge" style="background: #fef3c7; color: #92400e;">
                                    <i class="fa-solid fa-eye"></i> {{ number_format($artist->views_count) }}
                                </span>
                            </td>
                            <td>
                                @if($artist->is_verified)
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-certificate"></i> Verified
                                    </span>
                                @else
                                    <span class="badge" style="background: #f3f4f6; color: #6b7280;">
                                        <i class="fa-solid fa-circle"></i> Not Verified
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                    <a href="{{ route('admin.artists.edit', $artist) }}" class="btn-icon"
                                        style="background: #dbeafe; color: #1e40af;" title="Edit artist">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" style="background: #fee2e2; color: #991b1b;"
                                            title="Delete artist">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state-table">
                                <i class="fa-solid fa-microphone"></i>
                                <p>No artists found</p>
                                <a href="{{ route('admin.artists.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i class="fa-solid fa-user-plus"></i> Add Your First Artist
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($artists->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $artists->links() }}
            </div>
        @endif
    </div>

@endsection
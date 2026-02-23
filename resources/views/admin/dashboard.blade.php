@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    {{-- Welcome Header --}}
    <div class="dashboard-header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Welcome back,
                {{ Auth::guard('admin')->user()->name }}! 👋
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 1rem;">Here's what's happening with your content today.
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.songs.create') }}" class="btn btn-primary"
                style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-plus"></i> Add New Song
            </a>
            <a href="{{ route('admin.artists.create') }}" class="btn"
                style="background: white; border: 2px solid var(--color-primary); color: var(--color-primary); display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-user-plus"></i> Add Artist
            </a>
        </div>
    </div>

    {{-- Enhanced Statistics Grid --}}
    <div class="stats-grid-modern">
        {{-- Total Songs --}}
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-music"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Songs</div>
                <div class="stat-value">{{ number_format($stats['total_songs']) }}</div>
            </div>
        </div>

        {{-- Published Songs --}}
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Published</div>
                <div class="stat-value">{{ number_format($stats['published_songs']) }}</div>
            </div>
        </div>

        {{-- Total Artists --}}
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-microphone"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Artists</div>
                <div class="stat-value">{{ number_format($stats['total_artists']) }}</div>
            </div>
        </div>

        {{-- Genres --}}
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-guitar"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Genres</div>
                <div class="stat-value">{{ number_format($stats['total_genres']) }}</div>
            </div>
        </div>

        {{-- Total Views --}}
        <div class="stat-card-modern" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Views</div>
                <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
            </div>
        </div>

        {{-- Pending Reports --}}
        <div class="stat-card-modern"
            style="background: linear-gradient(135deg, {{ $stats['pending_reports'] > 0 ? '#fc5c7d 0%, #6a82fb' : '#a8edea 0%, #fed6e3' }} 100%);">
            <div class="stat-icon">
                <i class="fa-solid fa-{{ $stats['pending_reports'] > 0 ? 'triangle-exclamation' : 'shield-check' }}"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">{{ $stats['pending_reports'] > 0 ? 'Pending Reports' : 'Reports' }}</div>
                <div class="stat-value">{{ number_format($stats['pending_reports']) }}</div>
            </div>
        </div>
    </div>

    {{-- Content Tables --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 2rem;">
        {{-- Recent Songs --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Songs</h2>
                <a href="{{ route('admin.songs.index') }}" class="view-all-link">View All <i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSongs as $song)
                            <tr onclick="window.location='{{ route('admin.songs.edit', $song) }}'" style="cursor: pointer;">
                                <td>
                                    <div style="font-weight: 600; color: var(--color-text-primary);">{{ $song->title_nepali }}
                                    </div>
                                    <div style="font-size: 0.875rem; color: var(--color-text-secondary);">
                                        {{ $song->title_english }}
                                    </div>
                                </td>
                                <td>
                                    @if($song->artist)
                                        {{ $song->artist->name_english }}
                                    @elseif($song->writer)
                                        {{ $song->writer->name_english }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state-table">
                                    <i class="fa-solid fa-music"></i>
                                    <p>No songs yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Songs --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <h2><i class="fa-solid fa-fire"></i> Top Songs by Views</h2>
                <a href="{{ route('admin.songs.index') }}" class="view-all-link">View All <i
                        class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSongs as $index => $song)
                            <tr onclick="window.location='{{ route('admin.songs.edit', $song) }}'" style="cursor: pointer;">
                                <td>
                                    <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--color-text-primary);">{{ $song->title_nepali }}
                                    </div>
                                </td>
                                <td>
                                    @if($song->artist)
                                        {{ $song->artist->name_english }}
                                    @elseif($song->writer)
                                        {{ $song->writer->name_english }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-chart-line"></i> {{ number_format($song->views_count) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state-table">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <p>No data yet</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pending Reports Alert --}}
    @if($pendingReports->count() > 0)
        <div class="card-modern" style="margin-top: 1.5rem; border-left: 4px solid #f56565;">
            <div class="card-header-modern">
                <h2><i class="fa-solid fa-flag"></i> Pending Reports ({{ $pendingReports->count() }})</h2>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm" style="background: #fee2e2; color: #c53030;">
                    View All Reports <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Song</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingReports as $report)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $report->song->title_nepali }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-danger">
                                        {{ ucfirst(str_replace('_', ' ', $report->type)) }}
                                    </span>
                                </td>
                                <td>{{ Str::limit($report->description, 50) }}</td>
                                <td style="color: var(--color-text-secondary);">{{ $report->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
@extends('artist.layout')

@section('title', 'Overview')

@section('content')
    <style>
        .welcome-section {
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-content h3 {
            margin: 0;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-secondary);
        }

        .stat-content .value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--color-text-primary);
            line-height: 1.2;
            margin-top: 0.25rem;
        }

        .recent-section {
            background: white;
            border-radius: var(--radius-xl);
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-text-secondary);
            border-bottom: 1px solid var(--color-border);
        }

        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--color-border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-published {
            background: #ecfdf5;
            color: #059669;
        }

        .status-pending {
            background: #fffbeb;
            color: #d97706;
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--color-text-secondary);
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            background: #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: #94a3b8;
        }
    </style>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--color-text-primary); margin-bottom: 0.5rem;">
            Welcome back, {{ Auth::user()->name }}! 👋
        </h1>
        <p style="color: var(--color-text-secondary); margin: 0;">Here's what's happening with your music today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Songs -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff1f2; color: var(--primary-color);">
                <i class="fa-solid fa-music"></i>
            </div>
            <div class="stat-content">
                <h3>Total Songs</h3>
                <div class="value">{{ number_format($songsCount) }}</div>
            </div>
        </div>

        <!-- Total Views -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div class="stat-content">
                <h3>Total Views</h3>
                <div class="value">{{ number_format($viewsCount) }}</div>
            </div>
        </div>

        <!-- Status -->
        <div class="stat-card">
            <div class="stat-icon"
                style="background: {{ $artist->is_verified ? '#ecfdf5' : '#fef2f2' }}; color: {{ $artist->is_verified ? '#10b981' : '#ef4444' }};">
                <i class="fa-solid {{ $artist->is_verified ? 'fa-check-circle' : 'fa-clock' }}"></i>
            </div>
            <div class="stat-content">
                <h3>Account Status</h3>
                <div class="value" style="font-size: 1.25rem; color: {{ $artist->is_verified ? '#10b981' : '#ef4444' }};">
                    {{ $artist->is_verified ? 'Verified' : 'Unverified' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Songs -->
    <div class="recent-section">
        <div class="section-header">
            <h3 class="section-title">Recent Uploads</h3>
            <a href="{{ route('artist.songs.index') }}" class="btn btn-outline"
                style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                View All
            </a>
        </div>

        @if($recentSongs->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th width="40%">Title</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSongs as $song)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--color-text-primary);">{{ $song->title_english }}
                                    </div>
                                    <div style="font-size: 0.85rem; color: var(--color-text-secondary); margin-top: 2px;">
                                        {{Str::limit($song->title_nepali, 30)}}</div>
                                </td>
                                <td style="color: var(--color-text-secondary);">
                                    <i class="fa-solid fa-eye" style="margin-right: 6px; font-size: 0.8em;"></i>
                                    {{ number_format($song->views_count) }}
                                </td>
                                <td>
                                    @if($song->is_published)
                                        <span class="status-badge status-published">Published</span>
                                    @else
                                        <span class="status-badge status-pending">Pending</span>
                                    @endif
                                </td>
                                <td style="color: var(--color-text-secondary); font-size: 0.9rem;">
                                    {{ $song->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fa-solid fa-music"></i>
                </div>
                <p style="margin-bottom: 1.5rem;">You haven't uploaded any songs yet.</p>
                <a href="{{ route('artist.songs.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Upload First Song
                </a>
            </div>
        @endif
    </div>
@endsection
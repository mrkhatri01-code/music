@extends('admin.layout')

@section('title', 'Reports')

@section('content')
    {{-- Modern Page Header --}}
    <div class="page-header-modern">
        <div>
            <h1
                style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-flag" style="color: var(--color-primary);"></i>
                User Reports
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 0.875rem;">Review and manage user-submitted reports</p>
        </div>
    </div>

    {{-- Stats Summary Cards --}}
    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #fc5c7d 0%, #6a82fb 100%);">
                <i class="fa-solid fa-flag"></i>
            </div>
            <div>
                <div class="stat-mini-label">Total Reports</div>
                <div class="stat-mini-value">{{ number_format($reports->total()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fa-solid fa-clock"></i>
            </div>
            <div>
                <div class="stat-mini-label">Pending</div>
                <div class="stat-mini-value">{{ number_format($reports->where('status', 'pending')->count()) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="stat-mini-label">Resolved</div>
                <div class="stat-mini-value">{{ number_format($reports->where('status', 'resolved')->count()) }}</div>
            </div>
        </div>
    </div>

    {{-- Modern Table Card --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> All Reports</h2>
            <div style="display: flex; gap: 0.5 rem; align-items: center;">
                {{-- Filter Dropdown --}}
                <form method="GET" action="{{ route('admin.reports.index') }}" style="margin: 0;">
                    <select name="type" onchange="this.form.submit()"
                        style="padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid var(--color-border); font-size: 0.875rem; cursor: pointer; background: white;">
                        <option value="">All Types</option>
                        <option value="copyright" {{ request('type') == 'copyright' ? 'selected' : '' }}>
                            <i class="fa-solid fa-copyright"></i> Copyright Claims
                        </option>
                        <option value="wrong_lyrics" {{ request('type') == 'wrong_lyrics' ? 'selected' : '' }}>
                            Wrong Lyrics
                        </option>
                    </select>
                </form>
                <span class="badge badge-info">{{ $reports->total() }} total</span>
            </div>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Song</th>
                        <th>Type</th>
                        <th style="width: 25%;">Description</th>
                        <th>Contact Info</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>
                                <a href="{{ route('song.show', [($report->song->artist ?? $report->song->writer)->slug ?? 'unknown', $report->song->slug]) }}"
                                    target="_blank"
                                    style="color: var(--color-primary); text-decoration: none; font-weight: 600;">
                                    {{ $report->song->title_nepali }}
                                </a>
                            </td>
                            <td>
                                @if($report->type == 'copyright')
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-copyright"></i> Copyright
                                    </span>
                                @elseif($report->type == 'wrong_lyrics')
                                    <span class="badge badge-warning">
                                        <i class="fa-solid fa-spell-check"></i> Wrong Lyrics
                                    </span>
                                @else
                                    <span class="badge" style="background: #f3f4f6; color: #6b7280;">
                                        <i class="fa-solid fa-exclamation"></i> {{ ucfirst(str_replace('_', ' ', $report->type)) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.875rem; color: var(--color-text-secondary);">
                                    {{ Str::limit($report->description, 60) }}
                                </div>
                            </td>
                            <td>
                                @if($report->type == 'copyright' && $report->claimant_name)
                                    <div style="font-size: 0.8rem;">
                                        <div style="font-weight: 600; color: var(--color-text-primary);">
                                            <i class="fa-solid fa-user" style="color: #667eea;"></i>
                                            {{ $report->claimant_name }}
                                        </div>
                                        <div style="color: var(--color-text-secondary); margin-top: 0.25rem;">
                                            <i class="fa-solid fa-envelope" style="color: #667eea;"></i>
                                            <a href="mailto:{{ $report->claimant_email }}"
                                                style="color: inherit; text-decoration: none;">
                                                {{ $report->claimant_email }}
                                            </a>
                                        </div>
                                        @if($report->claimant_phone)
                                            <div style="color: var(--color-text-secondary); margin-top: 0.25rem;">
                                                <i class="fa-solid fa-phone" style="color: #667eea;"></i>
                                                {{ $report->claimant_phone }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: var(--color-text-secondary); font-size: 0.875rem;">—</span>
                                @endif
                            </td>
                            <td style="color: var(--color-text-secondary);">
                                {{ $report->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                @if($report->status == 'pending')
                                    <span class="badge" style="background: #fef3c7; color: #92400e;">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @elseif($report->status == 'reviewed')
                                    <span class="badge badge-info">
                                        <i class="fa-solid fa-eye"></i> Reviewed
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-check-circle"></i> Resolved
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.reports.show', $report) }}" class="btn-icon"
                                        style="background: #e0e7ff; color: #4338ca; display: inline-flex; width: 32px; height: 32px; border-radius: 6px; align-items: center; justify-content: center; text-decoration: none;"
                                        title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.reports.update-status', $report) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()"
                                            style="padding: 0.5rem 0.75rem; border-radius: 6px; border: 1px solid var(--color-border); font-size: 0.875rem; cursor: pointer;">
                                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>
                                                Reviewed</option>
                                            <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>
                                                Resolved</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.reports.destroy', $report) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon" style="background: #fee2e2; color: #991b1b;"
                                            title="Delete report">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state-table">
                                <i class="fa-solid fa-flag"></i>
                                <p>No reports found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
            <div style="padding: 1.5rem; border-top: 1px solid var(--color-divider);">
                {{ $reports->appends(request()->all())->links() }}
            </div>
        @endif
    </div>

@endsection
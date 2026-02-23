@extends('admin.layout')

@section('title', 'Report Details')

@section('content')
    <div class="page-header-modern">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div>
                <h1
                    style="font-size: 1.875rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fa-solid fa-file-invoice" style="color: var(--color-primary);"></i>
                    Report Details
                </h1>
                <p style="color: var(--color-text-secondary); font-size: 0.875rem;">
                    Viewing details for report #{{ $report->id }}
                </p>
            </div>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary" style="background: white; border: 1px solid var(--color-border); color: var(--color-text-secondary);">
                <i class="fa-solid fa-arrow-left"></i> Back to Reports
            </a>
        </div>
    </div>

    <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- Main Details --}}
        <div style="flex: 2; min-width: 300px;">
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-circle-info"></i> Report Information</h2>
                    <div>
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
                    </div>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 0.5rem;">Report Type</label>
                        <div style="font-size: 1.1rem; color: var(--color-text-primary);">
                             @if($report->type == 'copyright')
                                <span class="badge badge-danger">
                                    <i class="fa-solid fa-copyright"></i> Copyright Claim
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
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 0.5rem;">Description / Reason</label>
                        <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border: 1px solid var(--color-border); color: var(--color-text-primary); line-height: 1.6;">
                            {{ $report->description }}
                        </div>
                    </div>

                    <div>
                         <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 0.5rem;">Date Submitted</label>
                         <div style="color: var(--color-text-primary);">
                             <i class="fa-regular fa-calendar"></i> {{ $report->created_at->format('F d, Y \a\t h:i A') }}
                             <span style="color: var(--color-text-secondary); font-size: 0.9rem;">({{ $report->created_at->diffForHumans() }})</span>
                         </div>
                    </div>
                </div>
            </div>

            {{-- Reported Content (Song) --}}
            <div class="card-modern" style="margin-top: 2rem;">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-music"></i> Reported Content</h2>
                </div>
                <div style="padding: 1.5rem; display: flex; gap: 1.5rem; align-items: flex-start;">
                    @if($report->song->cover_image)
                        <img src="{{ asset($report->song->cover_image) }}" alt="Cover" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    @else
                        <div style="width: 80px; height: 80px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 2rem; color: #cbd5e0;">
                            <i class="fa-solid fa-compact-disc"></i>
                        </div>
                    @endif
                    
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--color-text-primary);">
                            {{ $report->song->title_nepali }} <span style="font-weight: 400; font-size: 1rem; color: var(--color-text-secondary);">({{ $report->song->title_english }})</span>
                        </h3>
                        <div style="margin-bottom: 1rem; color: #667eea;">
                            <i class="fa-solid fa-microphone"></i> {{ $report->song->artist->name_english ?? $report->song->writer->name_english ?? 'Unknown Artist' }}
                        </div>
                        
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('song.show', [($report->song->artist ?? $report->song->writer)->slug ?? 'unknown', $report->song->slug]) }}" target="_blank" class="btn btn-primary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                <i class="fa-solid fa-external-link-alt"></i> View Song Page
                            </a>
                            <a href="{{ route('admin.songs.edit', $report->song->id) }}" class="btn btn-secondary" style="background: white; border: 1px solid var(--color-border); color: var(--color-text-secondary); font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                                <i class="fa-solid fa-pen"></i> Edit Song
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar (Claimant Info & Actions) --}}
        <div style="flex: 1; min-width: 300px;">
            {{-- Claimant Info --}}
             @if($report->claimant_name || $report->claimant_email)
            <div class="card-modern">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-user-shield"></i> Claimant Details</h2>
                </div>
                <div style="padding: 1.5rem;">
                    @if($report->claimant_name)
                    <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: #ebf4ff; color: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600;">Name</div>
                            <div style="color: var(--color-text-primary); font-weight: 500;">{{ $report->claimant_name }}</div>
                        </div>
                    </div>
                    @endif

                    @if($report->claimant_email)
                    <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 40px; height: 40px; background: #ebf4ff; color: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600;">Email</div>
                            <a href="mailto:{{ $report->claimant_email }}" style="color: var(--color-primary); text-decoration: none;">{{ $report->claimant_email }}</a>
                        </div>
                    </div>
                    @endif

                    @if($report->claimant_phone)
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                         <div style="width: 40px; height: 40px; background: #ebf4ff; color: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--color-text-secondary); text-transform: uppercase; font-weight: 600;">Phone</div>
                            <div style="color: var(--color-text-primary);">{{ $report->claimant_phone }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="card-modern" style="margin-top: 2rem;">
                <div class="card-header-modern">
                    <h2><i class="fa-solid fa-bolt"></i> Actions</h2>
                </div>
                <div style="padding: 1.5rem;">
                    <form action="{{ route('admin.reports.update-status', $report) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status" style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 0.5rem;">Update Status</label>
                            <select name="status" id="status" class="form-control" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--color-border); margin-bottom: 1rem;">
                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $report->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Status</button>
                    </form>

                    <div style="border-top: 1px solid var(--color-divider); margin: 1.5rem 0; padding-top: 1.5rem;">
                        <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center; background: #fee2e2; color: #991b1b;">
                                <i class="fa-solid fa-trash"></i> Delete Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

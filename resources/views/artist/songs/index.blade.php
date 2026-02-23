@extends('artist.layout')

@section('title', 'My Songs')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--color-text-primary); margin: 0;">My Songs</h2>
            <p style="color: var(--color-text-secondary); margin-top: 0.5rem;">Manage your music library</p>
        </div>
        <a href="{{ route('artist.songs.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Song
        </a>
    </div>

    @if(session('success'))
        <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f8fafc; border-bottom: 1px solid var(--color-border);">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem; width: 80px;">Cover</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Song Details</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Genre</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Views</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Date</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Actions</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid var(--color-border);">
                    @forelse($songs as $song)
                        <tr style="border-bottom: 1px solid var(--color-border);">
                            <td style="padding: 1rem 1.5rem;">
                                @if($song->cover_image)
                                    <img src="{{ asset($song->cover_image) }}" alt="Cover"
                                        style="width: 48px; height: 48px; border-radius: 6px; object-fit: cover;">
                                @else
                                    <div style="width: 48px; height: 48px; background-color: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                        <i class="fa-solid fa-music"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 600; color: var(--color-text-primary);">{{ $song->title_english }}</div>
                                <div style="color: var(--color-text-secondary); font-size: 0.875rem;">{{ $song->title_nepali }}</div>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: var(--color-text-secondary);">
                                {{ $song->genre->name ?? '-' }}
                            </td>
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: var(--color-text-primary);">
                                {{ number_format($song->views_count) }}
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                @if($song->is_published)
                                    <span style="background-color: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">Published</span>
                                @else
                                    <span style="background-color: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">Pending</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; color: var(--color-text-secondary); font-size: 0.875rem;">
                                {{ $song->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <a href="{{ route('artist.songs.edit', $song->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.75rem; font-size: 0.875rem; display: inline-flex;">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 3rem; text-align: center; color: var(--color-text-secondary);">
                                <div style="margin-bottom: 1rem; font-size: 2rem; color: #cbd5e1;">
                                    <i class="fa-solid fa-microphone-slash"></i>
                                </div>
                                <p style="margin-bottom: 1rem;">No songs found.</p>
                                <a href="{{ route('artist.songs.create') }}" class="btn btn-primary">
                                    Upload Your First Song
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $songs->links() }}
    </div>
@endsection
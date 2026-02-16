@extends('artist.layout')

@section('title', 'My Albums')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--color-text-primary); margin: 0;">My Albums</h2>
            <p style="color: var(--color-text-secondary); margin-top: 0.5rem;">Manage your music albums</p>
        </div>
        <a href="{{ route('artist.albums.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Album
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
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Cover</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Album Name</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Year</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Songs</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: var(--color-text-secondary); font-size: 0.875rem;">Actions</th>
                    </tr>
                </thead>
                <tbody style="divide-y: 1px solid var(--color-border);">
                    @forelse($albums as $album)
                        <tr style="border-bottom: 1px solid var(--color-border);">
                            <td style="padding: 1rem 1.5rem;">
                                @if($album->cover_image)
                                    <img src="{{ asset($album->cover_image) }}" alt="Cover"
                                        style="width: 48px; height: 48px; border-radius: 6px; object-fit: cover;">
                                @else
                                    <div style="width: 48px; height: 48px; background-color: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                        <i class="fa-solid fa-compact-disc"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="font-weight: 500; color: var(--color-text-primary);">{{ $album->name }}</div>
                            </td>
                            <td style="padding: 1rem 1.5rem; color: var(--color-text-secondary);">
                                {{ $album->year ?? '-' }}
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <span style="background-color: #eff6ff; color: #3b82f6; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                    {{ $album->songs_count }} songs
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('artist.albums.edit', $album->id) }}" class="btn btn-outline" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem; text-align: center; color: var(--color-text-secondary);">
                                <div style="margin-bottom: 1rem; font-size: 2rem; color: #cbd5e1;">
                                    <i class="fa-solid fa-compact-disc"></i>
                                </div>
                                <p style="margin-bottom: 1rem;">No albums found.</p>
                                <a href="{{ route('artist.albums.create') }}" class="btn btn-primary">
                                    Create Your First Album
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div style="margin-top: 1.5rem;">
        {{ $albums->links() }}
    </div>
@endsection

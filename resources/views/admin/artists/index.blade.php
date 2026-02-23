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

    @include('admin.partials.artist-tabs')

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
                        <th>Type</th>
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
                                <span class="badge" style="background: #e2e8f0; color: #4a5568; text-transform: capitalize;">
                                    {{ $artist->type ?? 'Singer' }}
                                </span>
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
                                    <button type="button" class="btn-icon" style="background: #edf2f7; color: #4a5568;"
                                        title="Account Settings"
                                        onclick="openAccountModal('{{ route('admin.artists.update-account', $artist) }}', '{{ $artist->user ? $artist->user->email : '' }}')">
                                        <i class="fa-solid fa-user-lock"></i>
                                    </button>
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

    {{-- Account Settings Modal --}}
    <div id="accountModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div
            style="background: white; width: 100%; max-width: 500px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden;">
            <div
                style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #1f2937;">
                    <i class="fa-solid fa-user-lock"></i> Account Credentials
                </h3>
                <button type="button" onclick="closeAccountModal()"
                    style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer;">&times;</button>
            </div>

            <form id="accountForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div style="padding: 1.5rem;">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="modal-email"
                            style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Email
                            Address</label>
                        <input type="email" id="modal-email" name="email" class="form-control"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">
                    </div>



                    <div class="form-group">
                        <label for="modal-password"
                            style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">New
                            Password</label>
                        <input type="password" id="modal-password" name="password" class="form-control"
                            placeholder="Leave blank to keep current"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">

                        <div style="margin-top: 0.5rem; display: flex; align-items: center;">
                            <input type="checkbox" id="modal-show-password" onclick="toggleModalPassword()"
                                style="margin-right: 0.5rem;">
                            <label for="modal-show-password"
                                style="margin: 0; font-size: 0.9em; color: #4a5568; cursor: pointer;">Show Password</label>
                        </div>
                        <small style="display: block; margin-top: 0.5rem; color: #6b7280;">Min. 6 characters</small>
                    </div>
                </div>

                <div
                    style="padding: 1.5rem; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <button type="button" onclick="closeAccountModal()"
                        style="padding: 0.5rem 1rem; background: white; border: 1px solid #d1d5db; border-radius: 6px; color: #374151; cursor: pointer; font-weight: 500;">Cancel</button>
                    <button type="submit"
                        style="padding: 0.5rem 1rem; background: #2563eb; border: none; border-radius: 6px; color: white; cursor: pointer; font-weight: 500;">Update
                        Credentials</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.partials.account-modal')
@endsection
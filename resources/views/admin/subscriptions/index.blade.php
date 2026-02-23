@extends('admin.layout')

@section('content')
    {{-- Header --}}
        <div class="dashboard-header">
            <div>
                <h1 style="font-size: 1.8rem; font-weight: 700; color: #1a202c; margin-bottom: 0.5rem;">
                    <i class="fa-solid fa-bell" style="color: #667eea; margin-right: 0.5rem;"></i>
                    Song Subscriptions
                </h1>
                <p style="color: #718096;">Manage users waiting for lyrics releases</p>
            </div>
        </div>

        {{-- Modern Stats Grid --}}
        <div class="stats-grid-modern">
            <div class="stat-card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="stat-content">
                    <div class="stat-label">Total Subscriptions</div>
                    <div class="stat-value">{{ \App\Models\SongSubscription::count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="stat-card-modern" style="background: linear-gradient(135deg, #ed8936 0%, #f6ad55 100%);">
                <div class="stat-content">
                    <div class="stat-label">Pending Requests</div>
                    <div class="stat-value">{{ \App\Models\SongSubscription::where('status', 'pending')->count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>

            <div class="stat-card-modern" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                <div class="stat-content">
                    <div class="stat-label">Notified Users</div>
                    <div class="stat-value">{{ \App\Models\SongSubscription::where('status', 'notified')->count() }}</div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <h2><i class="fa-solid fa-list"></i> Subscription List</h2>
            </div>

            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User Email</th>
                            <th>Requested Song</th>
                            <th>Artist</th>
                            <th>Status</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #2d3748;">
                                        {{ $subscription->created_at->format('M d, Y') }}</div>
                                    <div style="font-size: 0.75rem; color: #a0aec0;">
                                        {{ $subscription->created_at->format('H:i A') }}</div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <div
                                            style="width: 32px; height: 32px; background: #ebf8ff; color: #4299e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                            {{ strtoupper(substr($subscription->email, 0, 1)) }}
                                        </div>
                                        <a href="mailto:{{ $subscription->email }}"
                                            style="color: #4a5568; font-weight: 500; text-decoration: none; transition: color 0.2s;"
                                            onmouseover="this.style.color='#4299e1'" onmouseout="this.style.color='#4a5568'">
                                            {{ $subscription->email }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('song.show', [($subscription->song->artist ?? $subscription->song->writer)->slug ?? 'unknown', $subscription->song->slug]) }}"
                                        target="_blank" style="text-decoration: none; color: inherit; display: block;">
                                        <span
                                            style="font-weight: 600; color: #2d3748; display: block;">{{ Str::limit($subscription->song->title_english, 30) }}</span>
                                        <span
                                            style="font-size: 0.8rem; color: #718096;">{{ Str::limit($subscription->song->title_nepali, 30) }}</span>
                                    </a>
                                </td>
                                <td>
                                    <span
                                        style="background: #f7fafc; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; color: #4a5568; border: 1px solid #edf2f7;">
                                        <i class="fa-solid fa-microphone"
                                            style="font-size: 0.7rem; color: #a0aec0; margin-right: 0.25rem;"></i>
                                        {{ $subscription->song->artist->name_english ?? $subscription->song->writer->name_english ?? 'Unknown Artist' }}
                                    </span>
                                </td>
                                <td>
                                    @if($subscription->status === 'pending')
                                        <span class="badge badge-warning">
                                            <i class="fa-solid fa-clock"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fa-solid fa-check-circle"></i> Notified
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                    {{-- Send Email --}}
                                    <a href="mailto:{{ $subscription->email }}?subject=Lyrics Available: {{ $subscription->song->title_english }}&body=Hello,%0D%0A%0D%0AGreat news! The lyrics for '{{ $subscription->song->title_english }}' are now available on {{ config('app.name') }}.%0D%0A%0D%0AYou can view them here:%0D%0A{{ route('song.show', [($subscription->song->artist ?? $subscription->song->writer)->slug ?? 'unknown', $subscription->song->slug]) }}" 
                                    class="btn-icon" 
                                    style="background: #ebf8ff; color: #4299e1;"
                                    title="Send Email">
                                        <i class="fa-regular fa-envelope"></i>
                                    </a>

                                    {{-- Mark as Notified --}}
                                    <form action="{{ route('admin.subscriptions.status', $subscription->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn-icon" 
                                                style="background: {{ $subscription->status === 'pending' ? '#f0fff4' : '#fff5f5' }}; color: {{ $subscription->status === 'pending' ? '#38a169' : '#e53e3e' }};"
                                                title="{{ $subscription->status === 'pending' ? 'Mark as Notified' : 'Mark as Pending' }}">
                                            <i class="fa-solid {{ $subscription->status === 'pending' ? 'fa-check' : 'fa-rotate-left' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-table">
                                    <i class="fa-regular fa-bell-slash"></i>
                                    <p>No subscriptions found yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div style="padding: 1.5rem; border-top: 1px solid #e2e8f0;">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
@endsection
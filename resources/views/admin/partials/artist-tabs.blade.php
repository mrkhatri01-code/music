<div class="tabs-container" style="margin-bottom: 2rem; border-bottom: 1px solid var(--color-border);">
    <div style="display: flex; gap: 2rem;">
        <a href="{{ route('admin.artists.index') }}"
            style="padding-bottom: 1rem; text-decoration: none; color: {{ Route::is('admin.artists.*') ? 'var(--color-primary)' : 'var(--color-text-secondary)' }}; font-weight: 600; border-bottom: 2px solid {{ Route::is('admin.artists.*') ? 'var(--color-primary)' : 'transparent' }}; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s;">
            <i class="fa-solid fa-users"></i> All Artists
        </a>

        <a href="{{ route('admin.artist-requests.index') }}"
            style="padding-bottom: 1rem; text-decoration: none; color: {{ Route::is('admin.artist-requests.*') ? 'var(--color-primary)' : 'var(--color-text-secondary)' }}; font-weight: 600; border-bottom: 2px solid {{ Route::is('admin.artist-requests.*') ? 'var(--color-primary)' : 'transparent' }}; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s;">
            <i class="fa-solid fa-user-clock"></i> Registration Requests
            @php
                $pendingRequests = \App\Models\ArtistRegistrationRequest::where('status', 'pending')->count();
            @endphp
            @if($pendingRequests > 0)
                <span
                    style="background: var(--color-error); color: white; font-size: 0.7rem; padding: 0.1rem 0.4rem; border-radius: 99px;">{{ $pendingRequests }}</span>
            @endif
        </a>

        <a href="{{ route('admin.password-requests.index') }}"
            style="padding-bottom: 1rem; text-decoration: none; color: {{ Route::is('admin.password-requests.*') ? 'var(--color-primary)' : 'var(--color-text-secondary)' }}; font-weight: 600; border-bottom: 2px solid {{ Route::is('admin.password-requests.*') ? 'var(--color-primary)' : 'transparent' }}; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s;">
            <i class="fa-solid fa-key"></i> Password Requests
            @php
                $pendingPasswords = \App\Models\PasswordResetRequest::where('status', 'pending')->count();
            @endphp
            @if($pendingPasswords > 0)
                <span
                    style="background: var(--color-error); color: white; font-size: 0.7rem; padding: 0.1rem 0.4rem; border-radius: 99px;">{{ $pendingPasswords }}</span>
            @endif
        </a>
    </div>
</div>
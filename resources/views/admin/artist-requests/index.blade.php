@extends('admin.layout')

@section('title', 'Artist Registration Requests')

@section('content')
    <div class="page-header-modern">
        <div>
            <h1>Artist Registration Requests</h1>
            <p>Listen to samples and approve or reject artist applications.</p>
        </div>
    </div>

    @include('admin.partials.artist-tabs')

    <div class="card-modern">
        <div class="card-header-modern">
            <h2><i class="fa-solid fa-list"></i> Pending Requests</h2>
        </div>
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Contact</th>
                        <th>Stage Name</th>
                        <th>Sample Work</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--color-text-primary);">{{ $request->full_name }}</div>
                                <span class="badge {{ $request->user ? 'badge-info' : 'badge-warning' }}">
                                    {{ $request->user ? 'Existing User' : 'New User' }}
                                </span>
                            </td>
                            <td>
                                <div><a href="mailto:{{ $request->email }}"
                                        style="color: var(--color-primary);">{{ $request->email }}</a></div>
                                <div style="color: var(--color-text-secondary); font-size: 0.85rem;">
                                    {{ $request->phone_number }}
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $request->stage_name }}</div>
                                <div style="font-size: 0.8rem; color: #718096; text-transform: capitalize;">
                                    Type: {{ $request->artist_type ?? 'Singer' }}
                                </div>
                            </td>
                            <td>
                                @if($request->sample_work_url)
                                    <a href="{{ $request->sample_work_url }}" target="_blank" class="btn btn-sm"
                                        style="background: #eff6ff; color: var(--color-primary);">
                                        <i class="fa-solid fa-external-link-alt"></i> View Work
                                    </a>
                                @else
                                    <span style="color: var(--color-text-muted);">N/A</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('d M, Y') }}</td>
                            <td>
                                <div class="d-flex gap-2" style="display: flex; gap: 0.5rem;">
                                    <button type="button" class="btn btn-sm btn-success" title="Approve"
                                        onclick="confirmAction('{{ route('admin.artist-requests.approve', $request->id) }}', 'Approve this artist?', 'This will create a User and Artist Profile.', 'success', 'Yes, approve it!')">
                                        <i class="fa-solid fa-check"></i> Approve
                                    </button>

                                    <button type="button" class="btn btn-sm btn-danger" title="Reject"
                                        onclick="confirmAction('{{ route('admin.artist-requests.reject', $request->id) }}', 'Reject this request?', 'This action cannot be undone.', 'error', 'Yes, reject it!')">
                                        <i class="fa-solid fa-xmark"></i> Reject
                                    </button>
                                </div>
                                @if($request->bio)
                                    <div style="margin-top: 0.5rem;">
                                        <button type="button" class="btn btn-sm"
                                            style="font-size: 0.75rem; color: var(--color-text-secondary); padding: 0;"
                                            onclick="Swal.fire({ title: 'Artist Bio', text: '{{ addslashes($request->bio) }}', width: 600 })">
                                            <i class="fa-solid fa-circle-info"></i> View Bio
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state-table">
                                    <i class="fa-solid fa-inbox"></i>
                                    <p>No pending requests found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div style="padding: 1rem; border-top: 1px solid var(--color-divider);">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

    <script>
        function confirmAction(url, title, text, icon, confirmButtonText) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: icon === 'success' ? '#10b981' : '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmButtonText,
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form and submit it
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
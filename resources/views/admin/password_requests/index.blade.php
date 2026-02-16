@extends('admin.layout')

@section('title', 'Manage Password Requests')

@section('content')
    <div class="page-header-modern">
        <div>
            <h1>Password Reset Requests</h1>
            <p>Manage password reset requests from users and artists.</p>
        </div>
    </div>

    @include('admin.partials.artist-tabs')

    <div class="row">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Pending Requests</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Requested</th>
                                <th>Artist / User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $req)
                                <tr>
                                    <td>{{ $req->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($req->user)
                                            <strong>{{ $req->user->name }}</strong>
                                            @if($req->user->artist)
                                                <span class="badge badge-info ms-1">Artist</span>
                                            @endif
                                        @else
                                            <span class="text-muted">Unknown User</span>
                                        @endif
                                    </td>
                                    <td>{{ $req->email }}</td>
                                    <td>
                                        @if($req->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-success">Resolved</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($req->status == 'pending')
                                            @if($req->user && $req->user->artist)
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="openAccountModal('{{ route('admin.artists.update-account', $req->user->artist) }}', '{{ $req->user->email }}')">
                                                    <i class="fa-solid fa-key"></i> Reset
                                                </button>
                                            @endif

                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="confirmResolve('{{ $req->id }}')">
                                                <i class="fa-solid fa-check"></i> Done
                                            </button>
                                            <form id="resolve-form-{{ $req->id }}"
                                                action="{{ route('admin.password-requests.resolve', $req->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                        @endif

                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ $req->id }}')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $req->id }}"
                                            action="{{ route('admin.password-requests.destroy', $req->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No pending requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmResolve(id) {
            Swal.fire({
                title: 'Mark as Resolved?',
                text: "Ensure you have manually reset and sent the new password to the user.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Mark Done',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resolve-form-' + id).submit();
                }
            })
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Check for session success message and show Toast
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            })
        @endif
    </script>
    @include('admin.partials.account-modal')
@endsection
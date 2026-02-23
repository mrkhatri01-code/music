@extends('admin.layout')

@section('title', 'System Maintenance')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">System Maintenance</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Clear Cache Card -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        System Optimization</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Clear Application Cache</div>
                                    <p class="text-muted mt-2 small">
                                        Fixes configuration issues, visual glitches, and outdated assets.
                                        Runs <code>optimize:clear</code>, <code>view:clear</code>, etc.
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <form action="{{ route('admin.system.cache') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-broom fa-sm text-white-50 mr-2"></i> Clear Cache
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clear Sessions Card -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow h-100 py-2 border-left-danger">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Emergency Fixes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Clear All Sessions</div>
                                    <p class="text-muted mt-2 small">
                                        <strong class="text-danger">Warning:</strong> Logs out ALL users.
                                        Use this to fix persistent <strong>419 Page Expired</strong> errors.
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <form action="{{ route('admin.system.sessions') }}" method="POST"
                                        onsubmit="return confirm('Are you sure? This will log everyone out including yourself.');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-sign-out-alt fa-sm text-white-50 mr-2"></i> Clear Sessions
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
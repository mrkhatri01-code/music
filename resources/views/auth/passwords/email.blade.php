@extends('layouts.app')

@section('content')
    <div class="container"
        style="background: url('{{ asset('images/banner/login-bg.jpg') }}') no-repeat center center/cover; min-height: 80vh; display: flex; align-items: center; justify-content: center;">
        <div class="card"
            style="max-width: 400px; width: 100%; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden;">
            <div class="card-header text-center" style="background: var(--color-primary); padding: 2rem 1rem;">
                <h3 style="color: white; font-weight: 700; margin: 0;"><i class="fa-solid fa-key"></i> Reset Password</h3>
                <p style="color: rgba(255,255,255,0.8); margin-bottom: 0;">Request a manual password reset</p>
            </div>
            <div class="card-body" style="padding: 2rem;">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="email"
                            style="font-weight: 600; font-size: 0.875rem; color: #4b5563; margin-bottom: 0.5rem; display: block;">Email
                            Address</label>
                        <div style="position: relative;">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Enter your registered email"
                                style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid #d1d5db; border-radius: 8px;">
                            <i class="fa-solid fa-envelope"
                                style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #9ca3af;"></i>
                            @error('email')
                                <span class="invalid-feedback" role="alert"
                                    style="display: block; color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; font-weight: 600; background: var(--color-primary); color: white; border: none; cursor: pointer;">
                        <i class="fa-solid fa-paper-plane"></i> Send Request
                    </button>
                </form>
                <div class="text-center mt-3" style="margin-top: 1rem; font-size: 0.875rem; color: #6b7280;">
                    <a href="{{ route('login') }}"
                        style="color: var(--color-primary); text-decoration: none; font-weight: 600;"><i
                            class="fa-solid fa-arrow-left"></i> Back to Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
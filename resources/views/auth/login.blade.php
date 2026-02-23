@if(request()->routeIs('artist.*'))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Artist Login - {{ config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary: #2563eb;
                --primary-dark: #1d4ed8;
                --bg-dark: #f8fafc;
                --text-main: #1e293b;
                --text-muted: #64748b;
            }

            body {
                font-family: 'Outfit', sans-serif;
                background-color: var(--bg-dark);
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
        </style>
    </head>

    <body>
@else
    @extends('layouts.app')

    @section('content')@endif
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: var(--space-4);
    }

    .login-wrapper {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: var(--color-surface);
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        border: 1px solid var(--color-border);
    }

    /* Left Side - Image/Brand */
    .login-brand {
        flex: 1;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover));
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 3rem;
        color: white;
        overflow: hidden;
    }

    .login-brand::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset("images/banner/login-bg.jpg") }}') center center/cover;
        opacity: 0.2;
        mix-blend-mode: overlay;
    }

    .brand-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .brand-content h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        color: white;
    }

    .brand-content p {
        font-size: 1.1rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    /* Right Side - Form */
    .login-form {
        flex: 1;
        padding: 3rem;
        background: var(--color-surface);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-header h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }

    .form-header p {
        color: var(--color-text-secondary);
        font-size: 0.95rem;
    }

    /* Inputs */
    .input-grp {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-grp i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        transition: color 0.3s;
    }

    .input-grp input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 2.75rem;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        background: var(--color-bg);
        color: var(--color-text-primary);
        font-size: 1rem;
        transition: all 0.3s;
    }

    .input-grp input:focus {
        border-color: var(--color-primary);
        background: var(--color-surface);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .input-grp input:focus+i {
        color: var(--color-primary);
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        color: var(--color-text-secondary);
    }

    .forgot-link {
        color: var(--color-primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .forgot-link:hover {
        color: var(--color-primary-hover);
        text-decoration: underline;
    }

    /* Button */
    .btn-login {
        width: 100%;
        padding: 0.875rem;
        border-radius: var(--radius-md);
        background: var(--color-primary);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-login:hover {
        background: var(--color-primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .divider {
        margin: 2rem 0;
        position: relative;
        text-align: center;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: var(--color-border);
    }

    .divider span {
        position: relative;
        background: var(--color-surface);
        padding: 0 1rem;
        color: var(--color-text-muted);
        font-size: 0.85rem;
    }

    .register-link {
        text-align: center;
        font-size: 0.95rem;
        color: var(--color-text-secondary);
    }

    .register-link a {
        color: var(--color-primary);
        font-weight: 700;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    /* Mobile */
    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
        }

        .login-brand {
            display: none;
            /* Hide brand image on mobile for compactness, or keep minimal */
        }

        .login-form {
            padding: 2rem;
        }

        .login-container {
            padding: 1rem;
            align-items: flex-start;
            padding-top: 2rem;
        }
    }

    .input-grp .password-toggle {
        position: absolute;
        right: 1rem !important;
        left: auto !important;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        z-index: 10;
        transition: color 0.3s;
    }

    .input-grp .password-toggle:hover {
        color: var(--color-primary);
    }
</style>

<div class="login-container">
    <div class="login-wrapper">
        <!-- Left Side -->
        <div class="login-brand">
            <div class="brand-content">
                <i class="fa-solid fa-music" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.9;"></i>
                <h2>Artist Panel</h2>
                <p>Manage your profile, upload songs, and connect with millions of listeners worldwide.</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-form">
            <div class="form-header">
                <h3>Welcome Back</h3>
                <p>Please enter your details to sign in.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger"
                    style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ request()->routeIs('artist.*') ? route('artist.login.submit') : route('login.submit') }}"
                method="POST">
                @csrf

                <div class="input-grp">
                    <input type="email" name="email" placeholder="Email Address" required autofocus
                        value="{{ old('email') }}">
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="input-grp">
                    <input type="password" name="password" id="password" placeholder="Password" required
                        style="padding-right: 2.75rem;">
                    <i class="fa-solid fa-lock"></i>
                    <i class="fa-solid fa-eye password-toggle" id="togglePassword"></i>
                </div>

                <div class="form-options">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <span>Sign In</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="divider">
                <span>New to our platform?</span>
            </div>

            <div class="register-link">
                Don't have an account?
                <a href="{{ route('artist.register') }}">Join as Artist</a>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
    @if(!request()->routeIs('artist.*'))
        @endsection
    @else
        </body>

        </html>
    @endif
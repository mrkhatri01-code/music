@extends('layouts.app')

@section('title', 'Artist Registration - ' . config('app.name'))

@section('content')
    <div class="register-wrapper">
        <div class="register-card">
            {{-- Left Side: Promotional/Brand --}}
            <div class="register-promo">
                <div class="promo-content">
                    <div class="promo-header">
                        <i class="fa-solid fa-music promo-icon"></i>
                        <h2>Join the Movement</h2>
                        <p>Share your music with millions of listeners worldwide.</p>
                    </div>

                    <div class="promo-features">
                        <div class="feature-item">
                            <i class="fa-solid fa-globe"></i>
                            <div>
                                <h4>Global Reach</h4>
                                <p>Get discovered by fans across the globe.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fa-solid fa-chart-line"></i>
                            <div>
                                <h4>Analytics</h4>
                                <p>Track your performance and audience growth.</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fa-solid fa-users"></i>
                            <div>
                                <h4>Community</h4>
                                <p>Connect with other artists and industry pros.</p>
                            </div>
                        </div>
                    </div>

                    <div class="promo-footer">
                        <p>Already have an account?</p>
                        <a href="{{ route('login') }}" class="btn-login-link">Login Here</a>
                    </div>
                </div>
            </div>

            {{-- Right Side: Form --}}
            <div class="register-form-container">
                <div class="form-header">
                    <h1>Artist Registration</h1>
                    <p>Complete the form below to start your journey.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('artist.register.submit') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        {{-- Name Fields --}}
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-user"></i>
                                <input type="text" name="full_name" id="full_name"
                                    value="{{ old('full_name', auth()->user()->name ?? '') }}"
                                    placeholder="e.g. Prabhakar Khatri" required>
                            </div>
                            @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="stage_name">Stage Name</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-microphone"></i>
                                <input type="text" name="stage_name" id="stage_name" value="{{ old('stage_name') }}"
                                    placeholder="e.g. The Rockers" required>
                            </div>
                            @error('stage_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group full-width">
                            <label for="artist_type">Artist Type *</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-masks-theater"></i>
                                <select name="artist_type" id="artist_type" class="form-control" required
                                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.95rem; background: #f9fafb; appearance: none; -webkit-appearance: none;">
                                    <option value="singer" {{ old('artist_type') == 'singer' ? 'selected' : '' }}>Singer
                                    </option>
                                    <option value="writer" {{ old('artist_type') == 'writer' ? 'selected' : '' }}>Writer
                                    </option>
                                    <option value="both" {{ old('artist_type') == 'both' ? 'selected' : '' }}>Both</option>
                                </select>
                            </div>
                            @error('artist_type') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        {{-- Contact Fields --}}
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="name@example.com"
                                    required>
                            </div>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                    placeholder="+977 9800000000">
                            </div>
                            @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Full Width Fields --}}
                        <div class="form-group full-width">
                            <label for="bio">Bio / Description</label>
                            <div class="input-wrapper textarea-wrapper">
                                <textarea name="bio" id="bio" rows="3"
                                    placeholder="Tell us about yourself and your music style...">{{ old('bio') }}</textarea>
                            </div>
                            @error('bio') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="sample_work_url">Sample Work URL</label>
                            <div class="input-wrapper">
                                <i class="fa-brands fa-youtube"></i>
                                <input type="url" name="sample_work_url" id="sample_work_url"
                                    value="{{ old('sample_work_url') }}" placeholder="https://youtube.com/watch?v=...">
                            </div>
                            <small class="helper-text">Link to your YouTube, SoundCloud, or Spotify</small>
                            @error('sample_work_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            Submit Application <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        <p class="terms-text">
                            By submitting, you agree to our <a href="{{ route('terms') }}">Terms of Service</a>.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .register-wrapper {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        .register-card {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        /* Left Side: Promo */
        .register-promo {
            flex: 0 0 40%;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover));
            color: white;
            padding: 3rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
        }

        .register-promo::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset("images/banner/login-bg.jpg") }}') center center/cover;
            opacity: 0.15;
            mix-blend-mode: overlay;
        }

        .promo-content {
            position: relative;
            z-index: 2;
        }

        .promo-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .promo-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .promo-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .feature-item i {
            background: rgba(255, 255, 255, 0.2);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }

        .feature-item h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .feature-item p {
            font-size: 0.9rem;
            opacity: 0.85;
            line-height: 1.4;
        }

        .promo-footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-login-link {
            display: inline-block;
            margin-top: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-login-link:hover {
            background: white;
            color: var(--color-primary);
        }

        /* Right Side: Form */
        .register-form-container {
            flex: 1;
            padding: 3rem;
            background: white;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--color-text-primary);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--color-text-secondary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.2s;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #f9fafb;
        }

        .textarea-wrapper textarea {
            padding-left: 1rem;
            /* No icon for textarea */
            resize: vertical;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-wrapper input:focus+i {
            color: var(--color-primary);
        }

        .helper-text {
            font-size: 0.8rem;
            color: var(--color-text-secondary);
            margin-top: 0.25rem;
            display: block;
        }

        .text-danger {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
        }

        .btn-submit {
            width: 100%;
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background: var(--color-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .terms-text {
            text-align: center;
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            margin-top: 1rem;
        }

        .terms-text a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .register-card {
                flex-direction: column;
            }

            .register-promo {
                flex: none;
                padding: 2rem;
            }

            .register-form-container {
                padding: 2rem;
            }
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .register-wrapper {
                padding: 0;
                background: white;
            }

            .register-card {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
@endsection
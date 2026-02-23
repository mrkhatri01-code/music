@extends('admin.layout')

@section('title', 'Settings')

@section('content')
    <div class="page-header">
        <h1>Site Settings</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h3 style="margin-bottom: 1rem;">General Settings</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="site_name">Site Name</label>
                    <input type="text" id="site_name" name="site_name" class="form-control"
                        value="{{ old('site_name', $settings['site_name']) }}">
                </div>

                <div class="form-group">
                    <label for="site_logo">Site Logo & Favicon</label>
                    <input type="file" id="site_logo" name="site_logo" class="form-control" accept="image/*">
                    @if($settings['site_logo'])
                        <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 1rem;">
                            <img src="{{ asset($settings['site_logo']) }}" alt="Current Logo"
                                style="height: 40px; border-radius: 4px; border: 1px solid #ddd;">
                            <span style="font-size: 0.8rem; color: #718096;">Current Logo</span>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="contact_email">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" class="form-control"
                        value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="site_description">Site Description</label>
                <textarea id="site_description" name="site_description" class="form-control"
                    rows="3">{{ old('site_description', $settings['site_description']) }}</textarea>
            </div>



            <h3 style="margin: 2rem 0 1rem;">Social Media Links</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="facebook_url">Facebook URL</label>
                    <input type="url" id="facebook_url" name="facebook_url" class="form-control"
                        value="{{ old('facebook_url', $settings['facebook_url']) }}">
                </div>

                <div class="form-group">
                    <label for="youtube_url">YouTube URL</label>
                    <input type="url" id="youtube_url" name="youtube_url" class="form-control"
                        value="{{ old('youtube_url', $settings['youtube_url']) }}">
                </div>

                <div class="form-group">
                    <label for="instagram_url">Instagram URL</label>
                    <input type="url" id="instagram_url" name="instagram_url" class="form-control"
                        value="{{ old('instagram_url', $settings['instagram_url']) }}">
                </div>

                <div class="form-group">
                    <label for="tiktok_url">TikTok URL</label>
                    <input type="url" id="tiktok_url" name="tiktok_url" class="form-control"
                        value="{{ old('tiktok_url', $settings['tiktok_url']) }}">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    {{-- Admin Credentials Form --}}
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header" style="margin-bottom: 1.5rem;">
            <h3>Admin Credentials</h3>
            <p style="color: #64748b; font-size: 0.9rem;">Update your login email and password here. You will need to log in
                again after changing these.</p>
        </div>

        <form action="{{ route('admin.settings.credentials.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control"
                    value="{{ old('email', auth('admin')->user()->email ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="current_password">Current Password <span style="color: #ef4444;">*</span></label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" minlength="8">
                    <small style="color: #64748b; font-size: 0.8rem;">Leave blank if you don't want to change the
                        password.</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        minlength="8">
                </div>
            </div>

            <div class="form-actions" style="margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="background-color: #f59e0b; border-color: #f59e0b;">
                    <i class="fa-solid fa-lock"></i>
                    Update Credentials
                </button>
            </div>
        </form>
    </div>
@endsection
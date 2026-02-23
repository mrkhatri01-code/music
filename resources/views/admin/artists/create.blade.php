@extends('admin.layout')

@section('title', 'Add New Artist')

@section('content')
    <div class="page-header">
        <h1>Add New Artist</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div
                style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #e2e8f0;">
                <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #2d3748;">Login Credentials
                    (Optional)</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}"
                            autocomplete="off">
                        <small style="color: #718096;">Leave blank if not creating a login account yet.</small>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            autocomplete="new-password">
                    </div>
                </div>
            </div>

            <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #2d3748;">Artist Profile</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="name_english">Name (English) *</label>
                    <input type="text" id="name_english" name="name_english" class="form-control" required
                        value="{{ old('name_english') }}">
                </div>

                <div class="form-group">
                    <label for="name_nepali">Name (Nepali) *</label>
                    <input type="text" id="name_nepali" name="name_nepali" class="form-control" required
                        value="{{ old('name_nepali') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="type">Artist Type *</label>
                <select id="type" name="type" class="form-control" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 4px;">
                    <option value="singer" {{ old('type') == 'singer' ? 'selected' : '' }}>Singer</option>
                    <option value="writer" {{ old('type') == 'writer' ? 'selected' : '' }}>Writer</option>
                    <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Biography</label>
                <textarea id="bio" name="bio" class="form-control">{{ old('bio') }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth') }}">
                <small style="color: #718096;">Used to calculate and display artist's age</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                    <small style="color: #718096;">Recommended: 300x300px</small>
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                    <small style="color: #718096;">Recommended: 1200x400px</small>
                </div>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Social Links</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="youtube">YouTube URL</label>
                    <input type="url" id="youtube" name="youtube" class="form-control" value="{{ old('youtube') }}"
                        placeholder="https://youtube.com/@artist">
                </div>

                <div class="form-group">
                    <label for="facebook">Facebook URL</label>
                    <input type="url" id="facebook" name="facebook" class="form-control" value="{{ old('facebook') }}"
                        placeholder="https://facebook.com/artist">
                </div>

                <div class="form-group">
                    <label for="instagram">Instagram URL</label>
                    <input type="url" id="instagram" name="instagram" class="form-control" value="{{ old('instagram') }}"
                        placeholder="https://instagram.com/artist">
                </div>

                <div class="form-group">
                    <label for="tiktok">TikTok URL</label>
                    <input type="url" id="tiktok" name="tiktok" class="form-control" value="{{ old('tiktok') }}"
                        placeholder="https://tiktok.com/@artist">
                </div>

                <div class="form-group">
                    <label for="spotify">Spotify URL</label>
                    <input type="url" id="spotify" name="spotify" class="form-control" value="{{ old('spotify') }}"
                        placeholder="https://open.spotify.com/artist/...">
                </div>

                <div class="form-group">
                    <label for="apple_music">Apple Music URL</label>
                    <input type="url" id="apple_music" name="apple_music" class="form-control"
                        value="{{ old('apple_music') }}" placeholder="https://music.apple.com/artist/...">
                </div>

                <div class="form-group">
                    <label for="website">Website URL</label>
                    <input type="url" id="website" name="website" class="form-control" value="{{ old('website') }}"
                        placeholder="https://artist-website.com">
                </div>

                <div class="form-group">
                    <label for="public_email">Public Email (Gmail)</label>
                    <input type="email" id="public_email" name="public_email" class="form-control"
                        value="{{ old('public_email') }}" placeholder="contact@artist.com">
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_verified" value="1" {{ old('is_verified') ? 'checked' : '' }}>
                    <span>Mark as Verified Artist</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Create Artist</button>
                <a href="{{ route('admin.artists.index') }}" class="btn"
                    style="background: #e2e8f0; color: #4a5568;">Cancel</a>
            </div>
        </form>
    </div>

@endsection
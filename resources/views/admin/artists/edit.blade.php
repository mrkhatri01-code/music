@extends('admin.layout')

@section('title', 'Edit Artist')

@section('content')
    <div class="page-header">
        <h1>Edit Artist: {{ $artist->name_english }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.artists.update', $artist) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="name_english">Name (English) *</label>
                    <input type="text" id="name_english" name="name_english" class="form-control" required
                        value="{{ old('name_english', $artist->name_english) }}">
                </div>

                <div class="form-group">
                    <label for="name_nepali">Name (Nepali) *</label>
                    <input type="text" id="name_nepali" name="name_nepali" class="form-control" required
                        value="{{ old('name_nepali', $artist->name_nepali) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="type">Artist Type *</label>
                <select id="type" name="type" class="form-control" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 4px;">
                    <option value="singer" {{ old('type', $artist->type) == 'singer' ? 'selected' : '' }}>Singer</option>
                    <option value="writer" {{ old('type', $artist->type) == 'writer' ? 'selected' : '' }}>Writer</option>
                    <option value="both" {{ old('type', $artist->type) == 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Biography</label>
                <textarea id="bio" name="bio" class="form-control">{{ old('bio', $artist->bio) }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth', $artist->date_of_birth ? $artist->date_of_birth->format('Y-m-d') : '') }}">
                <small style="color: #718096;">Used to calculate and display artist's age</small>
            </div>

            @if($artist->user)
                <div
                    style="margin-top: 2rem; margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #2d3748;">
                        <i class="fa-solid fa-user-lock"></i> User Account Settings
                    </h3>

                    @if(request()->get('error'))
                        <div class="alert alert-danger" style="margin-bottom: 1rem;">
                            {{ request()->get('error') }}
                        </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email', $artist->user->email) }}">
                            <small style="color: #718096;">Used for login and notifications</small>
                        </div>

                        <div>


                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                    placeholder="Leave blank to keep current password">
                                <div style="margin-top: 0.5rem; display: flex; align-items: center;">
                                    <input type="checkbox" id="show-password-check" onclick="togglePassword('password')"
                                        style="margin-right: 0.5rem;">
                                    <label for="show-password-check"
                                        style="margin: 0; font-size: 0.9em; color: #4a5568; cursor: pointer;">Show
                                        Password</label>
                                </div>
                                <small style="color: #718096; display: block; margin-top: 0.25rem;">Min. 6 characters. Only fill
                                    if you want to change it.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePassword(id) {
                        const input = document.getElementById(id);
                        if (input.type === 'password') {
                            input.type = 'text';
                        } else {
                            input.type = 'password';
                        }
                    }
                </script>
            @else
                <div
                    style="margin-top: 2rem; margin-bottom: 2rem; padding: 1.5rem; background: #fff5f5; border-radius: 8px; border: 1px solid #feb2b2;">
                    <h3 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.1rem; color: #c53030;">
                        <i class="fa-solid fa-user-plus"></i> Create User Login
                    </h3>

                    <p style="margin-bottom: 1.5rem; color: #742a2a;">
                        This artist does not have a login account yet. Fill in the details below to create one.
                    </p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="create_email">Email Address</label>
                            <input type="email" id="create_email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="artist@example.com">
                        </div>

                        <div class="form-group">
                            <label for="create_password">Password</label>
                            <input type="password" id="create_password" name="password" class="form-control"
                                placeholder="Set a secure password">
                            <div style="margin-top: 0.5rem; display: flex; align-items: center;">
                                <input type="checkbox" id="show-create-password" onclick="togglePassword('create_password')"
                                    style="margin-right: 0.5rem;">
                                <label for="show-create-password"
                                    style="margin: 0; font-size: 0.9em; color: #4a5568; cursor: pointer;">Show
                                    Password</label>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePassword(id) {
                        const input = document.getElementById(id);
                        if (input.type === 'password') {
                            input.type = 'text';
                        } else {
                            input.type = 'password';
                        }
                    }
                </script>
            @endif

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="profile_image">Profile Image</label>
                    @if($artist->profile_image)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset('storage/' . $artist->profile_image) }}" alt="Profile"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                    <small style="color: #718096;">Recommended: 300x300px</small>
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image</label>
                    @if($artist->cover_image)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset('storage/' . $artist->cover_image) }}" alt="Cover"
                                style="width: 200px; height: 67px; object-fit: cover; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                    <small style="color: #718096;">Recommended: 1200x400px</small>
                </div>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Social Links</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="youtube">YouTube URL</label>
                    <input type="url" id="youtube" name="youtube" class="form-control"
                        value="{{ old('youtube', $artist->social_links['youtube'] ?? '') }}"
                        placeholder="https://youtube.com/@artist">
                </div>

                <div class="form-group">
                    <label for="facebook">Facebook URL</label>
                    <input type="url" id="facebook" name="facebook" class="form-control"
                        value="{{ old('facebook', $artist->social_links['facebook'] ?? '') }}"
                        placeholder="https://facebook.com/artist">
                </div>

                <div class="form-group">
                    <label for="instagram">Instagram URL</label>
                    <input type="url" id="instagram" name="instagram" class="form-control"
                        value="{{ old('instagram', $artist->social_links['instagram'] ?? '') }}"
                        placeholder="https://instagram.com/artist">
                </div>

                <div class="form-group">
                    <label for="tiktok">TikTok URL</label>
                    <input type="url" id="tiktok" name="tiktok" class="form-control"
                        value="{{ old('tiktok', $artist->social_links['tiktok'] ?? '') }}"
                        placeholder="https://tiktok.com/@artist">
                </div>

                <div class="form-group">
                    <label for="spotify">Spotify URL</label>
                    <input type="url" id="spotify" name="spotify" class="form-control"
                        value="{{ old('spotify', $artist->social_links['spotify'] ?? '') }}"
                        placeholder="https://open.spotify.com/artist/...">
                </div>

                <div class="form-group">
                    <label for="apple_music">Apple Music URL</label>
                    <input type="url" id="apple_music" name="apple_music" class="form-control"
                        value="{{ old('apple_music', $artist->social_links['apple_music'] ?? '') }}"
                        placeholder="https://music.apple.com/artist/...">
                </div>

                <div class="form-group">
                    <label for="website">Website URL</label>
                    <input type="url" id="website" name="website" class="form-control"
                        value="{{ old('website', $artist->social_links['website'] ?? '') }}"
                        placeholder="https://artist-website.com">
                </div>

                <div class="form-group">
                    <label for="public_email">Public Email (Gmail)</label>
                    <input type="email" id="public_email" name="public_email" class="form-control"
                        value="{{ old('public_email', $artist->social_links['public_email'] ?? '') }}"
                        placeholder="contact@artist.com">
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_verified" value="1" {{ old('is_verified', $artist->is_verified) ? 'checked' : '' }}>
                    <span>Mark as Verified Artist</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Update Artist</button>
                <a href="{{ route('admin.artists.index') }}" class="btn"
                    style="background: #e2e8f0; color: #4a5568;">Cancel</a>
            </div>
        </form>
    </div>

@endsection
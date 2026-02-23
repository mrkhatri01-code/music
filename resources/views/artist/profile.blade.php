@extends('artist.layout')

@section('title', 'Expert Profile')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Manage Profile</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <form action="{{ route('artist.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
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

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="type">Artist Type *</label>
                        <select id="type" name="type" class="form-control" required
                            style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 4px;">
                            <option value="singer" {{ old('type', $artist->type) == 'singer' ? 'selected' : '' }}>Singer
                            </option>
                            <option value="writer" {{ old('type', $artist->type) == 'writer' ? 'selected' : '' }}>Writer
                            </option>
                            <option value="both" {{ old('type', $artist->type) == 'both' ? 'selected' : '' }}>Both</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bio">Biography</label>
                        <textarea id="bio" name="bio" class="form-control"
                            rows="5">{{ old('bio', $artist->bio) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                            value="{{ old('date_of_birth', $artist->date_of_birth ? $artist->date_of_birth->format('Y-m-d') : '') }}">
                        <small class="text-muted">Used to calculate and display your age</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1.5rem;">
                        <div class="form-group">
                            <label for="profile_image">Profile Image</label>
                            @if($artist->profile_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $artist->profile_image) }}" alt="Profile"
                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                                </div>
                            @endif
                            <input type="file" id="profile_image" name="profile_image" class="form-control"
                                accept="image/*">
                            <small class="text-muted">Recommended: 300x300px (Square)</small>
                        </div>

                        <div class="form-group">
                            <label for="cover_image">Cover Image</label>
                            @if($artist->cover_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $artist->cover_image) }}" alt="Cover"
                                        style="width: 100%; height: 100px; object-fit: cover; border-radius: 8px;">
                                </div>
                            @endif
                            <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 1200x400px</small>
                        </div>
                    </div>

                    <h3 class="mt-4 mb-3" style="font-size: 1.25rem; font-weight: 600;">Social Links</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="youtube">YouTube URL</label>
                            <input type="url" id="youtube" name="social_links[youtube]" class="form-control"
                                value="{{ $artist->social_links['youtube'] ?? '' }}"
                                placeholder="https://youtube.com/@yourchannel">
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook URL</label>
                            <input type="url" id="facebook" name="social_links[facebook]" class="form-control"
                                value="{{ $artist->social_links['facebook'] ?? '' }}"
                                placeholder="https://facebook.com/yourpage">
                        </div>

                        <div class="form-group">
                            <label for="instagram">Instagram URL</label>
                            <input type="url" id="instagram" name="social_links[instagram]" class="form-control"
                                value="{{ $artist->social_links['instagram'] ?? '' }}"
                                placeholder="https://instagram.com/yourprofile">
                        </div>

                        <div class="form-group">
                            <label for="tiktok">TikTok URL</label>
                            <input type="url" id="tiktok" name="social_links[tiktok]" class="form-control"
                                value="{{ $artist->social_links['tiktok'] ?? '' }}"
                                placeholder="https://tiktok.com/@yourprofile">
                        </div>

                        <div class="form-group">
                            <label for="spotify">Spotify URL</label>
                            <input type="url" id="spotify" name="social_links[spotify]" class="form-control"
                                value="{{ $artist->social_links['spotify'] ?? '' }}"
                                placeholder="https://open.spotify.com/artist/...">
                        </div>

                        <div class="form-group">
                            <label for="apple_music">Apple Music URL</label>
                            <input type="url" id="apple_music" name="social_links[apple_music]" class="form-control"
                                value="{{ $artist->social_links['apple_music'] ?? '' }}"
                                placeholder="https://music.apple.com/artist/...">
                        </div>

                        <div class="form-group">
                            <label for="website">Website URL</label>
                            <input type="url" id="website" name="social_links[website]" class="form-control"
                                value="{{ $artist->social_links['website'] ?? '' }}" placeholder="https://yourwebsite.com">
                        </div>

                        <div class="form-group">
                            <label for="public_email">Public Email (Gmail)</label>
                            <input type="email" id="public_email" name="social_links[public_email]" class="form-control"
                                value="{{ $artist->social_links['public_email'] ?? '' }}" placeholder="contact@artist.com">
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="card mt-4">
                <div class="card-header"
                    style="background: none; border-bottom: 1px solid var(--color-border); padding: 1.5rem;">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Change Password</h3>
                </div>
                <div class="card-body" style="padding: 1.5rem;">
                    <form action="{{ route('artist.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control"
                                required>
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-outline">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
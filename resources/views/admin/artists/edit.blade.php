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
                <label for="bio">Biography</label>
                <textarea id="bio" name="bio" class="form-control">{{ old('bio', $artist->bio) }}</textarea>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth', $artist->date_of_birth ? $artist->date_of_birth->format('Y-m-d') : '') }}">
                <small style="color: #718096;">Used to calculate and display artist's age</small>
            </div>

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
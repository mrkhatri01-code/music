@extends('artist.layout')

@section('title', 'Complete Your Profile')

@section('content')
    <div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        <div class="card">
            <div class="card-header">
                <h2>Complete Your Artist Profile</h2>
                <p style="color: #ecc94b;">Please complete your profile to access the dashboard.</p>
            </div>

            <form action="{{ route('artist.profile.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="name_english">Artist Name (English) *</label>
                    <input type="text" name="name_english" id="name_english" class="form-control"
                        value="{{ old('name_english', $user->name) }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="name_nepali">Artist Name (Nepali) *</label>
                    <input type="text" name="name_nepali" id="name_nepali" class="form-control"
                        value="{{ old('name_nepali') }}" required placeholder="नेपालीमा नाम type गर्नुहोस्">
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="type">Artist Type *</label>
                    <select id="type" name="type" class="form-control" required
                        style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 4px;">
                        <option value="singer" {{ old('type') == 'singer' ? 'selected' : '' }}>Singer</option>
                        <option value="writer" {{ old('type') == 'writer' ? 'selected' : '' }}>Writer</option>
                        <option value="both" {{ old('type') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="bio">Biography</label>
                    <textarea name="bio" id="bio" rows="4" class="form-control">{{ old('bio') }}</textarea>
                </div>

                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                        value="{{ old('date_of_birth') }}">
                </div>

                <div class="form-grid"
                    style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cover_image">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Profile & Continue to
                    Dashboard</button>
            </form>
        </div>
    </div>
@endsection
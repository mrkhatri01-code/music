@extends('admin.layout')

@section('title', 'Add Team Member')

@section('content')
    <div class="page-header-modern">
        <div class="page-header-content">
            <h1>Add Team Member</h1>
            <p>Create a new team member profile</p>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.team-members.index') }}" class="btn btn-secondary"
                style="background: white; border: 1px solid var(--color-border); color: var(--color-text-secondary);">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid-2-cols" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Left Column -->
                <div>
                    <div class="form-group">
                        <label for="name">Full Name <span style="color: var(--color-error);">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <div style="color: var(--color-error); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="position">Position / Role <span style="color: var(--color-error);">*</span></label>
                        <input type="text" name="position" id="position"
                            class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}"
                            required>
                        @error('position')
                            <div style="color: var(--color-error); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control"
                            value="{{ old('display_order', 0) }}">
                        <small style="color: var(--color-text-muted);">Lower numbers appear first</small>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label" style="cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span>Active (Visible on public site)</span>
                        </label>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <div style="border: 2px dashed var(--color-border); border-radius: var(--radius-md); padding: 2rem; text-align: center; cursor: pointer; transition: all 0.2s;"
                            onclick="document.getElementById('image').click()"
                            ondragover="this.style.borderColor='var(--color-primary)'; event.preventDefault();"
                            ondragleave="this.style.borderColor='var(--color-border)';"
                            ondrop="this.style.borderColor='var(--color-border)'; event.preventDefault(); document.getElementById('image').files = event.dataTransfer.files; previewImage(event.dataTransfer.files[0]);">

                            <input type="file" name="image" id="image" style="display: none;" accept="image/*"
                                onchange="previewImage(this.files[0])">

                            <div id="image-preview" style="display: none; margin-bottom: 1rem;">
                                <img src=""
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; box-shadow: var(--shadow-sm);">
                            </div>

                            <div id="upload-placeholder">
                                <i class="fa-regular fa-image"
                                    style="font-size: 2rem; color: var(--color-text-muted); margin-bottom: 0.5rem;"></i>
                                <p style="font-size: 0.9rem; color: var(--color-text-secondary);">Click to upload image</p>
                                <p style="font-size: 0.8rem; color: var(--color-text-muted);">JPG, PNG, WebP (Max 2MB)</p>
                            </div>
                        </div>
                        @error('image')
                            <div style="color: var(--color-error); font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <label
                        style="display: block; margin-bottom: 0.5rem; font-weight: 500; font-size: 0.9rem; margin-top: 1.5rem;">Social
                        Links</label>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-facebook"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #1877f2;"></i>
                            <input type="url" name="social_links[facebook]" placeholder="Facebook Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.facebook') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-twitter"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #1da1f2;"></i>
                            <input type="url" name="social_links[twitter]" placeholder="Twitter Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.twitter') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-instagram"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #e1306c;"></i>
                            <input type="url" name="social_links[instagram]" placeholder="Instagram Profile URL"
                                class="form-control" style="padding-left: 36px;"
                                value="{{ old('social_links.instagram') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-linkedin"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #0077b5;"></i>
                            <input type="url" name="social_links[linkedin]" placeholder="LinkedIn Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.linkedin') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-github"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #333;"></i>
                            <input type="url" name="social_links[github]" placeholder="GitHub Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.github') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-reddit"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #ff4500;"></i>
                            <input type="url" name="social_links[reddit]" placeholder="Reddit Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.reddit') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-brands fa-behance"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #1769ff;"></i>
                            <input type="url" name="social_links[behance]" placeholder="Behance Profile URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.behance') }}">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <div style="position: relative;">
                            <i class="fa-solid fa-globe"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #4a5568;"></i>
                            <input type="url" name="social_links[website]" placeholder="Personal Website URL"
                                class="form-control" style="padding-left: 36px;" value="{{ old('social_links.website') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div
                style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--color-divider); text-align: right;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Member
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(file) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('image-preview');
                    const img = preview.querySelector('img');
                    const placeholder = document.getElementById('upload-placeholder');

                    img.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
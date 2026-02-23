@extends('artist.layout')

@section('title', 'Edit Album ' . $album->name)

@section('content')
    <div class="card">
        <form action="{{ route('artist.albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--color-text-primary); margin: 0;">Edit Album
                </h3>
                @if($album->cover_image)
                    <img src="{{ asset($album->cover_image) }}" alt="Current Cover"
                        style="width: 48px; height: 48px; border-radius: 6px; object-fit: cover;">
                @endif
            </div>

            <div class="form-group">
                <label for="name">Album Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $album->name) }}"
                    required autofocus>
                @error('name') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="year">Release Year</label>
                <input type="number" id="year" name="year" class="form-control" value="{{ old('year', $album->year) }}"
                    min="1900" max="{{ date('Y') + 1 }}">
                @error('year') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"
                    rows="4">{{ old('description', $album->description) }}</textarea>
                @error('description') <span class="text-danger"
                style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                <small style="color: #718096; display: block; margin-top: 0.5rem;">
                    <i class="fa-solid fa-circle-info"></i> Leave empty to keep current image. Recommended: 800x800px (Max
                    2MB)
                </small>
                @error('cover_image') <span class="text-danger"
                style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Update Album</button>
                <a href="{{ route('artist.albums.index') }}" class="btn btn-outline"
                    style="background: white; border: 1px solid #d1d5db;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
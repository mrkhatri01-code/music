@extends('admin.layout')

@section('title', 'Create Movie')

@section('content')
    <div class="page-header">
        <h1>Add New Movie</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Movie Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required
                    placeholder="Enter movie name"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                @error('name')
                    <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label for="year" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Year</label>
                    <input type="number" id="year" name="year" class="form-control" value="{{ old('year') }}" min="1900"
                        max="{{ date('Y') + 10 }}" placeholder="e.g., 2024"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    @error('year')
                        <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cover_image" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Cover
                        Image</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <small style="color: #718096;">Recommended: Square image (e.g., 500x500px)</small>
                    @error('cover_image')
                        <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="description"
                    style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"
                    placeholder="Enter movie description (optional)"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px;">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #e53e3e; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">
                    <i class="fa-solid fa-save"></i> Create Movie
                </button>
                <a href="{{ route('admin.movies.index') }}" class="btn" style="padding: 0.75rem 2rem; background: #e2e8f0;">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
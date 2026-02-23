@extends('admin.layout')

@section('title', isset($album) ? 'Edit Album' : 'Create New Album')

@section('content')
    <div class="page-header">
        <div class="header-title">
            <h1>{{ isset($album) ? 'Edit Album' : 'Create New Album' }}</h1>
            <p>{{ isset($album) ? 'Update album details' : 'Add a new music album' }}</p>
        </div>
        <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card" style="max-width: 800px;">
        <form action="{{ isset($album) ? route('admin.albums.update', $album->id) : route('admin.albums.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($album))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Album Name <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $album->name ?? '') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="artist_id">Artist <span style="color: red;">*</span></label>
                    <select id="artist_id" name="artist_id" class="form-control @error('artist_id') is-invalid @enderror"
                        required>
                        <option value="">Select Artist</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id', $album->artist_id ?? '') == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name_english }}
                            </option>
                        @endforeach
                    </select>
                    @error('artist_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="year">Release Year</label>
                    <input type="number" id="year" name="year" class="form-control @error('year') is-invalid @enderror"
                        value="{{ old('year', $album->year ?? date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="4">{{ old('description', $album->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image</label>
                <input type="file" id="cover_image" name="cover_image"
                    class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                @error('cover_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if(isset($album) && $album->cover_image)
                    <div style="margin-top: 1rem;">
                        <p style="margin-bottom: 0.5rem; font-size: 0.9rem; color: #718096;">Current Cover:</p>
                        <img src="{{ asset($album->cover_image) }}" alt="Current Cover"
                            style="height: 100px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    </div>
                @endif
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-save"></i> {{ isset($album) ? 'Update Album' : 'Create Album' }}
                </button>
            </div>
        </form>
    </div>
@endsection
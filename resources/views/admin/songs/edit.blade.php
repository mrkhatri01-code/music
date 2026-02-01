@extends('admin.layout')

@section('title', 'Edit Song')

@section('content')
<div class="page-header">
    <h1>Edit Song: {{ $song->title_nepali }}</h1>
</div>

<div class="card">
    <form action="{{ route('admin.songs.update', $song) }}" method="POST">
        @csrf
        @method('PUT')
        
        <h3 style="margin-bottom: 1rem;">Song Details</h3>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title_english">Title (English) *</label>
                <input type="text" id="title_english" name="title_english" class="form-control" required value="{{ old('title_english', $song->title_english) }}">
            </div>
            
            <div class="form-group">
                <label for="title_nepali">Title (Nepali) *</label>
                <input type="text" id="title_nepali" name="title_nepali" class="form-control" required value="{{ old('title_nepali', $song->title_nepali) }}">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="artist_id">Artist *</label>
                <select id="artist_id" name="artist_id" class="form-control" required>
                    <option value="">Select Artist</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id', $song->artist_id) == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name_english }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="genre_id">Genre</label>
                <select id="genre_id" name="genre_id" class="form-control">
                    <option value="">Select Genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id', $song->genre_id) == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" id="year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('year', $song->year) }}">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="movie_id">Movie (Optional)</label>
                <select id="movie_id" name="movie_id" class="form-control">
                    <option value="">Select Movie</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ old('movie_id', $song->movie_id) == $movie->id ? 'selected' : '' }}>
                            {{ $movie->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="album_id">Album (Optional)</label>
                <select id="album_id" name="album_id" class="form-control">
                    <option value="">Select Album</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}" {{ old('album_id', $song->album_id) == $album->id ? 'selected' : '' }}>
                            {{ $album->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label for="youtube_url">YouTube URL</label>
            <input type="url" id="youtube_url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $song->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
        </div>
        
        <div class="form-group">
            <label for="tags">Tags (for mood pages)</label>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                @php
                    $selectedTags = old('tags', $song->tags->pluck('id')->toArray());
                @endphp
                @foreach($tags as $tag)
                    <label class="checkbox-label" style="background: #f7fafc; padding: 0.5rem 1rem; border-radius: 6px;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                        <span>{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        
        <h3 style="margin: 2rem 0 1rem;">Lyrics</h3>
        
        <div class="form-group">
            <label for="lyrics_unicode">Lyrics (Nepali Unicode) *</label>
            <textarea id="lyrics_unicode" name="lyrics_unicode" class="form-control" rows="15" required placeholder="Enter Nepali lyrics in Unicode...">{{ old('lyrics_unicode', $song->lyric ?->content_unicode) }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="lyrics_romanized">Lyrics (Romanized)</label>
            <textarea id="lyrics_romanized" name="lyrics_romanized" class="form-control" rows="15" placeholder="Enter romanized lyrics (optional)...">{{ old('lyrics_romanized', $song->lyric?->content_romanized) }}</textarea>
        </div>
        
        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $song->is_published) ? 'checked' : '' }}>
                <span>Publish Now</span>
            </label>
        </div>
        
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-success">Update Song</button>
            <a href="{{ route('admin.songs.index') }}" class="btn" style="background: #e2e8f0; color: #4a5568;">Cancel</a>
        </div>
    </form>
</div>

@endsection

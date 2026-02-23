@extends('admin.layout')

@section('title', 'Edit Song')

@section('content')
    <div class="page-header">
        <h1>Edit Song</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.songs.update', $song) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h3 style="margin-bottom: 1rem;">Song Details</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="title_nepali">Title (Nepali) *</label>
                    <input type="text" id="title_nepali" name="title_nepali" class="form-control"
                        value="{{ old('title_nepali', $song->title_nepali) }}" required>
                </div>

                <div class="form-group">
                    <label for="title_english">Title (English) *</label>
                    <input type="text" id="title_english" name="title_english" class="form-control"
                        value="{{ old('title_english', $song->title_english) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="artist_id">Singer (Main Artist)</label>
                    <select id="artist_id" name="artist_id" class="form-control">
                        <option value="">Select Singer (Optional)</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id', $song->artist_id) == $artist->id ? 'selected' : '' }}>
                                {{ $artist->name_english }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="writer_id">Writer</label>
                    <select id="writer_id" name="writer_id" class="form-control">
                        <option value="">Select Writer (Optional)</option>
                        @foreach($writers as $writer)
                            <option value="{{ $writer->id }}" {{ old('writer_id', $song->writer_id) == $writer->id ? 'selected' : '' }}>
                                {{ $writer->name_english }}
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
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="movie_id">Movie</label>
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
                    <label for="album_id">Album</label>
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

            <div class="form-row">
                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date" class="form-control"
                        value="{{ old('release_date', $song->release_date ? $song->release_date->format('Y-m-d') : '') }}">
                </div>

                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" id="year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}"
                        value="{{ old('year', $song->year) }}">
                </div>

                <script>
                    document.getElementById('release_date').addEventListener('change', function () {
                        if (this.value) {
                            const year = new Date(this.value).getFullYear();
                            document.getElementById('year').value = year;
                        }
                    });
                </script>
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" class="form-control"
                    value="{{ old('youtube_url', $song->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="cover_image">Song Cover Image</label>
                    @if($song->cover_image)
                        <div style="margin-bottom: 0.5rem;">
                            <img src="{{ asset($song->cover_image) }}" alt="Current Cover"
                                style="max-height: 150px; border-radius: 8px; border: 1px solid #cbd5e0;">
                        </div>
                    @endif
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                    <small style="color: #718096; display: block; margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Upload new image to replace current (Max 2MB)
                    </small>
                </div>

                <div class="form-group">
                    <label for="lyrics_status">Lyrics Status *</label>
                    <select id="lyrics_status" name="lyrics_status" class="form-control" required
                        onchange="toggleLyricsFields()">
                        <option value="available" {{ old('lyrics_status', $song->lyrics_status ?? 'available') == 'available' ? 'selected' : '' }}>Lyrics Available</option>
                        <option value="coming_soon" {{ old('lyrics_status', $song->lyrics_status ?? 'available') == 'coming_soon' ? 'selected' : '' }}>Lyrics Coming Soon</option>
                    </select>
                    <small style="color: #718096; display: block; margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Mark as "Coming Soon" if lyrics aren't ready yet
                    </small>
                    <div id="comingSoonMessage"
                        style="display: none; margin-top: 0.75rem; padding: 0.75rem; background: #fef5e7; border-left: 3px solid #f39c12; border-radius: 4px; color: #8b6914;">
                        <i class="fa-solid fa-info-circle"></i> <strong>Note:</strong> Lyrics fields below are optional when
                        "Coming Soon" is selected. You can update other details and add lyrics later.
                    </div>
                </div>
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

            <h3 style="margin: 2rem 0 1rem;">Language & Lyrics</h3>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; color: #4a5568;">
                    <i class="fa-solid fa-lock" style="color: #cbd5e0;"></i>
                    <span>Song Language:
                        <strong style="color: #667eea;">
                            @if($song->language === 'nepali') Nepali
                            @elseif($song->language === 'hindi') Hindi
                            @elseif($song->language === 'english') English
                            @endif
                        </strong>
                    </span>
                </label>
                <small style="color: #718096; display: block; margin-top: 0.5rem;">
                    <i class="fa-solid fa-circle-info"></i> Language cannot be changed after song creation
                </small>
                <input type="hidden" name="language" value="{{ $song->language }}">
            </div>

            <div id="lyricsSection">
                @php
                    $songLanguage = $song->language ?? 'nepali';
                @endphp

                @if($songLanguage === 'nepali')
                    <div class="form-group">
                        <label for="lyrics_unicode">Lyrics (Nepali Unicode)</label>
                        <textarea id="lyrics_unicode" name="lyrics_unicode" class="form-control" rows="15"
                            placeholder="Enter Nepali lyrics in Unicode...">{{ old('lyrics_unicode', $song->lyric->content_unicode ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="lyrics_romanized">Lyrics (Romanized)</label>
                        <textarea id="lyrics_romanized" name="lyrics_romanized" class="form-control" rows="15"
                            placeholder="Enter romanized lyrics (optional)...">{{ old('lyrics_romanized', $song->lyric->content_romanized ?? '') }}</textarea>
                    </div>
                @elseif($songLanguage === 'hindi')
                    <div class="form-group">
                        <label for="lyrics_hindi">Lyrics (Hindi)</label>
                        <textarea id="lyrics_hindi" name="lyrics_hindi" class="form-control" rows="15"
                            placeholder="Enter Hindi lyrics...">{{ old('lyrics_hindi', $song->lyric->content_unicode ?? '') }}</textarea>
                    </div>
                @elseif($songLanguage === 'english')
                    <div class="form-group">
                        <label for="lyrics_english">Lyrics (English)</label>
                        <textarea id="lyrics_english" name="lyrics_english" class="form-control" rows="15"
                            placeholder="Enter English lyrics...">{{ old('lyrics_english', $song->lyric->content_unicode ?? '') }}</textarea>
                    </div>
                @endif
            </div>

            <script>
                function toggleLyricsFields() {
                    const lyricsStatus = document.getElementById('lyrics_status').value;
                    const lyricsSection = document.getElementById('lyricsSection');
                    const comingSoonMessage = document.getElementById('comingSoonMessage');

                    if (lyricsStatus === 'coming_soon') {
                        lyricsSection.style.opacity = '0.5';
                        lyricsSection.style.pointerEvents = 'none';
                        comingSoonMessage.style.display = 'block';
                    } else {
                        lyricsSection.style.opacity = '1';
                        lyricsSection.style.pointerEvents = 'auto';
                        comingSoonMessage.style.display = 'none';
                    }
                }

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function () {
                    toggleLyricsFields();
                });
            </script>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $song->is_published) ? 'checked' : '' }}>
                    <span>Published</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Song</button>
                <a href="{{ route('admin.songs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 on Singer and Writer dropdowns
            $('#artist_id').select2({
                placeholder: "Search for a Singer...",
                allowClear: true,
                width: '100%'
            });

            $('#writer_id').select2({
                placeholder: "Search for a Writer...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
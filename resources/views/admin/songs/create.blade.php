@extends('admin.layout')

@section('title', 'Add New Song')

@section('content')
    <div class="page-header">
        <h1>Add New Song</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h3 style="margin-bottom: 1rem;">Song Details</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="title_english">Title (English) *</label>
                    <input type="text" id="title_english" name="title_english" class="form-control" required
                        value="{{ old('title_english') }}">
                </div>

                <div class="form-group">
                    <label for="title_nepali">Title (Nepali) *</label>
                    <input type="text" id="title_nepali" name="title_nepali" class="form-control" required
                        value="{{ old('title_nepali') }}">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="artist_id">Singer (Main Artist)</label>
                    <select id="artist_id" name="artist_id" class="form-control">
                        <option value="">Select Singer (Optional)</option>
                        @foreach($artists as $artist)
                            <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
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
                            <option value="{{ $writer->id }}" {{ old('writer_id') == $writer->id ? 'selected' : '' }}>
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
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date" class="form-control"
                        value="{{ old('release_date', date('Y-m-d')) }}">
                </div>

                <div class="form-group">
                    <label for="year">Year (Auto-filled from Date)</label>
                    <input type="number" id="year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}"
                        value="{{ old('year', date('Y')) }}">
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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="movie_id">Movie (Optional)</label>
                    <select id="movie_id" name="movie_id" class="form-control">
                        <option value="">Select Movie</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
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
                            <option value="{{ $album->id }}" {{ old('album_id') == $album->id ? 'selected' : '' }}>
                                {{ $album->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" class="form-control" value="{{ old('youtube_url') }}"
                    placeholder="https://www.youtube.com/watch?v=...">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="cover_image">Song Cover Image</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                    <small style="color: #718096; display: block; margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Recommended: 500x500px or 800x800px (Max 2MB)
                    </small>
                </div>

                <div class="form-group">
                    <label for="lyrics_status">Lyrics Status *</label>
                    <select id="lyrics_status" name="lyrics_status" class="form-control" required>
                        <option value="available" {{ old('lyrics_status', 'available') == 'available' ? 'selected' : '' }}>
                            Lyrics Available</option>
                        <option value="coming_soon" {{ old('lyrics_status') == 'coming_soon' ? 'selected' : '' }}>Lyrics
                            Coming Soon</option>
                    </select>
                    <small style="color: #718096; display: block; margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Select "Coming Soon" if lyrics will be added later
                    </small>
                    <div id="comingSoonMessage"
                        style="display: none; margin-top: 0.75rem; padding: 0.75rem; background: #fef5e7; border-left: 3px solid #f39c12; border-radius: 4px; color: #8b6914;">
                        <i class="fa-solid fa-info-circle"></i> <strong>Note:</strong> Lyrics fields below are optional when
                        "Coming Soon" is selected. You can publish the song now and add lyrics later.
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tags">Tags (for mood pages)</label>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                    @foreach($tags as $tag)
                        <label class="checkbox-label" style="background: #f7fafc; padding: 0.5rem 1rem; border-radius: 6px;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <h3 style="margin: 2rem 0 1rem;">Lyrics</h3>

            {{-- Language Selector --}}
            <div class="form-group">
                <label for="language">Song Language *</label>
                <select id="language" name="language" class="form-control" required onchange="toggleLyricsFields()">
                    <option value="nepali" {{ old('language', 'nepali') == 'nepali' ? 'selected' : '' }}>Nepali</option>
                    <option value="hindi" {{ old('language') == 'hindi' ? 'selected' : '' }}>Hindi</option>
                    <option value="english" {{ old('language') == 'english' ? 'selected' : '' }}>English</option>
                </select>
                <small style="color: #718096; display: block; margin-top: 0.5rem;">
                    <i class="fa-solid fa-circle-info"></i> Select the language to show appropriate lyrics fields
                </small>
            </div>

            <div id="lyricsSection">
                {{-- Nepali Lyrics Fields --}}
                <div id="nepaliLyricsFields" style="display: block;">
                    <div class="form-group">
                        <label for="lyrics_unicode">Nepali Unicode *</label>
                        <textarea id="lyrics_unicode" name="lyrics_unicode" rows="10" class="form-control"
                            placeholder="Enter Nepali lyrics in Unicode">{{ old('lyrics_unicode') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="lyrics_romanized">Romanized (Optional)</label>
                        <textarea id="lyrics_romanized" name="lyrics_romanized" rows="10" class="form-control"
                            placeholder="Enter romanized Nepali lyrics">{{ old('lyrics_romanized') }}</textarea>
                    </div>
                </div>

                {{-- Hindi Lyrics Fields --}}
                <div id="hindiLyricsFields" style="display: none;">
                    <div class="form-group">
                        <label for="lyrics_hindi">Hindi Lyrics *</label>
                        <textarea id="lyrics_hindi" name="lyrics_hindi" rows="10" class="form-control"
                            placeholder="Enter Hindi lyrics">{{ old('lyrics_hindi') }}</textarea>
                    </div>
                </div>

                {{-- English Lyrics Fields --}}
                <div id="englishLyricsFields" style="display: none;">
                    <div class="form-group">
                        <label for="lyrics_english">English Lyrics *</label>
                        <textarea id="lyrics_english" name="lyrics_english" rows="10" class="form-control"
                            placeholder="Enter English lyrics">{{ old('lyrics_english') }}</textarea>
                    </div>
                </div>
            </div>

            <script>
                function toggleLyricsFields() {
                    const language = document.getElementById('language').value;
                    const lyricsStatus = document.getElementById('lyrics_status').value;
                    const nepaliFields = document.getElementById('nepaliLyricsFields');
                    const hindiFields = document.getElementById('hindiLyricsFields');
                    const englishFields = document.getElementById('englishLyricsFields');

                    // Hide all fields first
                    nepaliFields.style.display = 'none';
                    hindiFields.style.display = 'none';
                    englishFields.style.display = 'none';

                    // Determine if lyrics should be required
                    const lyricsRequired = lyricsStatus === 'available';

                    // Show relevant fields and manage required attribute
                    if (language === 'nepali') {
                        nepaliFields.style.display = 'block';
                        document.getElementById('lyrics_unicode').required = lyricsRequired;
                        document.getElementById('lyrics_hindi').required = false;
                        document.getElementById('lyrics_english').required = false;
                    } else if (language === 'hindi') {
                        hindiFields.style.display = 'block';
                        document.getElementById('lyrics_unicode').required = false;
                        document.getElementById('lyrics_hindi').required = lyricsRequired;
                        document.getElementById('lyrics_english').required = false;
                    } else if (language === 'english') {
                        englishFields.style.display = 'block';
                        document.getElementById('lyrics_unicode').required = false;
                        document.getElementById('lyrics_hindi').required = false;
                        document.getElementById('lyrics_english').required = lyricsRequired;
                    }

                    // Show/hide lyrics section based on status
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

                    // Also trigger on lyrics_status change
                    document.getElementById('lyrics_status').addEventListener('change', toggleLyricsFields);
                });
            </script>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                    <span>Publish Now</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Create Song</button>
                <a href="{{ route('admin.songs.index') }}" class="btn"
                    style="background: #e2e8f0; color: #4a5568;">Cancel</a>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize Select2 on Singer and Writer dropdowns
            $('#artist_id').select2({
                placeholder: "Search for a Singer...",
                allowClear: true,
                width: '100%' // Ensure it matches form-control width
            });

            $('#writer_id').select2({
                placeholder: "Search for a Writer...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush
@extends('artist.layout')

@section('title', 'Edit Song - ' . $song->title_english)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit Song</h1>
        </div>
        <a href="{{ route('artist.songs.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Songs
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('artist.songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600; color: #4a5568;">Song Details</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title_nepali">Title (Nepali) *</label>
                            <input type="text" id="title_nepali" name="title_nepali" class="form-control"
                                value="{{ old('title_nepali', $song->title_nepali) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title_english">Title (English) *</label>
                            <input type="text" id="title_english" name="title_english" class="form-control"
                                value="{{ old('title_english', $song->title_english) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
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
                </div>

                @php $currentArtist = auth()->user()->artist; @endphp

                @if($currentArtist->type === 'writer')
                    <!-- Writer editing the song: They must pick a Singer -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="artist_id">Singer (Main Artist)</label>
                                <select id="artist_id" name="artist_id" class="form-control">
                                    <option value="">Search for a Singer (Optional)...</option>
                                    @foreach($singers as $singer)
                                        <option value="{{ $singer->id }}" {{ old('artist_id', $song->artist_id) == $singer->id ? 'selected' : '' }}>
                                            {{ $singer->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('artist_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Writer</label>
                                <input type="text" class="form-control" value="{{ $currentArtist->name_english }}" disabled style="background-color: #e9ecef;">
                            </div>
                        </div>
                    </div>
                @elseif($currentArtist->type === 'singer')
                    <!-- Singer editing the song: They are the singer, can pick writer -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Singer (Main Artist)</label>
                                <input type="text" class="form-control" value="{{ $currentArtist->name_english }}" disabled style="background-color: #e9ecef;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="writer_id">Writer (Optional)</label>
                                <select id="writer_id" name="writer_id" class="form-control">
                                    <option value="">Search for a Writer...</option>
                                    @foreach($writers as $writer)
                                        <option value="{{ $writer->id }}" {{ old('writer_id', $song->writer_id) == $writer->id ? 'selected' : '' }}>
                                            {{ $writer->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('writer_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Both editing the song: Needs both dropdowns -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="artist_id">Singer (Main Artist) *</label>
                                <select id="artist_id" name="artist_id" class="form-control" required>
                                    <option value="">Search for a Singer...</option>
                                    @foreach($singers as $singer)
                                        <option value="{{ $singer->id }}" {{ old('artist_id', $song->artist_id) == $singer->id ? 'selected' : '' }}>
                                            {{ $singer->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('artist_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="writer_id">Writer (Optional)</label>
                                <select id="writer_id" name="writer_id" class="form-control">
                                    <option value="">Search for a Writer...</option>
                                    @foreach($writers as $writer)
                                        <option value="{{ $writer->id }}" {{ old('writer_id', $song->writer_id) == $writer->id ? 'selected' : '' }}>
                                            {{ $writer->name_english }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('writer_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
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
                    </div>

                    <div class="col-md-6">
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
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" id="release_date" name="release_date" class="form-control"
                                value="{{ old('release_date', $song->release_date ? $song->release_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" id="year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}"
                                value="{{ old('year', $song->year) }}">
                        </div>
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
                        <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*" style="padding: 0.5rem;">
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
                            <label class="checkbox-label" style="background: #f7fafc; padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; border: 1px solid #e2e8f0;">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                                <span>{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <h3 style="margin: 2rem 0 1rem; font-size: 1.25rem; font-weight: 600; color: #4a5568;">Language & Lyrics</h3>

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

                <div class="form-group" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                    <label class="checkbox-label" style="display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; font-weight: 600;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $song->is_published) ? 'checked' : '' }} style="width: 1.25rem; height: 1.25rem;">
                        <span>Published</span>
                    </label>
                    <small style="display: block; margin-top: 0.25rem; color: #718096;">Uncheck to hide this song from the public.</small>
                </div>

                <div class="form-actions" style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem 2rem;">
                        <i class="fa-solid fa-save"></i> Update Song
                    </button>
                    <a href="{{ route('artist.songs.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
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

            // Artist Panel Text Input Tools (if available) can go here
             // Elements
             const englishInput = document.getElementById('title_english');
            const nepaliInput = document.getElementById('title_nepali');
            const lyricsUnicode = document.getElementById('lyrics_unicode');
            const lyricsRomanized = document.getElementById('lyrics_romanized');

            // --- 1. Roman -> Nepali (Google Input Tools) ---
            async function transliterate(text) {
                if (!text || !text.trim()) return null;
                try {
                    const response = await fetch(
                        `https://inputtools.google.com/request?text=${encodeURIComponent(text)}&itc=ne-t-i0-und&num=1&cp=0&cs=1&ie=utf-8&oe=utf-8&app=demopage`
                    );
                    const data = await response.json();
                    if (data && data[0] === 'SUCCESS' && data[1] && data[1][0] && data[1][0][1] && data[1][0][1][0]) {
                        return data[1][0][1][0];
                    }
                } catch (error) {
                    console.error('Transliteration error:', error);
                }
                return null;
            }

            // --- Title Logic ---
            if (englishInput && nepaliInput) {
                let timeout = null;
                englishInput.addEventListener('input', function () {
                    const text = this.value;
                    if (timeout) clearTimeout(timeout);
                    if (!text.trim()) return;
                    
                    // Only auto-fill if Nepali is empty to avoid overwriting edits
                    if (nepaliInput.value.trim() !== '') return;

                    timeout = setTimeout(async () => {
                         const transliteratedText = await transliterate(text);
                         if (transliteratedText) nepaliInput.value = transliteratedText;
                    }, 500);
                });
            }
        });
    </script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2 safely if IDs exist
            if ($('#writer_id').length) {
                $('#writer_id').select2({
                    placeholder: "Search for a Writer...",
                    allowClear: true,
                    width: '100%'
                });
            }
            if ($('#artist_id').length) {
                $('#artist_id').select2({
                    placeholder: "Search for a Singer...",
                    allowClear: true,
                    width: '100%'
                });
            }
            if ($('#genre_id').length) {
                $('#genre_id').select2({
                    placeholder: "Select Genre",
                    allowClear: true,
                    width: '100%'
                });
            }
        });
    </script>
@endpush
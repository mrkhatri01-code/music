@extends('artist.layout')

@section('title', 'Add New Song')

@section('content')
    <div class="card">
        <form action="{{ route('artist.songs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h3 style="margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600; color: var(--color-text-primary);">Song
                Details</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="title_english">Title (English) *</label>
                    <input type="text" id="title_english" name="title_english" class="form-control" required
                        value="{{ old('title_english') }}">
                    @error('title_english') <span class="text-danger"
                    style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="title_nepali">Title (Nepali) *</label>
                    <input type="text" id="title_nepali" name="title_nepali" class="form-control" required
                        value="{{ old('title_nepali') }}">
                    @error('title_nepali') <span class="text-danger"
                    style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="genre_id">Genre *</label>
                    <select id="genre_id" name="genre_id" class="form-control" required>
                        <option value="">Select Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id') <span class="text-danger"
                    style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>

                @php $currentArtist = auth()->user()->artist; @endphp

                @if($currentArtist->type === 'writer')
                    <!-- Writer creating the song: They must pick a Singer -->
                    <div class="form-group">
                        <label for="artist_id">Singer (Main Artist)</label>
                        <select id="artist_id" name="artist_id" class="form-control">
                            <option value="">Search for a Singer (Optional)...</option>
                            @foreach($singers as $singer)
                                <option value="{{ $singer->id }}" {{ old('artist_id') == $singer->id ? 'selected' : '' }}>
                                    {{ $singer->name_english }}
                                </option>
                            @endforeach
                        </select>
                        @error('artist_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Writer</label>
                        <input type="text" class="form-control" value="{{ $currentArtist->name_english }}" disabled style="background-color: #e9ecef;">
                    </div>
                @elseif($currentArtist->type === 'singer')
                    <!-- Singer creating the song: They are the singer, can pick writer -->
                    <div class="form-group">
                        <label>Singer (Main Artist)</label>
                        <input type="text" class="form-control" value="{{ $currentArtist->name_english }}" disabled style="background-color: #e9ecef;">
                    </div>

                    <div class="form-group">
                        <label for="writer_id">Writer (Optional)</label>
                        <select id="writer_id" name="writer_id" class="form-control">
                            <option value="">Search for a Writer...</option>
                            @foreach($writers as $writer)
                                <option value="{{ $writer->id }}" {{ old('writer_id') == $writer->id ? 'selected' : '' }}>
                                    {{ $writer->name_english }}
                                </option>
                            @endforeach
                        </select>
                        @error('writer_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                    </div>
                @else
                    <!-- Both creating the song: Needs both dropdowns -->
                    <div class="form-group">
                        <label for="artist_id">Singer (Main Artist) *</label>
                        <select id="artist_id" name="artist_id" class="form-control" required>
                            <option value="">Search for a Singer...</option>
                            @foreach($singers as $singer)
                                <option value="{{ $singer->id }}" {{ old('artist_id', $currentArtist->id) == $singer->id ? 'selected' : '' }}>
                                    {{ $singer->name_english }}
                                </option>
                            @endforeach
                        </select>
                        @error('artist_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="writer_id">Writer (Optional)</label>
                        <select id="writer_id" name="writer_id" class="form-control">
                            <option value="">Search for a Writer...</option>
                            @foreach($writers as $writer)
                                <option value="{{ $writer->id }}" {{ old('writer_id') == $writer->id ? 'selected' : '' }}>
                                    {{ $writer->name_english }}
                                </option>
                            @endforeach
                        </select>
                        @error('writer_id') <span class="text-danger" style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="form-group">
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date" class="form-control"
                        value="{{ old('release_date', date('Y-m-d')) }}">
                </div>

                <div class="form-group">
                    <label for="year">Year</label>
                    <input type="number" id="year" name="year" class="form-control" min="1900" max="{{ date('Y') + 1 }}"
                        value="{{ old('year', date('Y')) }}" readonly style="background-color: #f3f4f6;">
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
                                {{ $album->title_english ?? $album->name }}
                                <!-- Fallback if title_english not available, admin controller used name -->
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="youtube_url">YouTube URL</label>
                <input type="url" id="youtube_url" name="youtube_url" class="form-control" value="{{ old('youtube_url') }}"
                    placeholder="https://www.youtube.com/watch?v=...">
                @error('youtube_url') <span class="text-danger"
                style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="cover_image">Song Cover Image</label>
                    <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
                    <small style="color: #718096; display: block; margin-top: 0.5rem;">
                        <i class="fa-solid fa-circle-info"></i> Recommended: 500x500px or 800x800px (Max 2MB)
                    </small>
                    @error('cover_image') <span class="text-danger"
                    style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span> @enderror
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
                        style="display: none; margin-top: 0.75rem; padding: 0.75rem; background: #fff7ed; border-left: 3px solid #f97316; border-radius: 4px; color: #9a3412; font-size: 0.875rem;">
                        <i class="fa-solid fa-info-circle"></i> <strong>Note:</strong> Lyrics fields below are optional when
                        "Coming Soon" is selected. You can publish the song now and add lyrics later.
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tags">Tags (Moods)</label>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                    @foreach($tags as $tag)
                        <label class="checkbox-label"
                            style="background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                            <span style="font-size: 0.875rem;">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <h3 style="margin: 2rem 0 1rem; font-size: 1.25rem; font-weight: 600; color: var(--color-text-primary);">Lyrics
            </h3>

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

            <div class="form-group" style="margin-top: 2rem;">
                <label class="checkbox-label" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                        style="width: 1.25rem; height: 1.25rem; accent-color: var(--primary-color);">
                    <span style="font-weight: 600; color: var(--color-text-primary);">Publish Now</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" class="btn btn-primary">Create Song</button>
                <a href="{{ route('artist.songs.index') }}" class="btn btn-outline"
                    style="background: white; border: 1px solid #d1d5db;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const englishInput = document.getElementById('title_english');
            const nepaliInput = document.getElementById('title_nepali');

            // Function to transliterate text using Google Input Tools API
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

            if (englishInput && nepaliInput) {
                let timeout = null;

                englishInput.addEventListener('input', function () {
                    const text = this.value;
                    if (timeout) clearTimeout(timeout);

                    if (!text.trim()) return;

                    timeout = setTimeout(async () => {
                        if (nepaliInput.value.trim() === '') {
                            const transliteratedText = await transliterate(text);
                            if (transliteratedText) {
                                nepaliInput.value = transliteratedText;
                            }
                        }
                    }, 300);
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
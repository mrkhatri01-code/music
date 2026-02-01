@extends('layouts.app')

@section('title', $song->getMetaTitle())
@section('description', $song->getMetaDescription())
@section('canonical', $song->getCanonicalUrl())

@section('og_title', $song->title_nepali . ' - ' . $song->title_english . ' Lyrics')
@section('og_description', 'Read ' . $song->title_nepali . ' lyrics by ' . $song->artist->name_english)
@section('og_type', 'music.song')

@push('structured-data')
    <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "MusicRecording",
                  "name": "{{ $song->title_english }}",
                  "alternateName": "{{ $song->title_nepali }}",
                  "byArtist": {
                    "@type": "MusicGroup",
                    "name": "{{ $song->artist->name_english }}"
                  },
                  @if($song->album)
                      "inAlbum": {
                        "@type": "MusicAlbum",
                        "name": "{{ $song->album->name }}"
                      },
                  @endif
                  @if($song->genre)
                      "genre": "{{ $song->genre->name }}",
                  @endif
                  "url": "{{ $song->getCanonicalUrl() }}"
                }
                </script>

    <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "BreadcrumbList",
                  "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ route('home') }}"
                  },{
                    "@type": "ListItem",
                    "position": 2,
                    "name": "{{ $song->artist->name_english }}",
                    "item": "{{ route('artist.show', $song->artist->slug) }}"
                  },{
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ $song->title_english }}",
                    "item": "{{ $song->getCanonicalUrl() }}"
                  }]
                }
                </script>
@endpush

@section('content')
    {{-- Ad after title --}}
    @php
        $midAd1 = \App\Models\SiteSetting::get('ad_mid1');
    @endphp
    @if($midAd1)
        <div style="margin-bottom: 2rem; padding: 1rem; background: #f9f9f9; text-align: center; border-radius: 8px;">
            {!! $midAd1 !!}
        </div>
    @endif

    <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- Song Sidebar / Info --}}
        <div class="col-md-4" style="flex: 1; min-width: 300px; max-width: 400px;">
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                {{-- Album/Song Cover --}}
                @if($song->album && $song->album->cover_image)
                    <img src="{{ asset($song->album->cover_image) }}" alt="{{ $song->title_nepali }}"
                        style="width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem;">
                @else
                    <div
                        style="width: 100%; aspect-ratio: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; border-radius: 8px; margin-bottom: 1.5rem; font-size: 4rem; color: white;">
                        <i class="fa-solid fa-music"></i>
                    </div>
                @endif

                {{-- Song Title --}}
                <h1 style="font-size: 1.5rem; color: #2d3748; margin-bottom: 0.5rem; font-weight: 700;">
                    {{ $song->title_nepali }}</h1>
                <div style="font-size: 1.1rem; color: #718096; margin-bottom: 1rem;">{{ $song->title_english }}</div>

                {{-- Artist --}}
                <div style="font-size: 1rem; color: #667eea; margin-bottom: 1.5rem;">
                    <a href="{{ route('artist.show', $song->artist->slug) }}"
                        style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fa-solid fa-microphone"></i> By {{ $song->artist->name_english }}
                    </a>
                </div>

                {{-- Song Meta Info --}}
                <div
                    style="color: #718096; font-size: 0.9rem; line-height: 2; border-top: 1px solid #edf2f7; padding-top: 1rem;">
                    @if($song->genre)
                        <div><i class="fa-solid fa-music" style="width: 20px;"></i>
                            <a href="{{ route('genre.show', $song->genre->slug) }}"
                                style="color: inherit; text-decoration: none;">{{ $song->genre->name }}</a>
                        </div>
                    @endif
                    @if($song->year)
                        <div><i class="fa-solid fa-calendar-days" style="width: 20px;"></i> {{ $song->year }}</div>
                    @endif
                    @if($song->movie)
                        <div><i class="fa-solid fa-clapperboard" style="width: 20px;"></i> 
                            <a href="{{ route('movie.show', $song->movie->slug) }}" style="color: inherit; text-decoration: none;">{{ $song->movie->name }}</a>
                        </div>
                    @endif
                    @if($song->album)
                        <div><i class="fa-solid fa-compact-disc" style="width: 20px;"></i> {{ $song->album->name }}</div>
                    @endif
                    <div><i class="fa-solid fa-eye" style="width: 20px;"></i> {{ number_format($song->views_count) }} views
                    </div>
                </div>

                {{-- Share Buttons --}}
                <div style="margin-top: 1.5rem; border-top: 1px solid #edf2f7; padding-top: 1.5rem;">
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($song->getCanonicalUrl()) }}"
                            target="_blank"
                            style="flex: 1; padding: 0.75rem; border-radius: 8px; background: #1877f2; color: white; text-align: center; text-decoration: none; font-size: 0.9rem;">
                            <i class="fa-brands fa-facebook"></i> Share
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($song->title_nepali . ' Lyrics: ' . $song->getCanonicalUrl()) }}"
                            target="_blank"
                            style="flex: 1; padding: 0.75rem; border-radius: 8px; background: #25d366; color: white; text-align: center; text-decoration: none; font-size: 0.9rem;">
                            <i class="fa-brands fa-whatsapp"></i> Share
                        </a>
                    </div>
                    <button onclick="document.getElementById('reportForm').style.display='block'"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; background: #ed8936; color: white; border: none; cursor: pointer; font-size: 0.9rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Report Issue
                    </button>
                </div>
            </div>

            {{-- Sidebar Ad --}}
            @php
                $sidebarAd = \App\Models\SiteSetting::get('ad_sidebar');
            @endphp
            @if($sidebarAd)
                <div style="margin-top: 1.5rem; padding: 1rem; background: #f9f9f9; text-align: center; border-radius: 8px;">
                    {!! $sidebarAd !!}
                </div>
            @endif
        </div>

        {{-- Main Content --}}
        <div class="col-md-8" style="flex: 2; min-width: 300px;">
            {{-- Lyrics Section --}}
            @if($song->lyric)
                <div
                    style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: #2d3748; display: flex; align-items: center;">
                        <i class="fa-solid fa-file-lines" style="margin-right: 10px; color: #667eea;"></i> Lyrics
                    </h2>

                    <div style="margin-bottom: 1rem;">
                        <button class="lyrics-toggle-btn active" onclick="showLyrics('unicode')"
                            style="background: #667eea; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; transition: background 0.3s;">
                            Nepali (Unicode)
                        </button>
                        @if($song->lyric->content_romanized)
                            <button class="lyrics-toggle-btn" onclick="showLyrics('romanized')"
                                style="background: #e2e8f0; color: #4a5568; border: none; padding: 0.5rem 1.5rem; border-radius: 6px; cursor: pointer; transition: background 0.3s;">
                                Romanized
                            </button>
                        @endif
                    </div>

                    <div id="lyrics-unicode" class="lyrics-text"
                        style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                        {{ $song->lyric->content_unicode }}</div>

                    @if($song->lyric->content_romanized)
                        <div id="lyrics-romanized" class="lyrics-text"
                            style="display: none; font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                            {{ $song->lyric->content_romanized }}</div>
                    @endif
                </div>
            @else
                <div style="background: #fff5f5; color: #e53e3e; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                    <i class="fa-solid fa-circle-exclamation"></i> Lyrics not available for this song yet.
                </div>
            @endif

            {{-- Ad after first verse --}}
            @php
                $midAd2 = \App\Models\SiteSetting::get('ad_mid2');
            @endphp
            @if($midAd2)
                <div style="margin-bottom: 2rem; padding: 1rem; background: #f9f9f9; text-align: center; border-radius: 8px;">
                    {!! $midAd2 !!}
                </div>
            @endif

            {{-- YouTube Embed --}}
            @if($song->youtube_url)
                <div
                    style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fa-brands fa-youtube" style="margin-right: 10px; color: #ff0000;"></i> Watch Video
                    </h3>
                    <iframe src="https://www.youtube.com/embed/{{ getYouTubeId($song->youtube_url) }}" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen style="width: 100%; height: 400px; border-radius: 12px;">
                    </iframe>
                </div>
            @endif

            {{-- Report Form --}}
            <div id="reportForm"
                style="display: none; background: #fff5f5; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem;">Report an Issue</h3>
                <form action="{{ route('song.report', $song->slug) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem;">Issue Type:</label>
                        <select name="type" required
                            style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ddd;">
                            <option value="wrong_lyrics">Wrong Lyrics</option>
                            <option value="copyright">Copyright Claim</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem;">Description (optional):</label>
                        <textarea name="description" rows="3"
                            style="width: 100%; padding: 0.5rem; border-radius: 6px; border: 1px solid #ddd;"></textarea>
                    </div>
                    <button type="submit"
                        style="padding: 0.75rem 1.5rem; background: #ed8936; color: white; border: none; border-radius: 8px; cursor: pointer; margin-right: 0.5rem;">
                        Submit Report
                    </button>
                    <button type="button" onclick="document.getElementById('reportForm').style.display='none'"
                        style="padding: 0.75rem 1.5rem; background: #cbd5e0; border: none; border-radius: 8px; cursor: pointer;">
                        Cancel
                    </button>
                </form>
            </div>

            {{-- Related Songs Section --}}
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem; display: flex; align-items: center;">
                    <i class="fa-solid fa-list-music" style="margin-right: 10px; color: #667eea;"></i> More by
                    {{ $song->artist->name_english }}
                </h3>
                <div style="display: grid; gap: 1rem;">
                    @foreach($relatedByArtist->take(5) as $related)
                        <a href="{{ route('song.show', [$related->artist->slug, $related->slug]) }}"
                            style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                    {{ $related->title_nepali }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $related->title_english }}</div>
                            </div>
                            <i class="fa-solid fa-circle-play" style="font-size: 1.5rem; color: #667eea;"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            @if($song->genre && $relatedByGenre->count() > 0)
                <div
                    style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; display: flex; align-items: center;">
                        <i class="fa-solid fa-music" style="margin-right: 10px; color: #667eea;"></i> Similar Songs
                        ({{ $song->genre->name }})
                    </h3>
                    <div style="display: grid; gap: 1rem;">
                        @foreach($relatedByGenre as $related)
                            <a href="{{ route('song.show', [$related->artist->slug, $related->slug]) }}"
                                style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                        {{ $related->title_nepali }}</div>
                                    <div style="font-size: 0.9rem; color: #718096;">{{ $related->artist->name_english }}</div>
                                </div>
                                <i class="fa-solid fa-circle-play" style="font-size: 1.5rem; color: #667eea;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem; display: flex; align-items: center;">
                    <i class="fa-solid fa-fire" style="margin-right: 10px; color: #f56565;"></i> Trending Songs
                </h3>
                <div style="display: grid; gap: 1rem;">
                    @foreach($trendingSongs as $related)
                        <a href="{{ route('song.show', [$related->artist->slug, $related->slug]) }}"
                            style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                    {{ $related->title_nepali }}</div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $related->artist->name_english }}</div>
                            </div>
                            <i class="fa-solid fa-circle-play" style="font-size: 1.5rem; color: #667eea;"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function showLyrics(type) {
            document.getElementById('lyrics-unicode').style.display = type === 'unicode' ? 'block' : 'none';
            if (document.getElementById('lyrics-romanized')) {
                document.getElementById('lyrics-romanized').style.display = type === 'romanized' ? 'block' : 'none';
            }

            document.querySelectorAll('.lyrics-toggle-btn').forEach(btn => {
                btn.style.background = '#e2e8f0';
                btn.style.color = '#4a5568';
            });
            event.target.style.background = '#667eea';
            event.target.style.color = 'white';
        }

        // Prevent copying lyrics
        document.addEventListener('DOMContentLoaded', function () {
            const lyricsContainers = document.querySelectorAll('.lyrics-text');

            lyricsContainers.forEach(container => {
                container.addEventListener('contextmenu', function (e) {
                    e.preventDefault();
                    return false;
                });

                container.addEventListener('copy', function (e) {
                    e.preventDefault();
                    return false;
                });

                container.addEventListener('cut', function (e) {
                    e.preventDefault();
                    return false;
                });

                container.addEventListener('selectstart', function (e) {
                    e.preventDefault();
                    return false;
                });
            });
        });
    </script>
@endpush

@php
    // Helper function to extract YouTube ID
    function getYouTubeId($url)
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
        return $matches[1] ?? '';
    }
@endphp
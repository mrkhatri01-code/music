@extends('layouts.app')

@section('title', $song->getMetaTitle())
@section('description', $song->getMetaDescription())
@section('canonical', $song->getCanonicalUrl())

@section('og_title', $song->title_nepali . ' - ' . $song->title_english . ' Lyrics')
@section('og_description', 'Read ' . $song->title_nepali . ' lyrics by ' . ($song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist'))
@section('og_type', 'music.song')

@push('structured-data')
    <script type="application/ld+json">
                                                            {
                                                              "@context": "https://schema.org",
                                                              "@type": "MusicRecording",
                                                              "name": "{{ $song->title_english }}",
                                                              "alternateName": "{{ $song->title_nepali }}",
                                                              "byArtist": {
                                                                "name": "{{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}"
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
                                                                "name": "{{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}",
                                                                "item": "{{ route('artist.show', ($song->artist ?? $song->writer)->slug ?? 'unknown') }}"
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
    {{-- Success Notification --}}
    @if(session('success'))
        <div id="successToast"
            style="position: fixed; top: 80px; right: 20px; background: #48bb78; color: white; padding: 1rem 1.5rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; display: flex; align-items: center; gap: 0.75rem; animation: slideIn 0.3s ease;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Ad after title --}}
    @php
        $midAd1 = \App\Models\SiteSetting::get('ad_mid1');
        $adsEnabled = \App\Models\SiteSetting::get('ads_enabled', '1');
    @endphp
    @if($adsEnabled && $midAd1)
        <div style="margin-bottom: 2rem; padding: 1rem; background: #f9f9f9; text-align: center; border-radius: 8px;">
            {!! $midAd1 !!}
        </div>
    @endif

    <div class="row" style="display: flex; gap: 2rem; flex-wrap: wrap;">
        {{-- Song Sidebar / Info --}}
        <div class="col-md-4" style="flex: 1; min-width: 300px; max-width: 400px;">
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                {{-- Song Cover (priority: song > album > default) --}}
                @if($song->cover_image)
                    <img src="{{ asset($song->cover_image) }}" alt="{{ $song->title_nepali }}"
                        style="width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 1.5rem;">
                @elseif($song->album && $song->album->cover_image)
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
                    {{ $song->title_nepali }}
                </h1>
                <div style="font-size: 1.1rem; color: #718096; margin-bottom: 1rem;">{{ $song->title_english }}</div>

                {{-- Artist --}}
                @if($song->artist)
                    <div style="font-size: 1rem; color: #667eea; margin-bottom: 0.5rem;">
                        <a href="{{ route('artist.show', $song->artist->slug) }}"
                            style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-microphone"></i> Singer: {{ $song->artist->name_english }}
                        </a>
                    </div>
                @endif

                @if($song->writer_id)
                    <div style="font-size: 1rem; color: #667eea; margin-bottom: 1.5rem;">
                        <a href="{{ route('artist.show', $song->writer->slug) }}"
                            style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa-solid fa-pen-nib"></i> Writer: {{ $song->writer->name_english ?? 'Unknown' }}
                        </a>
                    </div>
                @else
                    <div style="margin-bottom: 1.5rem;"></div>
                @endif

                {{-- Song Meta Info --}}
                <div
                    style="color: #718096; font-size: 0.9rem; line-height: 2; border-top: 1px solid #edf2f7; padding-top: 1rem;">
                    @if($song->genre)
                        <div><i class="fa-solid fa-music" style="width: 20px;"></i>
                            <a href="{{ route('genre.show', $song->genre->slug) }}"
                                style="color: inherit; text-decoration: none;">{{ $song->genre->name }}</a>
                        </div>
                    @endif
                    @if($song->release_date)
                        <div><i class="fa-solid fa-calendar-days" style="width: 20px;"></i>
                            {{ $song->release_date->format('d M, Y') }}</div>
                    @elseif($song->year)
                        <div><i class="fa-solid fa-calendar-days" style="width: 20px;"></i> {{ $song->year }}</div>
                    @endif
                    @if($song->movie)
                        <div><i class="fa-solid fa-clapperboard" style="width: 20px;"></i>
                            <a href="{{ route('movie.show', $song->movie->slug) }}"
                                style="color: inherit; text-decoration: none;">{{ $song->movie->name }}</a>
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
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($song->getCanonicalUrl()) }}"
                            target="_blank"
                            style="padding: 0.75rem; border-radius: 8px; background: #1877f2; color: white; text-align: center; text-decoration: none; font-size: 0.9rem;">
                            <i class="fa-brands fa-facebook"></i> Facebook
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($song->title_nepali . ' Lyrics: ' . $song->getCanonicalUrl()) }}"
                            target="_blank"
                            style="padding: 0.75rem; border-radius: 8px; background: #25d366; color: white; text-align: center; text-decoration: none; font-size: 0.9rem;">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                    <button onclick="copyLinkToClipboard()" id="copyLinkBtn"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; background: #667eea; color: white; border: none; cursor: pointer; font-size: 0.9rem; margin-bottom: 0.5rem; transition: background 0.2s;">
                        <i class="fa-solid fa-link"></i> Copy Link
                    </button>
                    <a href="{{ route('song.report.form', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        style="width: 100%; padding: 0.75rem; border-radius: 8px; background: #ed8936; color: white; border: none; cursor: pointer; font-size: 0.9rem; text-decoration: none; display: block; text-align: center;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Report Issue
                    </a>
                </div>
            </div>

            {{-- Sidebar Ad --}}
            @php
                $sidebarAd = \App\Models\SiteSetting::get('ad_sidebar');
                $adsEnabled = $adsEnabled ?? \App\Models\SiteSetting::get('ads_enabled', '1');
            @endphp
            @if($adsEnabled && $sidebarAd)
                <div style="margin-top: 1.5rem; padding: 1rem; background: #f9f9f9; text-align: center; border-radius: 8px;">
                    {!! $sidebarAd !!}
                </div>
            @endif
        </div>

        {{-- Main Content --}}
        <div class="col-md-8" style="flex: 2; min-width: 300px;">
            {{-- Lyrics Section --}}
            @php
                $lyricsStatus = $song->lyrics_status ?? 'available';
            @endphp

            @if($lyricsStatus === 'coming_soon')
                {{-- Lyrics Coming Soon Message --}}
                <div
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 3rem 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; text-align: center; color: white;">
                    <i class="fa-solid fa-clock" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.9;"></i>
                    <h2 style="font-size: 1.75rem; margin-bottom: 0.75rem; font-weight: 700; color: white;">Lyrics Coming Soon!
                    </h2>
                    <p style="font-size: 1.1rem; margin-bottom: 0; opacity: 0.95; color: white;">We're working on adding the
                        lyrics for this song. Check back soon!</p>
                    {{-- Notify Me Button --}}
                    <div onclick="openNotifyModal()"
                        style="margin-top: 1.5rem; padding: 1rem; background: #ed8936; border-radius: 8px; cursor: pointer; transition: background 0.3s; display: inline-block; color: white;">
                        <i class="fa-solid fa-bell" style="margin-right: 0.5rem;"></i>
                        <span>Notify Me</span>
                    </div>
                </div>

                {{-- Notify Me Modal --}}
                <div id="notifyModal"
                    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10001; align-items: center; justify-content: center;">
                    <div
                        style="background: white; padding: 2rem; border-radius: 12px; width: 90%; max-width: 400px; text-align: center; position: relative;">
                        <button onclick="closeNotifyModal()"
                            style="position: absolute; top: 10px; right: 10px; border: none; background: none; font-size: 1.2rem; cursor: pointer; color: #718096;"><i
                                class="fa-solid fa-xmark"></i></button>

                        <div
                            style="width: 60px; height: 60px; background: #ebf8ff; color: #4299e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                            <i class="fa-solid fa-bell"></i>
                        </div>

                        <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #2d3748;">Get Notified!</h3>
                        <p style="color: #718096; margin-bottom: 1.5rem;">Enter your email and we'll send you the lyrics as soon
                            as they are released.</p>

                        <form id="notifyForm" onsubmit="submitNotifyForm(event)">
                            <input type="email" id="notifyEmail" placeholder="your@email.com" required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem; outline: none; transition: border 0.3s;"
                                onfocus="this.style.borderColor='#667eea'" onblur="this.style.borderColor='#e2e8f0'">

                            <button type="submit" id="notifySubmitBtn"
                                style="width: 100%; padding: 0.75rem; background: #667eea; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($song->lyric)
                <div
                    style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem; position: relative;" id="printable-lyrics">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h2 style="font-size: 1.5rem; margin: 0; color: #2d3748; display: flex; align-items: center;">
                            <i class="fa-solid fa-file-lines" style="margin-right: 10px; color: #667eea;"></i> Lyrics
                        </h2>
                        <button onclick="printLyrics()" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;" id="print-lyrics-btn">
                            <i class="fa-solid fa-print"></i> Print
                        </button>
                    </div>

                    @php
                        $songLanguage = $song->language ?? 'nepali';
                    @endphp

                    {{-- Nepali Song: Show Unicode + Romanized Toggle --}}
                    @if($songLanguage === 'nepali')
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
                            style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                            <span
                                style="display: block; margin: 0; padding: 0; text-indent: 0;">{{ trim($song->lyric->content_unicode) }}</span>
                        </div>

                        @if($song->lyric->content_romanized)
                            <div id="lyrics-romanized" class="lyrics-text"
                                style="display: none; font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                                <span
                                    style="display: block; margin: 0; padding: 0; text-indent: 0;">{{ trim($song->lyric->content_romanized) }}</span>
                            </div>
                        @endif
                    @endif

                    {{-- Hindi Song: Show Hindi Lyrics Only --}}
                    @if($songLanguage === 'hindi')
                        <div
                            style="margin-bottom: 0.5rem; padding: 0.5rem 1rem; background: #f0f4ff; border-radius: 6px; display: inline-block;">
                            <i class="fa-solid fa-language" style="color: #667eea; margin-right: 0.5rem;"></i>
                            <span style="color: #4a5568; font-weight: 600;">Hindi</span>
                        </div>
                        <div class="lyrics-text"
                            style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                            <span
                                style="display: block; margin: 0; padding: 0; text-indent: 0;">{{ trim($song->lyric->content_unicode) }}</span>
                        </div>
                    @endif

                    {{-- English Song: Show English Lyrics Only --}}
                    @if($songLanguage === 'english')
                        <div
                            style="margin-bottom: 0.5rem; padding: 0.5rem 1rem; background: #f0f4ff; border-radius: 6px; display: inline-block;">
                            <i class="fa-solid fa-language" style="color: #667eea; margin-right: 0.5rem;"></i>
                            <span style="color: #4a5568; font-weight: 600;">English</span>
                        </div>
                        <div class="lyrics-text"
                            style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; padding: 1.5rem; background: #f7fafc; border-radius: 8px; border-left: 4px solid #667eea; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                            <span
                                style="display: block; margin: 0; padding: 0; text-indent: 0;">{{ trim($song->lyric->content_unicode) }}</span>
                        </div>
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
                $adsEnabled = $adsEnabled ?? \App\Models\SiteSetting::get('ads_enabled', '1');
            @endphp
            @if($adsEnabled && $midAd2)
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
                    {{-- Responsive 16:9 aspect ratio container --}}
                    <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px;">
                        <iframe src="https://www.youtube.com/embed/{{ getYouTubeId($song->youtube_url) }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>
                    </div>
                </div>
            @endif



            {{-- Related Songs Section --}}
            <div
                style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; margin-bottom: 1rem; display: flex; align-items: center;">
                    <i class="fa-solid fa-list-music" style="margin-right: 10px; color: #667eea;"></i> More by
                    {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                </h3>
                <div style="display: grid; gap: 1rem;">
                    @foreach($relatedByArtist->take(5) as $related)
                        <a href="{{ route('song.show', [($related->artist ?? $related->writer)->slug ?? 'unknown', $related->slug]) }}"
                            style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                    {{ $related->title_nepali }}
                                    @if(isset($related->lyrics_status) && $related->lyrics_status === 'coming_soon')
                                        <div style="font-size: 0.65rem; color: #f59e0b; display: inline-block; margin-left: 5px;">
                                            <i class="fa-solid fa-clock"></i>
                                        </div>
                                    @endif
                                </div>
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
                            <a href="{{ route('song.show', [($related->artist ?? $related->writer)->slug ?? 'unknown', $related->slug]) }}"
                                style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                        {{ $related->title_nepali }}
                                        @if(isset($related->lyrics_status) && $related->lyrics_status === 'coming_soon')
                                            <div style="font-size: 0.65rem; color: #f59e0b; display: inline-block; margin-left: 5px;">
                                                <i class="fa-solid fa-clock"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.9rem; color: #718096;">{{ $related->artist->name_english ?? $related->writer->name_english ?? 'Unknown Artist' }}</div>
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
                        <a href="{{ route('song.show', [($related->artist ?? $related->writer)->slug ?? 'unknown', $related->slug]) }}"
                            style="display: flex; align-items: center; padding: 1rem; background: #f7fafc; border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: #2d3748; margin-bottom: 0.2rem;">
                                    {{ $related->title_nepali }}
                                    @if(isset($related->lyrics_status) && $related->lyrics_status === 'coming_soon')
                                        <div
                                            style="font-size: 0.65rem; background: #e2e8f0; color: #4a5568; padding: 1px 4px; border-radius: 3px; display: inline-block; margin-left: 5px;">
                                            <i class="fa-solid fa-clock"></i>
                                        </div>
                                    @endif
                                </div>
                                <div style="font-size: 0.9rem; color: #718096;">{{ $related->artist->name_english ?? $related->writer->name_english ?? 'Unknown Artist' }}</div>
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
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    </style>
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

        function showNotification(message, type = 'success') {
            const colors = {
                success: '#48bb78',
                info: '#4299e1',
                warning: '#ed8936',
                error: '#f56565'
            };

            const icons = {
                success: 'fa-circle-check',
                info: 'fa-circle-info',
                warning: 'fa-triangle-exclamation',
                error: 'fa-circle-xmark'
            };

            const toast = document.createElement('div');
            toast.style.cssText = `
                                                            position: fixed;
                                                            top: 80px;
                                                            right: 20px;
                                                            background: ${colors[type]};
                                                            color: white;
                                                            padding: 1rem 1.5rem;
                                                            border-radius: 8px;
                                                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                                            z-index: 9999;
                                                            display: flex;
                                                            align-items: center;
                                                            gap: 0.75rem;
                                                            animation: slideIn 0.3s ease;
                                                        `;
            toast.innerHTML = `<i class="fa-solid ${icons[type]}" style="font-size: 1.2rem;"></i><span>${message}</span>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Auto-hide success toast
        document.addEventListener('DOMContentLoaded', function () {
            const successToast = document.getElementById('successToast');
            if (successToast) {
                setTimeout(() => {
                    successToast.style.animation = 'slideOut 0.3s ease';
                    setTimeout(() => successToast.remove(), 300);
                }, 4000);
            }

            // Prevent copying lyrics
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
            });

            // Prevent selecting lyrics
            document.addEventListener('selectstart', function (e) {
                if (e.target.classList.contains('lyrics-text') || e.target.closest('.lyrics-text')) {
                    e.preventDefault();
                }
            });
        });

        // YouTube ID Helper
        function getYouTubeID(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        // Copy Link to Clipboard Function
        // Copy Link to Clipboard Function
        function copyLinkToClipboard() {
            const href = window.location.href;
            const btn = document.getElementById('copyLinkBtn');
            const originalHTML = btn.innerHTML; // Store original HTML

            const showSuccess = () => {
                btn.innerHTML = '<i class=\"fa-solid fa-check\"></i> Link Copied!';
                btn.style.background = '#48bb78';
                showToast('Link copied to clipboard!', 'success');
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.background = '#667eea';
                }, 2000);
            };

            const showError = (err) => {
                showToast('Failed to copy link', 'error');
                console.error('Copy failed: ', err);
            };

            // 1. Try Clipboard API (Modern, prefers HTTPS)
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(href)
                    .then(showSuccess)
                    .catch(() => {
                        // If API fails (e.g. permission denied), try fallback
                        fallbackCopyTextToClipboard(href, showSuccess, showError);
                    });
            } else {
                // 2. Fallback for older browsers or HTTP
                fallbackCopyTextToClipboard(href, showSuccess, showError);
            }
        }

        function fallbackCopyTextToClipboard(text, onSuccess, onError) {
            var textArea = document.createElement("textarea");
            textArea.value = text;

            // Ensure textArea is not visible but part of DOM
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            textArea.style.opacity = "0";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                if (successful) {
                    onSuccess();
                } else {
                    onError('execCommand returned false');
                }
            } catch (err) {
                onError(err);
            }

            document.body.removeChild(textArea);
        }

        // Toast Notification Function
        function showToast(message, type = 'success') {
            const bgColor = type === 'success' ? '#48bb78' : '#e53e3e';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const toast = document.createElement('div');
            toast.style.cssText = `
                                                            position: fixed;
                                                            top: 80px;
                                                            right: 20px;
                                                            background: ${bgColor};
                                                            color: white;
                                                            padding: 1rem 1.5rem;
                                                            border-radius: 8px;
                                                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                                            z-index: 10000;
                                                            display: flex;
                                                            align-items: center;
                                                            gap: 0.75rem;
                                                            animation: slideIn 0.3s ease;
                                                        `;
            toast.innerHTML = `
                                                            <i class="fa-solid ${icon}" style="font-size: 1.2rem;"></i>
                                                            <span>${message}</span>
                                                        `;

            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(function () {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(function () {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Bookmark Page Function
        function bookmarkPage() {
            const title = document.title;
            const url = window.location.href;

            // Try to use browser API
            if (window.sidebar && window.sidebar.addPanel) { // Firefox <23
                window.sidebar.addPanel(title, url, "");
            } else if (window.external && ('AddFavorite' in window.external)) { // IE
                window.external.AddFavorite(url, title);
            } else if (window.opera && window.print) { // Opera <15
                this.title = title;
                return true;
            } else {
                // Modern browsers (Chrome, Safari, Firefox, Edge) - Show instructions
                const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
                const shortcut = isMac ? 'Cmd + D' : 'Ctrl + D';
                showToast(`Press ${shortcut} to bookmark page`, 'success');

                // Visual feedback on button
                const btn = document.getElementById('bookmarkText');
                if (btn) {
                    btn.innerText = `Press ${shortcut}`;
                    setTimeout(() => {
                        btn.innerText = 'Bookmark this page to stay updated';
                    }, 3000);
                }
            }
        }
        // Notify Me Modal Functions
        function openNotifyModal() {
            document.getElementById('notifyModal').style.display = 'flex';
            setTimeout(() => document.getElementById('notifyEmail').focus(), 100);
        }

        function closeNotifyModal() {
            document.getElementById('notifyModal').style.display = 'none';
        }

        // Close modal on outside click
        document.getElementById('notifyModal').addEventListener('click', function (e) {
            if (e.target === this) closeNotifyModal();
        });

        function submitNotifyForm(e) {
            e.preventDefault();
            const email = document.getElementById('notifyEmail').value;
            const btn = document.getElementById('notifySubmitBtn');
            const originalText = btn.innerText;

            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Subscribing...';

            fetch('{{ route("subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email,
                    song_id: {{ $song->id }}
                                                        })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        closeNotifyModal();
                        document.getElementById('notifyEmail').value = ''; // Clear input
                    } else {
                        showToast(data.message || 'Something went wrong', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Failed to subscribe. Please try again.', 'error');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = originalText;
                });
        }
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

{{-- Fixed Ad Section (Bottom-Right Sticky) --}}
@php
    $lyricsFixedAd = \App\Models\SiteSetting::get('lyrics_fixed_ad', '');
    $adsEnabled = \App\Models\SiteSetting::get('ads_enabled', '1');
@endphp
@if($adsEnabled && $lyricsFixedAd)
    <div id="fixedAdContainer"
        style="position: fixed; bottom: 20px; right: 20px; z-index: 9998; max-width: 350px; background: white; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); overflow: hidden; animation: slideInUp 0.5s ease; display: none;">
        {{-- Close Button --}}
        <button onclick="closeFixedAd()"
            style="position: absolute; top: 10px; right: 10px; width: 32px; height: 32px; border: none; background: rgba(0,0,0,0.7); color: white; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: all 0.2s;"
            onmouseover="this.style.background='rgba(0,0,0,0.9)'; this.style.transform='scale(1.1)'"
            onmouseout="this.style.background='rgba(0,0,0,0.7)'; this.style.transform='scale(1)'">
            <i class="fa-solid fa-xmark" style="font-size: 1.2rem;"></i>
        </button>

        {{-- Ad Content --}}
        <div style="padding: 1rem;">
            {!! $lyricsFixedAd !!}
        </div>
    </div>

    <style>
        @keyframes slideInUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Hide on mobile */
        @media (max-width: 768px) {
            #fixedAdContainer {
                display: none !important;
            }
        }

        /* Show on desktop after delay */
        @media (min-width: 769px) {
            #fixedAdContainer {
                display: block;
            }
        }
    </style>

    <script>
        // Show ad after 2 seconds
        setTimeout(function () {
            const adContainer = document.getElementById('fixedAdContainer');
            if (adContainer && window.innerWidth > 768) {
                adContainer.style.display = 'block';
            }
        }, 2000);

        function closeFixedAd() {
            const adContainer = document.getElementById('fixedAdContainer');
            adContainer.style.animation = 'slideInUp 0.3s ease reverse';
            setTimeout(() => {
                adContainer.style.display = 'none';
            }, 300);
        }
    </script>
@endif

@push('scripts')
<script>
    function printLyrics() {
        const romanizedBlock = document.getElementById('lyrics-romanized');
        const type = (romanizedBlock && romanizedBlock.style.display !== 'none') ? 'romanized' : 'unicode';
        
        const printUrl = "{{ route('song.print', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}?type=" + type;
        window.open(printUrl, '_blank');
    }
</script>
@endpush
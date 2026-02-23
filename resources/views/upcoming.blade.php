@extends('layouts.app')

@section('title', 'Upcoming Lyrics - Songs Coming Soon')

@section('content')
    <div
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2.5rem; border-radius: 12px; margin-bottom: 2rem; position: relative; overflow: hidden;">
        <div style="position: relative; z-index: 2;">
            <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem; font-weight: 700;">Upcoming Lyrics</h1>
            <p style="opacity: 0.9; font-size: 1.1rem; max-width: 600px;">
                We are currently working on adding lyrics for these songs. Bookmark them and check back soon!
            </p>
        </div>
        <i class="fa-solid fa-clock"
            style="position: absolute; right: -20px; bottom: -40px; font-size: 10rem; opacity: 0.1;"></i>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($songs as $song)
            <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-decoration: none; color: inherit; transition: transform 0.2s, box-shadow 0.2s; display: block;">

                {{-- Cover Image Area --}}
                <div style="position: relative; padding-top: 100%;">
                    @if($song->cover_image)
                        <img src="{{ asset($song->cover_image) }}" alt="{{ $song->title_nepali }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    @elseif($song->album && $song->album->cover_image)
                        <img src="{{ asset($song->album->cover_image) }}" alt="{{ $song->title_nepali }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #e0e7ff 0%, #c3dafe 100%); display: flex; align-items: center; justify-content: center; color: #667eea; font-size: 3rem;">
                            <i class="fa-solid fa-music"></i>
                        </div>
                    @endif

                    {{-- Badge --}}
                    <div
                        style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; backdrop-filter: blur(4px);">
                        <i class="fa-solid fa-clock" style="margin-right: 4px;"></i> Coming Soon
                    </div>
                </div>

                <div style="padding: 1.25rem;">
                    <div
                        style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #2d3748; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $song->title_nepali }}
                    </div>
                    <div style="color: #667eea; margin-bottom: 0.75rem; font-size: 0.95rem;">
                        {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                    </div>
                    <div style="font-size: 0.85rem; color: #a0aec0; display: flex; justify-content: space-between;">
                        <span><i class="fa-solid fa-calendar-days"></i> {{ $song->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div
                style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: #f7fafc; border-radius: 12px; color: #718096;">
                <i class="fa-solid fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; color: #48bb78;"></i>
                <p style="font-size: 1.2rem;">All songs have lyrics available!</p>
                <p>Check back later for new releases.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 3rem; text-align: center;">
        {{ $songs->links() }}
    </div>

    <style>
        a:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
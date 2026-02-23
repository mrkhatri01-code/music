@extends('layouts.app')

@section('title', 'Search Results for "' . $query . '"')

@section('content')
    <style>
        .search-header {
            margin-bottom: 2rem;
        }

        .search-header h1 {
            font-size: 2rem;
            color: #2d3748;
        }

        .search-form-page {
            margin: 2rem 0;
            max-width: 600px;
        }

        .search-form-page input {
            width: 100%;
            padding: 1rem;
            font-size: 1.1rem;
            border: 2px solid #ddd;
            border-radius: 8px;
        }

        .results-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .results-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }

        .result-item {
            padding: 1.5rem;
            background: #f7fafc;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-decoration: none;
            color: inherit;
            display: block;
            transition: background 0.3s;
        }

        .result-item:hover {
            background: #edf2f7;
        }

        .result-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 0.3rem;
        }

        .result-meta {
            font-size: 0.9rem;
            color: #718096;
        }
    </style>

    <div class="search-header">
        <h1><i class="fa-solid fa-magnifying-glass" style="margin-right: 10px;"></i>Search Results @if($query) for
        "{{ $query }}" @endif</h1>
    </div>

    <div class="search-form-page">
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search for songs, artists..." autofocus>
        </form>
    </div>

    @if(empty($query))
        <p style="color: #718096;">Enter a search term to find songs and artists.</p>
    @else
        {{-- Songs Results --}}
        @if(isset($results['songs']) && $results['songs']->count() > 0)
            <div class="results-section">
                <h2>Songs ({{ $results['songs']->count() }})</h2>
                @foreach($results['songs'] as $song)
                    <a href="{{ route('song.show', [($song->artist ?? $song->writer)->slug ?? 'unknown', $song->slug]) }}"
                        class="result-item">
                        <div class="result-title">
                            {{ $song->title_nepali }} - {{ $song->title_english }}
                            @if(isset($song->lyrics_status) && $song->lyrics_status === 'coming_soon')
                                <span
                                    style="font-size: 0.75rem; color: #f59e0b; vertical-align: middle; margin-left: 5px; font-weight: normal;">
                                    <i class="fa-solid fa-clock"></i> Coming Soon
                                </span>
                            @endif
                        </div>
                        <div class="result-meta">
                            By {{ $song->artist->name_english ?? $song->writer->name_english ?? 'Unknown Artist' }}
                            @if($song->genre) | <i class="fa-solid fa-music"></i> {{ $song->genre->name }} @endif
                            @if($song->release_date)
                                | <i class="fa-solid fa-calendar-days"></i> {{ $song->release_date->format('d M, Y') }}
                            @elseif($song->year)
                                | <i class="fa-solid fa-calendar-days"></i> {{ $song->year }}
                            @endif
                            | <i class="fa-solid fa-eye"></i> {{ number_format($song->views_count) }} views
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Artists Results --}}
        @if(isset($results['artists']) && $results['artists']->count() > 0)
            <div class="results-section">
                <h2>Artists ({{ $results['artists']->count() }})</h2>
                @foreach($results['artists'] as $artist)
                    <a href="{{ route('artist.show', $artist->slug) }}" class="result-item">
                        <div class="result-title">{{ $artist->name_english }} ({{ $artist->name_nepali }})</div>
                        <div class="result-meta">
                            <i class="fa-solid fa-music"></i> {{ $artist->songs_count ?? 0 }} songs
                            | <i class="fa-solid fa-eye"></i> {{ number_format($artist->views_count) }} views
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- No Results --}}
        @if((!isset($results['songs']) || $results['songs']->count() == 0) && (!isset($results['artists']) || $results['artists']->count() == 0))
            <div class="results-section">
                <p style="color: #718096;">No results found for "{{ $query }}". Try different keywords.</p>
            </div>
        @endif
    @endif

@endsection
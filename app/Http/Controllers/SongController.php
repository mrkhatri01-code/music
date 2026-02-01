<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Report;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function show($artistSlug, $songSlug)
    {
        $song = Song::where('slug', $songSlug)
            ->whereHas('artist', function ($query) use ($artistSlug) {
                $query->where('slug', $artistSlug);
            })
            ->with(['artist', 'genre', 'movie', 'album', 'lyric', 'tags'])
            ->published()
            ->firstOrFail();

        // Track view
        $song->incrementViews(request()->ip(), request()->userAgent());

        // Get related songs
        $relatedByArtist = $song->artist->getTopSongs(5);
        $relatedByGenre = Song::where('genre_id', $song->genre_id)
            ->where('id', '!=', $song->id)
            ->published()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        $trendingSongs = Song::trending('week')->limit(5)->get();

        return view('song.show', compact(
            'song',
            'relatedByArtist',
            'relatedByGenre',
            'trendingSongs'
        ));
    }

    public function report(Request $request, $songSlug)
    {
        $request->validate([
            'type' => 'required|in:wrong_lyrics,copyright',
            'description' => 'nullable|string|max:1000',
        ]);

        $song = Song::where('slug', $songSlug)->firstOrFail();

        Report::create([
            'song_id' => $song->id,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Thank you for your report. We will review it shortly.');
    }
}

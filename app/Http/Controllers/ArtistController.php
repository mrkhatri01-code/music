<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function show($slug)
    {
        $artist = Artist::where('slug', $slug)
            ->with([
                'albums',
                'songs' => function ($query) {
                    $query->published()->orderBy('views_count', 'desc');
                }
            ])
            ->firstOrFail();

        // Increment artist views
        $artist->incrementViews();

        // Fetch upcoming songs
        $upcomingSongs = $artist->songs()
            ->where('lyrics_status', 'coming_soon')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $topSongs = $artist->songs()
            ->published() // This includes coming_soon if published, but sorted by views
            ->where('lyrics_status', '!=', 'coming_soon') // Exclude coming soon from top songs to avoid duplication or burial
            ->orderBy('views_count', 'desc')
            ->take(20)
            ->get();

        $topWrittenSongs = $artist->writtenSongs()
            ->published()
            ->where('lyrics_status', '!=', 'coming_soon')
            ->orderBy('views_count', 'desc')
            ->take(20)
            ->get();

        $albums = $artist->albums;

        return view('artist.show', compact('artist', 'topSongs', 'upcomingSongs', 'topWrittenSongs', 'albums'));
    }
}

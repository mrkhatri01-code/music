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

        $topSongs = $artist->songs->take(20);
        $albums = $artist->albums;

        return view('artist.show', compact('artist', 'topSongs', 'albums'));
    }
}

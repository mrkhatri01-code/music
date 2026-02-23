<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with(['artist'])
            ->withCount('songs')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('album.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = Album::where('slug', $slug)
            ->with([
                'artist',
                'songs' => function ($query) {
                    // Try to order by track number if available, otherwise by id/creation
                    // Assuming Schema has 'id' or 'position' logic. 
                    // Songs table usually has id.
                    $query->orderBy('id', 'asc');
                }
            ])
            ->withCount('songs')
            ->firstOrFail();

        return view('album.show', compact('album'));
    }
}

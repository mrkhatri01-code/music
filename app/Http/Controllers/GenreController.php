<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('songs')
            ->orderBy('songs_count', 'desc')
            ->get();

        return view('genre.index', compact('genres'));
    }

    public function show($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();

        $songs = $genre->songs()
            ->published()
            ->with('artist')
            ->orderBy('views_count', 'desc')
            ->paginate(30);

        return view('genre.show', compact('genre', 'songs'));
    }
}

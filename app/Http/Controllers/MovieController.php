<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::withCount('songs')
            ->orderBy('name')
            ->paginate(24);

        return view('movie.index', compact('movies'));
    }

    public function show($slug)
    {
        $movie = Movie::where('slug', $slug)
            ->withCount('songs')
            ->firstOrFail();

        $songs = $movie->songs()
            ->with(['artist', 'genre'])
            ->where('is_published', true)
            ->orderBy('title_nepali')
            ->get();

        return view('movie.show', compact('movie', 'songs'));
    }
}

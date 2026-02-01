<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return view('search.results', ['query' => '', 'results' => collect()]);
        }

        // Search songs, artists, and movies
        $songs = Song::published()
            ->where(function ($q) use ($query) {
                $q->where('title_english', 'LIKE', "%{$query}%")
                    ->orWhere('title_nepali', 'LIKE', "%{$query}%");
            })
            ->with(['artist', 'genre'])
            ->limit(20)
            ->get();

        $artists = Artist::where('name_english', 'LIKE', "%{$query}%")
            ->orWhere('name_nepali', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        $results = [
            'songs' => $songs,
            'artists' => $artists,
        ];

        return view('search.results', compact('query', 'results'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $songs = Song::published()
            ->where(function ($q) use ($query) {
                $q->where('title_english', 'LIKE', "%{$query}%")
                    ->orWhere('title_nepali', 'LIKE', "%{$query}%");
            })
            ->with('artist')
            ->limit(5)
            ->get()
            ->map(function ($song) {
                return [
                    'title' => $song->title_nepali . ' - ' . $song->title_english,
                    'artist' => $song->artist->name_english,
                    'url' => url("/lyrics/{$song->artist->slug}/{$song->slug}"),
                ];
            });

        $artists = Artist::where('name_english', 'LIKE', "%{$query}%")
            ->orWhere('name_nepali', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($artist) {
                return [
                    'title' => $artist->name_nepali . ' (' . $artist->name_english . ')',
                    'type' => 'artist',
                    'url' => url("/artist/{$artist->slug}"),
                ];
            });

        return response()->json($songs->concat($artists));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Festival;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache homepage data for performance
        $trendingToday = Cache::remember('trending_today', 3600, function () {
            return Song::trending('today')
                ->where('lyrics_status', '!=', 'coming_soon')
                ->with('artist')->limit(4)->get();
        });

        $trendingWeek = Cache::remember('trending_week', 3600, function () {
            return Song::trending('week')
                ->where('lyrics_status', '!=', 'coming_soon')
                ->with('artist')->limit(4)->get();
        });

        $newSongs = Song::published()
            ->with('artist')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $topArtists = Artist::orderBy('views_count', 'desc')
            ->limit(4)
            ->get();

        $festivals = Festival::orderBy('start_date', 'desc')->limit(6)->get();
        $genres = Genre::withCount('songs')->orderBy('songs_count', 'desc')->limit(4)->get();

        return view('home', compact(
            'trendingToday',
            'trendingWeek',
            'newSongs',
            'topArtists',
            'festivals',
            'genres'
        ));
    }

    public function trending($period = 'week')
    {
        $songs = Song::trending($period)
            ->where('lyrics_status', '!=', 'coming_soon')
            ->with(['artist', 'genre'])
            ->paginate(30);

        $title = match ($period) {
            'today' => 'Trending Today',
            'week' => 'Trending This Week',
            'month' => 'Trending This Month',
            default => 'Trending Songs',
        };

        return view('trending.index', compact('songs', 'title', 'period'));
    }

    public function trendingToday()
    {
        return $this->trending('today');
    }

    public function trendingWeek()
    {
        return $this->trending('week');
    }

    public function trendingMonth()
    {
        return $this->trending('month');
    }

    public function newSongs()
    {
        $songs = Song::published()
            ->with(['artist', 'genre'])
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('new.index', compact('songs'));
    }

    public function newSongsByYear($year)
    {
        $songs = Song::published()
            ->with(['artist', 'genre'])
            ->where('year', $year)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('new.index', compact('songs', 'year'));
    }

    public function topArtists()
    {
        $artists = Artist::orderBy('views_count', 'desc')
            ->withCount('songs')
            ->paginate(24);

        return view('artists.index', compact('artists'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_songs' => Song::count(),
            'published_songs' => Song::where('is_published', true)->count(),
            'total_artists' => Artist::count(),
            'total_genres' => Genre::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'total_views' => Song::sum('views_count'),
        ];

        $recentSongs = Song::with('artist')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $topSongs = Song::published()
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();

        $pendingReports = Report::with('song')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSongs', 'topSongs', 'pendingReports'));
    }
}

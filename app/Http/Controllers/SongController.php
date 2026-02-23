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
            ->whereRaw('? in (
                select slug from artists where id = songs.artist_id or id = songs.writer_id
            )', [$artistSlug])
            ->with(['artist', 'genre', 'movie', 'album', 'lyric', 'tags'])
            ->published()
            ->firstOrFail();

        // Track view
        $song->incrementViews(request()->ip(), request()->userAgent());

        // Get related songs
        $primaryArtist = $song->artist ?? $song->writer;
        $relatedByArtist = $primaryArtist ? $primaryArtist->getTopSongs(5) : collect();
        $relatedByGenre = Song::where('genre_id', $song->genre_id)
            ->where('id', '!=', $song->id)
            ->published()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        $trendingSongs = Song::trending('week')
            ->where('lyrics_status', '!=', 'coming_soon')
            ->limit(5)
            ->get();

        return view('song.show', compact(
            'song',
            'relatedByArtist',
            'relatedByGenre',
            'trendingSongs'
        ));
    }

    public function print($artistSlug, $songSlug)
    {
        $song = Song::where('slug', $songSlug)
            ->whereRaw('? in (
                select slug from artists where id = songs.artist_id or id = songs.writer_id
            )', [$artistSlug])
            ->with(['artist', 'writer', 'lyric'])
            ->published()
            ->firstOrFail();

        $type = request()->query('type', 'unicode');

        return view('song.print', compact('song', 'type'));
    }

    public function showReportForm($artistSlug, $songSlug)
    {
        $song = Song::where('slug', $songSlug)
            ->whereRaw('? in (
                select slug from artists where id = songs.artist_id or id = songs.writer_id
            )', [$artistSlug])
            ->with(['artist'])
            ->published()
            ->firstOrFail();

        return view('report', compact('song'));
    }

    public function report(Request $request, $songSlug)
    {
        // Rate limiting: Check if user has reported within the last 2 minutes
        $lastReportTime = session('last_report_time');
        $currentTime = now();

        if ($lastReportTime) {
            $timeSinceLastReport = $currentTime->diffInSeconds($lastReportTime);
            $waitTime = 120; // 2 minutes in seconds

            if ($timeSinceLastReport < $waitTime) {
                $remainingTime = $waitTime - $timeSinceLastReport;
                $minutes = floor($remainingTime / 60);
                $seconds = $remainingTime % 60;

                $timeMessage = $minutes > 0
                    ? "{$minutes} minute(s) and {$seconds} second(s)"
                    : "{$seconds} second(s)";

                return back()->with('error', "Please wait {$timeMessage} before submitting another report.");
            }
        }

        $validation = [
            'type' => 'required|in:wrong_lyrics,copyright',
            'description' => 'nullable|string|max:1000',
        ];

        // Add copyright claimant fields if type is copyright
        if ($request->type === 'copyright') {
            $validation['claimant_name'] = 'required|string|max:255';
            $validation['claimant_email'] = 'required|email|max:255';
            $validation['claimant_phone'] = 'nullable|string|max:20';
        }

        $request->validate($validation);

        $song = Song::where('slug', $songSlug)->firstOrFail();

        Report::create([
            'song_id' => $song->id,
            'type' => $request->type,
            'description' => $request->description,
            'claimant_name' => $request->claimant_name,
            'claimant_email' => $request->claimant_email,
            'claimant_phone' => $request->claimant_phone,
        ]);

        // Store the current time in session for rate limiting
        session(['last_report_time' => $currentTime]);

        return back()->with('success', 'Thank you for your report. We will review it shortly.');
    }
}

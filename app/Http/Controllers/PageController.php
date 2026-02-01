<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Tag;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Legal Pages
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function dmca()
    {
        return view('pages.dmca');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function termsOfService()
    {
        return view('pages.terms');
    }

    public function disclaimer()
    {
        return view('pages.disclaimer');
    }

    // Mood-based pages
    public function loveSongs()
    {
        return $this->moodPage('love-songs', 'Love Songs', 'Romantic Nepali love songs collection');
    }

    public function sadSongs()
    {
        return $this->moodPage('sad-songs', 'Sad Songs', 'Emotional sad Nepali songs');
    }

    public function romanticSongs()
    {
        return $this->moodPage('romantic-songs', 'Romantic Songs', 'Best romantic Nepali songs');
    }

    public function partySongs()
    {
        return $this->moodPage('party-songs', 'Party Songs', 'Upbeat Nepali party songs');
    }

    public function trendingOnTikTok()
    {
        return $this->moodPage('trending-on-tiktok', 'Trending on TikTok', 'Popular Nepali songs on TikTok');
    }

    private function moodPage($tagSlug, $title, $description)
    {
        // Get songs with this tag
        $tag = Tag::where('slug', $tagSlug)->first();

        if ($tag) {
            $songs = $tag->songs()
                ->published()
                ->with(['artist', 'genre'])
                ->orderBy('views_count', 'desc')
                ->paginate(30);
        } else {
            $songs = collect();
        }

        return view('pages.mood', compact('songs', 'title', 'description', 'tagSlug'));
    }
}

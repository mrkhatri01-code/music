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
        $aboutContent = \App\Models\SiteSetting::get('about_us_content');
        $teamMembers = \App\Models\TeamMember::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('pages.about', compact('aboutContent', 'teamMembers'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        \App\Models\Contact::create($validated);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function dmca()
    {
        $content = \App\Models\SiteSetting::get('dmca_content');
        return view('pages.dmca', compact('content'));
    }

    public function privacyPolicy()
    {
        $content = \App\Models\SiteSetting::get('privacy_policy_content');
        return view('pages.privacy-policy', compact('content'));
    }

    public function termsOfService()
    {
        return view('pages.terms');
    }

    public function disclaimer()
    {
        $content = \App\Models\SiteSetting::get('disclaimer_content');
        return view('pages.disclaimer', compact('content'));
    }

    public function upcomingSongs()
    {
        $songs = Song::where('lyrics_status', 'coming_soon')
            ->where('is_published', true)
            ->with(['artist', 'album'])
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('upcoming', compact('songs'));
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

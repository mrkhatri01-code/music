<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Album;
use App\Models\Tag;
use App\Models\Lyric;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with(['artist', 'genre', 'movie', 'album']);

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('title_english', 'like', "%{$q}%")
                    ->orWhere('title_nepali', 'like', "%{$q}%");
            });
        }

        $songs = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->all());

        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        $artists = Artist::orderBy('name_english')->get();
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $albums = Album::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.songs.create', compact('artists', 'genres', 'movies', 'albums', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'nullable|exists:genres,id',
            'movie_id' => 'nullable|exists:movies,id',
            'album_id' => 'nullable|exists:albums,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'youtube_url' => 'nullable|url',
            'language' => 'required|in:nepali,hindi,english',
            'is_published' => 'boolean',
            'lyrics_unicode' => 'nullable|string',
            'lyrics_romanized' => 'nullable|string',
            'lyrics_hindi' => 'nullable|string',
            'lyrics_english' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['is_published'] = $request->has('is_published');

        // Create song
        $song = Song::create($validated);

        // Create lyrics based on language
        $language = $request->language ?? 'nepali';

        if ($language === 'nepali') {
            if ($request->filled('lyrics_unicode') || $request->filled('lyrics_romanized')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_unicode,
                    'content_romanized' => $request->lyrics_romanized,
                ]);
            }
        } elseif ($language === 'hindi') {
            if ($request->filled('lyrics_hindi')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_hindi,
                    'content_romanized' => null,
                ]);
            }
        } elseif ($language === 'english') {
            if ($request->filled('lyrics_english')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_english,
                    'content_romanized' => null,
                ]);
            }
        }

        // Attach tags
        if ($request->filled('tags')) {
            $song->tags()->attach($request->tags);
        }

        return redirect()->route('admin.songs.index')
            ->with('success', 'Song created successfully!');
    }

    public function edit(Song $song)
    {
        $song->load('lyric', 'tags');
        $artists = Artist::orderBy('name_english')->get();
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $albums = Album::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.songs.edit', compact('song', 'artists', 'genres', 'movies', 'albums', 'tags'));
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'genre_id' => 'nullable|exists:genres,id',
            'movie_id' => 'nullable|exists:movies,id',
            'album_id' => 'nullable|exists:albums,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'youtube_url' => 'nullable|url',
            'language' => 'required|in:nepali,hindi,english',
            'is_published' => 'boolean',
            'lyrics_unicode' => 'nullable|string',
            'lyrics_romanized' => 'nullable|string',
            'lyrics_hindi' => 'nullable|string',
            'lyrics_english' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $song->update($validated);

        // Update or create lyrics based on language
        $language = $song->language ?? 'nepali';

        if ($language === 'nepali') {
            if ($song->lyric) {
                $song->lyric->update([
                    'content_unicode' => $request->lyrics_unicode,
                    'content_romanized' => $request->lyrics_romanized,
                ]);
            } elseif ($request->filled('lyrics_unicode') || $request->filled('lyrics_romanized')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_unicode,
                    'content_romanized' => $request->lyrics_romanized,
                ]);
            }
        } elseif ($language === 'hindi') {
            if ($song->lyric) {
                $song->lyric->update([
                    'content_unicode' => $request->lyrics_hindi,
                    'content_romanized' => null,
                ]);
            } elseif ($request->filled('lyrics_hindi')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_hindi,
                    'content_romanized' => null,
                ]);
            }
        } elseif ($language === 'english') {
            if ($song->lyric) {
                $song->lyric->update([
                    'content_unicode' => $request->lyrics_english,
                    'content_romanized' => null,
                ]);
            } elseif ($request->filled('lyrics_english')) {
                Lyric::create([
                    'song_id' => $song->id,
                    'content_unicode' => $request->lyrics_english,
                    'content_romanized' => null,
                ]);
            }
        }

        // Sync tags
        if ($request->filled('tags')) {
            $song->tags()->sync($request->tags);
        } else {
            $song->tags()->sync([]);
        }

        return redirect()->route('admin.songs.index')
            ->with('success', 'Song updated successfully!');
    }

    public function destroy(Song $song)
    {
        $song->delete();

        return redirect()->route('admin.songs.index')
            ->with('success', 'Song deleted successfully!');
    }
}

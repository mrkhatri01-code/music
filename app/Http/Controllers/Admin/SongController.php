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

        // Filter for trashed songs
        if ($request->has('trashed') && $request->trashed === 'only') {
            $query->onlyTrashed();
        }

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('title_english', 'like', "%{$q}%")
                    ->orWhere('title_nepali', 'like', "%{$q}%");
            });
        }

        if ($request->has('status')) {
            if ($request->status === 'coming_soon') {
                $query->where('lyrics_status', 'coming_soon');
            } elseif ($request->status === 'available') {
                $query->where('lyrics_status', 'available');
            }
        }

        $songs = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->all());

        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        $artists = Artist::whereIn('type', ['singer', 'both'])->orderBy('name_english')->get();
        $writers = Artist::whereIn('type', ['writer', 'both'])->orderBy('name_english')->get();
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $albums = Album::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.songs.create', compact('artists', 'writers', 'genres', 'movies', 'albums', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'writer_id' => 'nullable|exists:artists,id',
            'genre_id' => 'nullable|exists:genres,id',
            'movie_id' => 'nullable|exists:movies,id',
            'album_id' => 'nullable|exists:albums,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'youtube_url' => 'nullable|url',
            'cover_image' => 'nullable|image|max:2048',
            'lyrics_status' => 'required|in:available,coming_soon',
            'release_date' => 'nullable|date',
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

        // Auto-fill year from release_date if provided
        if (!empty($validated['release_date'])) {
            $validated['year'] = date('Y', strtotime($validated['release_date']));
        }

        //Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $filename = 'song_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/songs/covers'), $filename);
            $validated['cover_image'] = 'images/songs/covers/' . $filename;
        }

        // Auto-fill year from release_date if provided
        if (!empty($validated['release_date'])) {
            $validated['year'] = date('Y', strtotime($validated['release_date']));
        }

        // Convert string 'null' to actual null for nullable foreign keys
        $nullableFields = ['artist_id', 'writer_id', 'genre_id', 'movie_id', 'album_id'];
        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && ($validated[$field] === 'null' || $validated[$field] === '')) {
                $validated[$field] = null;
            }
        }

        // Create song
        $song = Song::create($validated);

        // Create lyrics based on language (only if status is available)
        if ($validated['lyrics_status'] === 'available') {
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
        $artists = Artist::whereIn('type', ['singer', 'both'])->orderBy('name_english')->get();
        $writers = Artist::whereIn('type', ['writer', 'both'])->orderBy('name_english')->get();
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $albums = Album::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.songs.edit', compact('song', 'artists', 'writers', 'genres', 'movies', 'albums', 'tags'));
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',
            'writer_id' => 'nullable|exists:artists,id',
            'genre_id' => 'nullable|exists:genres,id',
            'movie_id' => 'nullable|exists:movies,id',
            'album_id' => 'nullable|exists:albums,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'youtube_url' => 'nullable|url',
            'cover_image' => 'nullable|image|max:2048',
            'lyrics_status' => 'required|in:available,coming_soon',
            'release_date' => 'nullable|date',
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

        // Auto-fill year from release_date if provided
        if (!empty($validated['release_date'])) {
            $validated['year'] = date('Y', strtotime($validated['release_date']));
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover if exists
            if ($song->cover_image && file_exists(public_path($song->cover_image))) {
                unlink(public_path($song->cover_image));
            }

            $coverImage = $request->file('cover_image');
            $filename = 'song_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/songs/covers'), $filename);
            $validated['cover_image'] = 'images/songs/covers/' . $filename;
        }

        // Auto-fill year from release_date if provided
        if (!empty($validated['release_date'])) {
            $validated['year'] = date('Y', strtotime($validated['release_date']));
        }

        // Convert string 'null' to actual null for nullable foreign keys
        $nullableFields = ['artist_id', 'writer_id', 'genre_id', 'movie_id', 'album_id'];
        foreach ($nullableFields as $field) {
            if (isset($validated[$field]) && ($validated[$field] === 'null' || $validated[$field] === '')) {
                $validated[$field] = null;
            }
        }

        // Update song
        $song->update($validated);

        // Update or create lyrics based on language (only if status is available)
        if ($validated['lyrics_status'] === 'available') {
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
        } else {
            // If status changed to coming_soon, delete lyrics if exists
            if ($song->lyric) {
                $song->lyric->delete();
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

    public function restore($id)
    {
        $song = Song::onlyTrashed()->findOrFail($id);
        $song->restore();

        return redirect()->route('admin.songs.index')
            ->with('success', 'Song restored successfully!');
    }

    public function forceDelete($id)
    {
        $song = Song::onlyTrashed()->findOrFail($id);

        // Delete cover image if exists
        if ($song->cover_image && file_exists(public_path($song->cover_image))) {
            unlink(public_path($song->cover_image));
        }

        $song->forceDelete();

        return redirect()->route('admin.songs.index', ['trashed' => 'only'])
            ->with('success', 'Song permanently deleted!');
    }
}

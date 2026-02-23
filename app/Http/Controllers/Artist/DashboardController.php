<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Album;
use App\Models\Tag;
use App\Models\Lyric;
use App\Models\Movie;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function romanize(Request $request)
    {
        $text = $request->input('text');
        if (!$text) {
            return response()->json(['text' => '']);
        }

        try {
            $response = Http::get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => 'ne',
                'tl' => 'en',
                'dt' => 'rm',
                'q' => $text,
            ]);

            $data = $response->json();
            $romanized = '';

            if (isset($data[0])) {
                foreach ($data[0] as $part) {
                    if (isset($part[3])) {
                        $romanized .= $part[3];
                    }
                }
            }

            return response()->json(['text' => $romanized ?: $text]);
        } catch (\Exception $e) {
            return response()->json(['text' => $text]);
        }
    }

    public function index()
    {
        $user = auth()->user();
        if (!$user->artist) {
            // If user has 'artist' role but no Artist profile, redirect to create profile
            // assuming we have a route for that, or show a view to create one.
            // For now, let's return a view that prompts them to create a profile.
            // We can reuse 'admin.artists.create' but that's for admins.
            // Better to show a "Complete Profile" page.
            return redirect()->route('artist.profile.create');
        }

        $artist = $user->artist;
        $songsCount = $artist->songs()->count();
        $viewsCount = $artist->views_count;
        $recentSongs = $artist->songs()->latest()->take(5)->get();

        return view('artist.dashboard', compact('artist', 'songsCount', 'viewsCount', 'recentSongs'));
    }

    public function createProfile()
    {
        $user = auth()->user();
        if ($user->artist) {
            return redirect()->route('artist.dashboard');
        }
        return view('artist.profile-create', compact('user'));
    }

    public function storeProfile(Request $request)
    {
        $user = auth()->user();
        if ($user->artist) {
            return redirect()->route('artist.dashboard');
        }

        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_nepali' => 'required|string|max:255',
            'type' => 'required|in:singer,writer,both',
            'bio' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        $validated['user_id'] = $user->id;

        // Handle images
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('artists/profiles', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('artists/covers', 'public');
        }

        \App\Models\Artist::create($validated);

        return redirect()->route('artist.dashboard')->with('success', 'Profile created successfully! Welcome to your dashboard.');
    }

    public function profile()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('artist.profile.create');
        }
        return view('artist.profile', compact('artist'));
    }

    public function updateProfile(Request $request)
    {
        $artist = auth()->user()->artist;

        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_nepali' => 'required|string|max:255',
            'type' => 'required|in:singer,writer,both',
            'bio' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'social_links' => 'nullable|array',
            'social_links.youtube' => 'nullable|url',
            'social_links.facebook' => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.tiktok' => 'nullable|url',
            'social_links.spotify' => 'nullable|url',
            'social_links.apple_music' => 'nullable|url',
            'social_links.website' => 'nullable|url',
            'social_links.public_email' => 'nullable|email',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($artist->profile_image) {
                Storage::disk('public')->delete($artist->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('artists/profiles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($artist->cover_image) {
                Storage::disk('public')->delete($artist->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('artists/covers', 'public');
        }

        $artist->update($validated);

        return redirect()->route('artist.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function songs()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('home')->with('error', 'Artist profile not found.');
        }

        if ($artist->type === 'writer') {
            $songs = $artist->writtenSongs()->latest()->paginate(20);
        } elseif ($artist->type === 'both') {
            $songs = \App\Models\Song::where(function ($q) use ($artist) {
                $q->where('artist_id', $artist->id)
                    ->orWhere('writer_id', $artist->id);
            })->latest()->paginate(20);
        } else {
            $songs = $artist->songs()->latest()->paginate(20);
        }

        return view('artist.songs.index', compact('songs'));
    }

    public function createSong()
    {
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('home')->with('error', 'Artist profile not found.');
        }
        $albums = $artist->albums;
        $writers = \App\Models\Artist::whereIn('type', ['writer', 'both'])->orderBy('name_english')->get();
        $singers = \App\Models\Artist::whereIn('type', ['singer', 'both'])->orderBy('name_english')->get();
        return view('artist.songs.create', compact('genres', 'albums', 'movies', 'tags', 'writers', 'singers'));
    }

    public function storeSong(Request $request)
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('home')->with('error', 'Artist profile not found.');
        }

        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'writer_id' => 'nullable|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
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

        if ($artist->type === 'singer') {
            $validated['artist_id'] = $artist->id;
        } elseif ($artist->type === 'writer') {
            $validated['writer_id'] = $artist->id;
            // writer can optionally select a singer
            if ($request->filled('artist_id')) {
                $validated['artist_id'] = $request->artist_id;
            } else {
                $validated['artist_id'] = null; // No singer selected yet
            }
        } else {
            // type == 'both'
            $validated['artist_id'] = $request->input('artist_id', $artist->id);
            $validated['writer_id'] = $request->input('writer_id');
        }

        $validated['is_published'] = $request->has('is_published');

        // Auto-fill year from release_date if provided
        if (!empty($validated['release_date'])) {
            $validated['year'] = date('Y', strtotime($validated['release_date']));
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $filename = 'song_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/songs/covers'), $filename);
            $validated['cover_image'] = 'images/songs/covers/' . $filename;
        }

        // Convert string 'null' to actual null for nullable foreign keys
        $nullableFields = ['writer_id', 'genre_id', 'movie_id', 'album_id'];
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

        return redirect()->route('artist.songs.index')->with('success', 'Song created successfully.');
    }

    public function editSong($id)
    {
        $artist = auth()->user()->artist;

        if ($artist->type === 'writer') {
            $song = $artist->writtenSongs()->with('tags', 'lyric')->findOrFail($id);
        } elseif ($artist->type === 'both') {
            $song = \App\Models\Song::where(function ($q) use ($artist) {
                $q->where('artist_id', $artist->id)
                    ->orWhere('writer_id', $artist->id);
            })->with('tags', 'lyric')->findOrFail($id);
        } else {
            $song = $artist->songs()->with('tags', 'lyric')->findOrFail($id);
        }
        $genres = Genre::orderBy('name')->get();
        $movies = Movie::orderBy('name')->get();
        $albums = $artist->albums;
        $tags = Tag::orderBy('name')->get();
        $writers = \App\Models\Artist::whereIn('type', ['writer', 'both'])->orderBy('name_english')->get();
        $singers = \App\Models\Artist::whereIn('type', ['singer', 'both'])->orderBy('name_english')->get();
        return view('artist.songs.edit', compact('song', 'genres', 'albums', 'movies', 'tags', 'writers', 'singers'));
    }

    public function updateSong(Request $request, $id)
    {
        $artist = auth()->user()->artist;

        if ($artist->type === 'writer') {
            $song = $artist->writtenSongs()->findOrFail($id);
        } elseif ($artist->type === 'both') {
            $song = \App\Models\Song::where(function ($q) use ($artist) {
                $q->where('artist_id', $artist->id)
                    ->orWhere('writer_id', $artist->id);
            })->findOrFail($id);
        } else {
            $song = $artist->songs()->findOrFail($id);
        }

        $validated = $request->validate([
            'title_english' => 'required|string|max:255',
            'title_nepali' => 'required|string|max:255',
            'writer_id' => 'nullable|exists:artists,id',
            'genre_id' => 'required|exists:genres,id',
            'movie_id' => 'nullable|exists:movies,id',
            'album_id' => 'nullable|exists:albums,id',
            'is_published' => 'boolean',
            'cover_image' => 'nullable|image|max:2048',
            'lyrics_status' => 'required|in:available,coming_soon',
            'release_date' => 'nullable|date',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'language' => 'required|in:nepali,hindi,english',
            'youtube_url' => 'nullable|url',
            // Lyrics metadata
            'lyrics_unicode' => 'nullable|string',
            'lyrics_romanized' => 'nullable|string',
            'lyrics_hindi' => 'nullable|string',
            'lyrics_english' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($artist->type === 'writer') {
            $validated['writer_id'] = $artist->id;
            if ($request->filled('artist_id')) {
                $validated['artist_id'] = $request->artist_id;
            } else {
                $validated['artist_id'] = null;
            }
        } elseif ($artist->type === 'both') {
            $validated['artist_id'] = $request->input('artist_id', $song->artist_id);
            $validated['writer_id'] = $request->input('writer_id', $song->writer_id);
        } else {
            // singer type, artist_id remains same, writer_id is updatable
            $validated['artist_id'] = $song->artist_id; // prevent changes
            $validated['writer_id'] = $request->input('writer_id');
        }

        $data = [
            'title_english' => $validated['title_english'],
            'title_nepali' => $validated['title_nepali'],
            'artist_id' => $validated['artist_id'],
            'writer_id' => $validated['writer_id'],
            'genre_id' => $validated['genre_id'],
            'movie_id' => $validated['movie_id'],
            'album_id' => $validated['album_id'],
            'is_published' => $validated['is_published'],
            'lyrics_status' => $validated['lyrics_status'],
            'release_date' => $validated['release_date'] ?? null,
            'youtube_url' => $validated['youtube_url'] ?? null,
        ];

        if (!empty($validated['release_date'])) {
            $data['year'] = date('Y', strtotime($validated['release_date']));
        }

        if ($request->hasFile('cover_image')) {
            if ($song->cover_image && file_exists(public_path($song->cover_image))) {
                unlink(public_path($song->cover_image));
            }
            $coverImage = $request->file('cover_image');
            $filename = 'song_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/songs/covers'), $filename);
            $data['cover_image'] = 'images/songs/covers/' . $filename;
        }

        // Convert string 'null' to actual null for nullable foreign keys
        $nullableFields = ['writer_id', 'genre_id', 'movie_id', 'album_id'];
        foreach ($nullableFields as $field) {
            if (isset($data[$field]) && ($data[$field] === 'null' || $data[$field] === '')) {
                $data[$field] = null;
            }
        }

        $song->update($data);

        // Update Lyrics
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
            if ($song->lyric) {
                $song->lyric->delete();
            }
        }

        // Sync Tags
        if ($request->filled('tags')) {
            $song->tags()->sync($request->tags);
        } else {
            $song->tags()->sync([]);
        }

        return redirect()->route('artist.songs.index')->with('success', 'Song updated successfully.');
    }

    public function albums()
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('home')->with('error', 'Artist profile not found.');
        }
        $albums = $artist->albums()->withCount('songs')->latest()->paginate(20);
        return view('artist.albums.index', compact('albums'));
    }

    public function createAlbum()
    {
        return view('artist.albums.create');
    }

    public function storeAlbum(Request $request)
    {
        $artist = auth()->user()->artist;
        if (!$artist) {
            return redirect()->route('home')->with('error', 'Artist profile not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $album = new Album($validated);
        $album->artist_id = $artist->id;

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $filename = 'album_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/albums'), $filename);
            $album->cover_image = 'images/albums/' . $filename;
        }

        $album->slug = \Illuminate\Support\Str::slug($album->name) . '-' . time();
        $album->save();

        return redirect()->route('artist.songs.create')->with('success', 'Album created successfully! You can now add songs to it.');
    }

    public function editAlbum($id)
    {
        $artist = auth()->user()->artist;
        $album = $artist->albums()->findOrFail($id);
        return view('artist.albums.edit', compact('album'));
    }

    public function updateAlbum(Request $request, $id)
    {
        $artist = auth()->user()->artist;
        $album = $artist->albums()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $album->fill($validated);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $coverImage = $request->file('cover_image');
            $filename = 'album_cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $coverImage->move(public_path('images/albums'), $filename);
            $album->cover_image = 'images/albums/' . $filename;
        }

        $album->save();

        return redirect()->route('artist.albums.index')->with('success', 'Album updated successfully.');
    }
}

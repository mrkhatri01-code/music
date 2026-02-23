<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Album::with('artist')->withCount('songs');

        if ($request->has('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%{$q}%");
        }

        $albums = $query->orderBy('created_at', 'desc')->paginate(15)->appends($request->all());
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::orderBy('name_english')->get();
        return view('admin.albums.form', compact('artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $album = new Album($validated);

        if ($request->hasFile('cover_image')) {
            $imageName = time() . '_album.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('images/albums'), $imageName);
            $album->cover_image = 'images/albums/' . $imageName;
        }

        if (empty($album->slug)) {
            $album->slug = Str::slug($album->name) . '-' . time();
        }

        $album->save();

        return redirect()->route('admin.albums.index')->with('success', 'Album created successfully!');
    }

    public function edit(Album $album)
    {
        $artists = Artist::orderBy('name_english')->get();
        return view('admin.albums.form', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $album->fill($validated);

        if ($request->hasFile('cover_image')) {
            // Delete old image if needed (optional)
            $imageName = time() . '_album.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('images/albums'), $imageName);
            $album->cover_image = 'images/albums/' . $imageName;
        }

        $album->save();

        return redirect()->route('admin.albums.index')->with('success', 'Album updated successfully!');
    }

    public function destroy(Album $album)
    {
        $album->delete(); // Songs cascade? Need to check DB schema, but standard soft delete or restrict usually.
        return redirect()->route('admin.albums.index')->with('success', 'Album deleted successfully!');
    }
}

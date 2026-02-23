<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::withCount('songs');

        if ($request->has('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%{$q}%");
        }

        $movies = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->all());

        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $imageName = 'movie_' . time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('images/movies'), $imageName);
            $validated['cover_image'] = 'images/movies/' . $imageName;
        }

        Movie::create($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.edit', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'cover_image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($movie->cover_image && file_exists(public_path($movie->cover_image))) {
                unlink(public_path($movie->cover_image));
            }

            $imageName = 'movie_' . time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('images/movies'), $imageName);
            $validated['cover_image'] = 'images/movies/' . $imageName;
        }

        $movie->update($validated);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        // Delete cover image if exists
        if ($movie->cover_image && file_exists(public_path($movie->cover_image))) {
            unlink(public_path($movie->cover_image));
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully!');
    }
}

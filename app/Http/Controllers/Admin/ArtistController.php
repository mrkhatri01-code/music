<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        $query = Artist::withCount('songs');

        if ($request->has('q')) {
            $q = $request->q;
            $query->where(function ($query) use ($q) {
                $query->where('name_english', 'like', "%{$q}%")
                    ->orWhere('name_nepali', 'like', "%{$q}%");
            });
        }

        $artists = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends($request->all());

        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_nepali' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
            'is_verified' => 'boolean',
            'youtube' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'spotify' => 'nullable|url',
            'apple_music' => 'nullable|url',
            'website' => 'nullable|url',
        ]);

        // Handle image uploads
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('artists/profiles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('artists/covers', 'public');
        }

        // Prepare social links
        $socialLinks = [];
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->$platform;
            }
        }
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Remove individual social fields
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website'] as $platform) {
            unset($validated[$platform]);
        }

        $validated['is_verified'] = $request->has('is_verified');

        Artist::create($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist created successfully!');
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name_english' => 'required|string|max:255',
            'name_nepali' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
            'is_verified' => 'boolean',
            'youtube' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'spotify' => 'nullable|url',
            'apple_music' => 'nullable|url',
            'website' => 'nullable|url',
        ]);

        // Handle image uploads
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($artist->profile_image) {
                Storage::disk('public')->delete($artist->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('artists/profiles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($artist->cover_image) {
                Storage::disk('public')->delete($artist->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('artists/covers', 'public');
        }

        // Prepare social links
        $socialLinks = [];
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->$platform;
            }
        }
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Remove individual social fields
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website'] as $platform) {
            unset($validated[$platform]);
        }

        $validated['is_verified'] = $request->has('is_verified');

        $artist->update($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist updated successfully!');
    }

    public function destroy(Artist $artist)
    {
        // Delete images
        if ($artist->profile_image) {
            Storage::disk('public')->delete($artist->profile_image);
        }
        if ($artist->cover_image) {
            Storage::disk('public')->delete($artist->cover_image);
        }

        $artist->delete();

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist deleted successfully!');
    }
}

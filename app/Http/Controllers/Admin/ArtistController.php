<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'type' => 'required|in:singer,writer,both',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|min:6', // Optional, only if creating a user
            'bio' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
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
            'public_email' => 'nullable|email',
        ]);

        // Create User if email/password provided
        $userId = null;
        if ($request->filled('email') && $request->filled('password')) {
            $user = User::create([
                'name' => $validated['name_english'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'artist',
            ]);
            $userId = $user->id;
        }

        // Remove email/password from validated data before creating Artist
        unset($validated['email'], $validated['password']);

        // Add user_id if created
        if ($userId) {
            $validated['user_id'] = $userId;
        }

        // Handle image uploads
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('artists/profiles', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('artists/covers', 'public');
        }

        // Prepare social links
        $socialLinks = [];
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website', 'public_email'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->$platform;
            }
        }
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Remove individual social fields
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website', 'public_email'] as $platform) {
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
            'type' => 'required|in:singer,writer,both',
            'bio' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
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
            'public_email' => 'nullable|email',
            'email' => 'nullable|email|unique:users,email,' . ($artist->user_id ? $artist->user_id : 'NULL'),
            'password' => 'nullable|min:6',
        ]);

        // Update User Account (Email/Password)
        if ($artist->user) {
            $userUpdates = [];

            if ($request->filled('email') && $request->email !== $artist->user->email) {
                $userUpdates['email'] = $request->email;
            }

            if ($request->filled('password')) {
                $userUpdates['password'] = Hash::make($request->password);
            }

            if (!empty($userUpdates)) {
                $artist->user->update($userUpdates);
            }
        } elseif ($request->filled('email') && $request->filled('password')) {
            // Create new User for existing Artist
            $user = User::create([
                'name' => $validated['name_english'],
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'artist',
            ]);

            // Link User to Artist
            $artist->user_id = $user->id;
            // No need to save here as $artist->update($validated) is called below, 
            // but $validated doesn't contain user_id. We need to merge it or save explicitly.
            // Let's create the user, get the ID, and add it to validated or save separately.
            // Since $artist->update($validated) is called later, let's inject user_id into validated 
            // OR just save the artist association here.

            // Actually, simply setting the attribute on the model instance works if we save it. 
            // But $artist->update($validated) might overwrite or ignore it if not in $validated.
            // Safest way: Add to $validated.
            $validated['user_id'] = $user->id;
        }

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
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website', 'public_email'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->$platform;
            }
        }
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Remove individual social fields
        foreach (['youtube', 'facebook', 'instagram', 'tiktok', 'spotify', 'apple_music', 'website', 'public_email'] as $platform) {
            unset($validated[$platform]);
        }

        $validated['is_verified'] = $request->has('is_verified');

        $artist->update($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artist updated successfully!');
    }

    public function updateAccount(Request $request, Artist $artist)
    {
        $request->validate([
            'email' => 'nullable|email|unique:users,email,' . ($artist->user_id ? $artist->user_id : 'NULL'),
            'password' => 'nullable|min:6',
        ]);

        if (!$artist->user) {
            return back()->with('error', 'This artist does not have an associated user account.');
        }

        // Safeguard: Prevent modifying users with admin role (legacy admins)
        if ($artist->user->role === 'admin') {
            return back()->with('error', 'Cannot modify account credentials for an Admin user via Artist management.');
        }

        $userUpdates = [];

        if ($request->filled('email') && $request->email !== $artist->user->email) {
            $userUpdates['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $userUpdates['password'] = Hash::make($request->password);
        }

        if (!empty($userUpdates)) {
            $artist->user->update($userUpdates);
            return back()->with('success', 'Artist account credentials updated successfully.');
        }

        return back()->with('info', 'No changes were made.');
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

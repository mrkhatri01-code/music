<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ArtistRegistrationRequest;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ArtistRequestController extends Controller
{
    public function index()
    {
        $requests = ArtistRegistrationRequest::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.artist-requests.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = ArtistRegistrationRequest::findOrFail($id);

        // 1. Handle User
        $user = $request->user;
        if (!$user) {
            // Check if user exists by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Create new user
                $password = Str::random(10); // Should email this to them in real app
                $user = User::create([
                    'name' => $request->full_name,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'role' => 'artist',
                ]);
                // TODO: Send email with password
            } else {
                // Update existing user role, but don't downgrade admin
                if ($user->role !== 'admin') {
                    $user->role = 'artist';
                    $user->save();
                }
            }

            // Link user to request
            $request->user_id = $user->id;
        } else {
            // Update linked user role
            $user->role = 'artist';
            $user->save();
        }

        // 2. Create Artist Profile
        // Check if artist already exists for this user
        if (!$user->artist) {
            Artist::create([
                'user_id' => $user->id,
                'name_english' => $request->stage_name,
                'name_nepali' => $request->stage_name, // Default to same, editable later
                'bio' => $request->bio,
                'type' => $request->artist_type ?? 'singer',
                'is_verified' => true,
                'social_links' => $request->social_links,
            ]);
        }

        // 3. Update Request Status
        $request->status = 'approved';
        $request->save();

        $successMessage = 'Artist request approved and profile created.';
        if (isset($password)) {
            $successMessage .= " **Temporary Password for new user: $password** (Please copy and send this to the artist)";
        }

        return redirect()->route('admin.artist-requests.index')->with('success', $successMessage);
    }

    public function reject($id)
    {
        $request = ArtistRegistrationRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->route('admin.artist-requests.index')->with('success', 'Artist request rejected.');
    }
}

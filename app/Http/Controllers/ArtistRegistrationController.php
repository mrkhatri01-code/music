<?php

namespace App\Http\Controllers;

use App\Models\ArtistRegistrationRequest;
use Illuminate\Http\Request;

class ArtistRegistrationController extends Controller
{
    public function showForm()
    {
        return view('auth.artist-register');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'stage_name' => 'required|string|max:255',
            'artist_type' => 'required|in:singer,writer,both',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'social_links' => 'nullable|array',
            'sample_work_url' => 'nullable|url',
        ]);

        $validated['user_id'] = auth()->id(); // Link to existing user if logged in

        ArtistRegistrationRequest::create($validated);

        return redirect()->route('artist.login')->with('success', 'Your artist registration request has been submitted successfully. We will review it shortly.');
    }
}

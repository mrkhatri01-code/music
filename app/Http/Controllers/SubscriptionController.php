<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'song_id' => 'required|exists:songs,id',
        ]);

        // Check if already subscribed
        $existing = \App\Models\SongSubscription::where('email', $validated['email'])
            ->where('song_id', $validated['song_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => 'You are already subscribed to this song!'
            ]);
        }

        \App\Models\SongSubscription::create([
            'email' => $validated['email'],
            'song_id' => $validated['song_id'],
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You have been subscribed successfully! We will notify you when lyrics are available.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = \App\Models\SongSubscription::with('song.artist')->latest()->paginate(20);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function toggleStatus(\App\Models\SongSubscription $subscription)
    {
        $subscription->update([
            'status' => $subscription->status === 'pending' ? 'notified' : 'pending'
        ]);

        return back()->with('success', 'Subscription status updated successfully.');
    }
}

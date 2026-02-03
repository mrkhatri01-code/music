<?php

namespace App\Observers;

use App\Models\Song;

class SongObserver
{
    /**
     * Handle the Song "created" event.
     */
    public function created(Song $song): void
    {
        //
    }

    public function updated(Song $song): void
    {
        // Check if lyrics_status changed to 'available'
        if ($song->isDirty('lyrics_status') && $song->lyrics_status === 'available') {
            // Get all pending subscriptions for this song
            $subscriptions = \App\Models\SongSubscription::where('song_id', $song->id)
                ->where('status', 'pending')
                ->get();

            foreach ($subscriptions as $subscription) {
                // Notify user
                try {
                    \Illuminate\Support\Facades\Notification::route('mail', $subscription->email)
                        ->notify(new \App\Notifications\LyricsReleased($song));

                    // Update subscription status
                    $subscription->update(['status' => 'notified']);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send lyrics notification: ' . $e->getMessage());
                }
            }
        }
    }

    /**
     * Handle the Song "deleted" event.
     */
    public function deleted(Song $song): void
    {
        //
    }

    /**
     * Handle the Song "restored" event.
     */
    public function restored(Song $song): void
    {
        //
    }

    /**
     * Handle the Song "force deleted" event.
     */
    public function forceDeleted(Song $song): void
    {
        //
    }
}

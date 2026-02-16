@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #2d3748;">About Nepali Lyrics</h1>

        <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
            Welcome to Nepali Lyrics, your ultimate destination for Nepali songs lyrics. We provide accurate lyrics in both
            Unicode Nepali and Romanized formats, making it easy for everyone to enjoy and understand their favorite Nepali
            songs.
        </p>

        <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
            Our mission is to preserve and promote Nepali music by providing a comprehensive database of song lyrics, artist
            information, and music resources.
        </p>

        <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">What We Offer</h2>
        <ul style="line-height: 1.8; color: #4a5568; margin-left: 2rem;">
            <li>Complete Nepali song lyrics in Unicode format</li>
            <li>Romanized lyrics for easy reading</li>
            <li>Trending and new song updates</li>
            <li>Artist profiles and discographies</li>
            <li>Genre-based song collections</li>
            <li>Festival special playlists</li>
        </ul>

        <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Contact Us</h2>
        <p style="line-height: 1.8; color: #4a5568;">
            For any inquiries, suggestions, or feedback, please visit our <a href="{{ route('contact') }}"
                style="color: #667eea;">contact page</a>.
        </p>
    </div>
@endsection
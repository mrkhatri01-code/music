@extends('layouts.app')

@section('title', 'Contact Us - Nepali Lyrics')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #2d3748;">Contact Us</h1>

        <p style="line-height: 1.8; margin-bottom: 2rem; color: #4a5568;">
            Have questions, suggestions, or want to report an issue? We'd love to hear from you!
        </p>

        <div style="background: #f7fafc; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; color: #2d3748;">Email</h3>
            <p style="color: #667eea; font-size: 1.1rem;">contact@nepallyrics.com</p>
        </div>

        <div style="background: #f7fafc; padding: 2rem; border-radius: 8px;">
            <h3 style="margin-bottom: 1rem; color: #2d3748;">Report Issues</h3>
            <p style="color: #4a5568; line-height: 1.6;">
                Found wrong lyrics or copyright issues? You can report directly on the song page using the "Report Issue"
                button.
            </p>
        </div>
    </div>
@endsection
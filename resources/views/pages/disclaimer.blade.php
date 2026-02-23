@extends('layouts.app')

@section('title', 'Disclaimer')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        @if(!empty($content))
            {!! $content !!}
        @else
            <!-- Static Fallback Content -->
            <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #2d3748;">Disclaimer</h1>

            <p style="line-height: 1.8; margin-bottom: 2rem; color: #4a5568;">
                The information contained on Nepali Lyrics website is for general information purposes only.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Content Accuracy</h2>
            <p style="line-height: 1.8; margin-bottom: 2rem; color: #4a5568;">
                While we strive to provide accurate lyrics, we make no representations or warranties of any kind about the
                completeness, accuracy, or availability of the content. Any reliance you place on such information is strictly
                at your own risk.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Copyright</h2>
            <p style="line-height: 1.8; margin-bottom: 2rem; color: #4a5568;">
                All song lyrics, artist names, and related content are the property of their respective copyright holders. We do
                not claim ownership of any lyrics displayed on this website. Lyrics are provided for educational and personal
                use only.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">External Links</h2>
            <p style="line-height: 1.8; color: #4a5568;">
                Our website may contain links to external websites. We have no control over the nature, content, and
                availability of those sites and are not responsible for their content.
            </p>
        @endif
    </div>
@endsection
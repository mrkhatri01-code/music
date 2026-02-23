@extends('layouts.app')

@section('title', 'DMCA Policy')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        @if(!empty($content))
            {!! $content !!}
        @else
            <!-- Static Fallback Content -->
            <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #2d3748;">DMCA Policy</h1>

            <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
                Nepali Lyrics respects the intellectual property rights of others. If you believe that your copyrighted work has
                been copied in a way that constitutes copyright infringement, please contact us immediately.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Copyright Infringement Notice
            </h2>

            <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
                To file a DMCA notice, please provide the following information:
            </p>

            <ul style="line-height: 1.8; color: #4a5568; margin-left: 2rem; margin-bottom: 2rem;">
                <li>Identification of the copyrighted work claimed to have been infringed</li>
                <li>Identification of the material that is claimed to be infringing</li>
                <li>Your contact information (address, telephone number, email)</li>
                <li>A statement that you have a good faith belief that use of the material is not authorized</li>
                <li>A statement of accuracy made under penalty of perjury</li>
                <li>Your physical or electronic signature</li>
            </ul>

            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #2d3748;">Contact for DMCA Claims</h3>
            <p style="line-height: 1.8; color: #4a5568;">
                Email: dmca@nepallyrics.com
            </p>

            <p style="line-height: 1.8; margin-top: 2rem; color: #4a5568;">
                We will respond to all valid DMCA notices within 48 hours.
            </p>
        @endif
    </div>
@endsection
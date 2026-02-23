@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
    <div
        style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        @if(!empty($content))
            {!! $content !!}
        @else
            <!-- Static Fallback Content -->
            <h1 style="font-size: 2.5rem; margin-bottom: 1.5rem; color: #2d3748;">Privacy Policy</h1>

            <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
                Last updated: {{ date('F d, Y') }}
            </p>

            <p style="line-height: 1.8; margin-bottom: 2rem; color: #4a5568;">
                Nepali Lyrics ("we", "our", or "us") is committed to protecting your privacy. This Privacy Policy explains how
                we collect, use, and safeguard your information.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Information We Collect</h2>
            <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
                We collect information that you provide directly to us, including:
            </p>
            <ul style="line-height: 1.8; color: #4a5568; margin-left: 2rem; margin-bottom: 2rem;">
                <li>Usage data (pages visited, time spent, etc.)</li>
                <li>Device information (browser type, IP address)</li>
                <li>Information you provide when reporting issues</li>
            </ul>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">How We Use Your Information
            </h2>
            <ul style="line-height: 1.8; color: #4a5568; margin-left: 2rem; margin-bottom: 2rem;">
                <li>To provide and improve our services</li>
                <li>To understand how users interact with our website</li>
                <li>To display relevant advertisements</li>
                <li>To respond to your requests and communications</li>
            </ul>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Third-Party Services</h2>
            <p style="line-height: 1.8; margin-bottom: 1rem; color: #4a5568;">
                We use Google AdSense to display advertisements. Google may use cookies to serve ads based on your prior visits
                to our website.
            </p>

            <h2 style="font-size: 1.8rem; margin-top: 2rem; margin-bottom: 1rem; color: #2d3748;">Contact Us</h2>
            <p style="line-height: 1.8; color: #4a5568;">
                If you have questions about this Privacy Policy, please contact us at privacy@nepallyrics.com
            </p>
        @endif
    </div>
@endsection
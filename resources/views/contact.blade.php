@extends('layouts.app')

@section('title', 'Contact Us - ' . config('app.name'))

@section('content')
    <div class="container"
        style="max-width: 800px; padding: var(--space-8) var(--container-padding); min-height: calc(100vh - 400px);">
        {{-- Header --}}
        <div style="text-align: center; margin-bottom: var(--space-8);">
            <h1
                style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Get In Touch
            </h1>
            <p style="color: var(--color-text-secondary); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                Have a question, suggestion, or feedback? We'd love to hear from you!
            </p>
        </div>

        {{-- Contact Form Card --}}
        <div
            style="background: white; border-radius: var(--radius-xl); padding: var(--space-8); box-shadow: var(--shadow-lg);">
            <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                @csrf

                {{-- Name --}}
                <div style="margin-bottom: 1.5rem;">
                    <label for="name"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--color-text-primary);">
                        <i class="fa-solid fa-user" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Your Name *
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: var(--radius-md); font-size: 1rem; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('name')
                        <span
                            style="color: var(--color-error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div style="margin-bottom: 1.5rem;">
                    <label for="email"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--color-text-primary);">
                        <i class="fa-solid fa-envelope" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Email Address *
                    </label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        placeholder="your.email@example.com"
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: var(--radius-md); font-size: 1rem; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('email')
                        <span
                            style="color: var(--color-error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Subject --}}
                <div style="margin-bottom: 1.5rem;">
                    <label for="subject"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--color-text-primary);">
                        <i class="fa-solid fa-tag" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Subject *
                    </label>
                    <input type="text" name="subject" id="subject" required value="{{ old('subject') }}"
                        placeholder="What's this about?"
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: var(--radius-md); font-size: 1rem; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">
                    @error('subject')
                        <span
                            style="color: var(--color-error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Message --}}
                <div style="margin-bottom: 2rem;">
                    <label for="message"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--color-text-primary);">
                        <i class="fa-solid fa-message" style="color: #667eea; margin-right: 0.5rem;"></i>
                        Your Message *
                    </label>
                    <textarea name="message" id="message" required rows="6" placeholder="Tell us more..."
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: var(--radius-md); font-size: 1rem; resize: vertical; transition: all 0.2s; font-family: inherit;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'">{{ old('message') }}</textarea>
                    @error('message')
                        <span
                            style="color: var(--color-error); font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="submitBtn"
                    style="width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: var(--radius-md); font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(102, 126, 234, 0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(102, 126, 234, 0.3)'">
                    <i class="fa-solid fa-paper-plane" style="margin-right: 0.5rem;"></i>
                    Send Message
                </button>
            </form>
        </div>

        {{-- Info Cards --}}
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: var(--space-8);">
            @php
                $contactEmail = \App\Models\SiteSetting::get('contact_email', '');
            @endphp

            @if($contactEmail)
                <div
                    style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); padding: 1.5rem; border-radius: var(--radius-lg); text-align: center;">
                    <i class="fa-solid fa-envelope" style="font-size: 2rem; color: #667eea; margin-bottom: 0.75rem;"></i>
                    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Email Us</h3>
                    <a href="mailto:{{ $contactEmail }}"
                        style="color: var(--color-text-secondary); text-decoration: none; font-size: 0.9rem;">
                        {{ $contactEmail }}
                    </a>
                </div>
            @endif

            <div
                style="background: linear-gradient(135deg, #fa709a15 0%, #fee14015 100%); padding: 1.5rem; border-radius: var(--radius-lg); text-align: center;">
                <i class="fa-solid fa-clock" style="font-size: 2rem; color: #fa709a; margin-bottom: 0.75rem;"></i>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem;">Response Time</h3>
                <p style="color: var(--color-text-secondary); font-size: 0.9rem; margin: 0;">Within 24-48 hours</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Show toast notification on successful submission
            @if(session('success'))
                // The layout already handles success toasts via SweetAlert
            @endif

            // Form submission feedback
            document.getElementById('contactForm').addEventListener('submit', function (e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right: 0.5rem;"></i>Sending...';
                submitBtn.disabled = true;
            });
        </script>
    @endpush
@endsection
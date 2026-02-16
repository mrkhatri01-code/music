@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <div class="contact-wrapper">
        <div class="contact-card">
            {{-- Left Side: Contact Info --}}
            <div class="contact-info">
                <div class="info-content">
                    <div class="info-header">
                        <h2>Get in Touch</h2>
                        <p>Have questions or feedback? We'd love to hear from you.</p>
                    </div>

                    <div class="info-items">
                        @php
                            $contactEmail = \App\Models\SiteSetting::get('contact_email', 'hello@example.com');
                        @endphp
                        
                        @if($contactEmail)
                            <div class="info-item">
                                <i class="fa-solid fa-envelope"></i>
                                <div>
                                    <h4>Email Us</h4>
                                    <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                </div>
                            </div>
                        @endif

                        <div class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <h4>Response Time</h4>
                                <p>We usually reply within 24-48 hours.</p>
                            </div>
                        </div>

                        {{-- Social Links Section --}}
                        @php
                            $facebookUrl = \App\Models\SiteSetting::get('facebook_url', '');
                            $youtubeUrl = \App\Models\SiteSetting::get('youtube_url', '');
                            $instagramUrl = \App\Models\SiteSetting::get('instagram_url', '');
                            $tiktokUrl = \App\Models\SiteSetting::get('tiktok_url', '');
                        @endphp
                        
                        @if($facebookUrl || $youtubeUrl || $instagramUrl || $tiktokUrl)
                            <div class="info-item" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem; margin-top: 1.5rem;">
                                <div>
                                    <h4>Follow Us</h4>
                                    <p style="margin-bottom: 1rem;">Stay updated on our social channels.</p>
                                    <div style="display: flex; gap: 1rem; margin-top: 0.75rem;">
                                        @if($facebookUrl)
                                            <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                                                style="color: white; font-size: 1.5rem; transition: all 0.2s; opacity: 0.8; text-decoration: none;"
                                                onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'" 
                                                onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'"
                                                title="Facebook">
                                                <i class="fa-brands fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if($youtubeUrl)
                                            <a href="{{ $youtubeUrl }}" target="_blank" rel="noopener noreferrer"
                                                style="color: white; font-size: 1.5rem; transition: all 0.2s; opacity: 0.8; text-decoration: none;"
                                                onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'" 
                                                onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'"
                                                title="YouTube">
                                                <i class="fa-brands fa-youtube"></i>
                                            </a>
                                        @endif
                                        @if($instagramUrl)
                                            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                                                style="color: white; font-size: 1.5rem; transition: all 0.2s; opacity: 0.8; text-decoration: none;"
                                                onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'" 
                                                onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'"
                                                title="Instagram">
                                                <i class="fa-brands fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if($tiktokUrl)
                                            <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer"
                                                style="color: white; font-size: 1.5rem; transition: all 0.2s; opacity: 0.8; text-decoration: none;"
                                                onmouseover="this.style.opacity='1'; this.style.transform='scale(1.1)'" 
                                                onmouseout="this.style.opacity='0.8'; this.style.transform='scale(1)'"
                                                title="TikTok">
                                                <i class="fa-brands fa-tiktok"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="info-footer">
                        <div class="decorative-circles">
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Contact Form --}}
            <div class="contact-form-container">
                <div class="form-header">
                    <h1>Send us a Message</h1>
                    <p>Fill out the form below and we'll get back to you.</p>
                </div>

                <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                    @csrf

                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="name" id="name" required 
                                value="{{ old('name') }}" placeholder="John Doe">
                        </div>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" id="email" required 
                                value="{{ old('email') }}" placeholder="john@example.com">
                        </div>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-tag"></i>
                            <input type="text" name="subject" id="subject" required 
                                value="{{ old('subject') }}" placeholder="How can we help?">
                        </div>
                        @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <div class="input-wrapper textarea-wrapper">
                            <textarea name="message" id="message" required rows="5" 
                                placeholder="Write your message here...">{{ old('message') }}</textarea>
                        </div>
                        @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" id="submitBtn" class="btn-submit">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .contact-wrapper {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .contact-card {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        /* Left Side: Info */
        .contact-info {
            flex: 0 0 40%;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-hover));
            color: white;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .contact-info::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .contact-info::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: -50px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .info-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .info-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .info-header p {
            opacity: 0.9;
            font-size: 1.05rem;
            margin-bottom: 3rem;
        }

        .info-items {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-item i {
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .info-item h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .info-item p, .info-item a {
            font-size: 0.95rem;
            opacity: 0.9;
            color: white;
            text-decoration: none;
        }

        .info-item a:hover {
            text-decoration: underline;
        }

        /* Right Side: Form */
        .contact-form-container {
            flex: 1;
            padding: 3rem;
            background: white;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--color-text-primary);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--color-text-secondary);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.2s;
        }

        .input-wrapper.textarea-wrapper i {
            top: 1.5rem;
        }

        .input-wrapper input,
        .input-wrapper textarea {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #f8fafc;
            font-family: inherit;
        }

        .input-wrapper textarea {
            padding-left: 1rem; /* No icon for textarea usually, but if needed */
            resize: vertical;
        }
        
        /* Adjust padding if no icon in textarea */
        .textarea-wrapper textarea {
             padding-left: 1rem;
        }

        .input-wrapper input:focus,
        .input-wrapper textarea:focus {
            outline: none;
            border-color: var(--color-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .input-wrapper input:focus + i {
            color: var(--color-primary);
        }

        .text-danger {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.35rem;
            display: block;
        }

        .btn-submit {
            width: 100%;
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.1), 0 2px 4px -1px rgba(37, 99, 235, 0.06);
        }

        .btn-submit:hover {
            background: var(--color-primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .contact-card {
                flex-direction: column;
            }

            .contact-info {
                flex: none;
                padding: 2rem;
            }

            .contact-form-container {
                padding: 2rem;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.getElementById('contactForm').addEventListener('submit', function() {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
            });
        </script>
    @endpush
@endsection
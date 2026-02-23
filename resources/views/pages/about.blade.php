@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <style>
        /* Hero Section */
        .about-hero {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            padding: 5rem 0;
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
        }

        .about-hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), #a855f7);
        }

        .about-hero h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .about-hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Content Section */
        .about-section {
            max-width: 900px;
            margin: 0 auto 5rem;
            padding: 0 1.5rem;
        }

        .about-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .about-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--color-primary), #a855f7);
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #4a5568;
        }

        .about-text p {
            margin-bottom: 1.5rem;
        }

        /* Team Section */
        .team-container {
            background: #f8fafc;
            padding: 5rem 0;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .section-title span {
            display: block;
            width: 60px;
            height: 4px;
            background: var(--color-primary);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        /* Contact CTA */
        .contact-cta {
            text-align: center;
            padding: 6rem 1.5rem;
            background: white;
            position: relative;
        }

        .contact-cta h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 1rem;
        }

        .contact-cta p {
            color: #718096;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #1a202c;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background: black;
            color: white;
        }

        /* 
                       PRESERVED TEAM SLIDER CSS 
                       Strictly kept intact as requested 
                    */
        .team-slider-container {
            width: 100%;
            overflow: hidden;
            padding: 2rem 0;
        }

        .team-slider-track {
            display: flex;
            gap: 2rem;
            width: max-content;
            animation: slider-scroll 40s linear infinite;
        }

        .team-slider-container:hover .team-slider-track {
            animation-play-state: paused;
        }

        @keyframes slider-scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .team-card {
            background-color: transparent;
            border-radius: 12px;
            perspective: 1000px;
            aspect-ratio: 9 / 16;
            width: 250px;
            flex-shrink: 0;
        }

        .team-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .team-card:hover .team-card-inner {
            transform: rotateY(180deg);
        }

        .team-card-front,
        .team-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 12px;
            overflow: hidden;
        }

        /* Front Styling */
        .team-card-front {
            background-color: #e2e8f0;
        }

        .team-card-front img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: #cbd5e0;
            background: #f7fafc;
        }

        .team-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 2rem 1rem 1rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, transparent 100%);
            text-align: left;
        }

        /* Back Styling */
        .team-card-back {
            background: #2d3748;
            color: white;
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .team-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin: 0;
            line-height: 1.2;
        }

        .team-role {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
        }

        .team-socials {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .social-icon {
            color: white;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.1);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-icon:hover {
            background: white;
            color: #2d3748;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 2rem;
            }

            .about-card {
                padding: 1.5rem;
            }

            .team-card {
                width: 175px;
            }

            .team-name {
                font-size: 0.95rem;
            }

            .team-role {
                font-size: 0.65rem;
            }

            .social-icon {
                width: 30px;
                height: 30px;
                font-size: 0.85rem;
            }

            .team-placeholder {
                font-size: 2.5rem;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="about-hero">
        <div class="container">
            <h1>About {{ $siteName }}</h1>
            <p>Bringing authentic Nepali lyrics to the world, one song at a time.</p>
        </div>
    </div>

    <!-- About Content -->
    <div class="about-section">
        <div class="about-card">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Our Story</h2>
            @if($aboutContent)
                <div class="about-text">
                    {!! $aboutContent !!}
                </div>
            @else
                <div class="about-text">
                    <p>Welcome to our platform, the premier destination for Nepali lyrics. Our mission is to preserve and
                        promote Nepali music by providing accurate lyrics in both Unicode and Romanized formats.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Team Section -->
    @if(isset($teamMembers) && $teamMembers->count() > 0)
        <div class="team-container">
            <div class="container">
                <div class="section-title">
                    <h2>Meet Our Team</h2>
                    <span></span>
                </div>
            </div>

            <div class="team-slider-container">
                <div class="team-slider-track">
                    <!-- First Loop -->
                    @foreach($teamMembers as $member)
                        <div class="team-card">
                            <div class="team-card-inner">
                                <!-- Front Side -->
                                <div class="team-card-front">
                                    @if($member->image)
                                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                                    @else
                                        <div class="team-placeholder">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="team-overlay">
                                        <h3 class="team-name">{{ $member->name }}</h3>
                                        <div class="team-role">{{ $member->position }}</div>
                                    </div>
                                </div>

                                <!-- Back Side -->
                                <div class="team-card-back">
                                    <h3 class="team-name" style="margin-bottom: 0.5rem; font-size: 1.1rem;">{{ $member->name }}</h3>
                                    <div class="team-role"
                                        style="text-shadow: none; color: rgba(255,255,255,0.7); margin-bottom: 1.5rem; font-size: 0.8rem;">
                                        {{ $member->position }}
                                    </div>

                                    <div class="team-socials">
                                        @if(!empty($member->social_links))
                                            @foreach($member->social_links as $platform => $link)
                                                @if($link)
                                                    <a href="{{ $link }}" target="_blank" class="social-icon" aria-label="{{ $platform }}">
                                                        @if($platform == 'website')
                                                            <i class="fa-solid fa-globe"></i>
                                                        @else
                                                            <i class="fa-brands fa-{{ $platform }}"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Duplicate Loop for Infinite Scroll -->
                    @foreach($teamMembers as $member)
                        <div class="team-card">
                            <div class="team-card-inner">
                                <!-- Front Side -->
                                <div class="team-card-front">
                                    @if($member->image)
                                        <img src="{{ asset($member->image) }}" alt="{{ $member->name }}">
                                    @else
                                        <div class="team-placeholder">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                    <div class="team-overlay">
                                        <h3 class="team-name">{{ $member->name }}</h3>
                                        <div class="team-role">{{ $member->position }}</div>
                                    </div>
                                </div>

                                <!-- Back Side -->
                                <div class="team-card-back">
                                    <h3 class="team-name" style="margin-bottom: 0.5rem; font-size: 1.1rem;">{{ $member->name }}</h3>
                                    <div class="team-role"
                                        style="text-shadow: none; color: rgba(255,255,255,0.7); margin-bottom: 1.5rem; font-size: 0.8rem;">
                                        {{ $member->position }}
                                    </div>

                                    <div class="team-socials">
                                        @if(!empty($member->social_links))
                                            @foreach($member->social_links as $platform => $link)
                                                @if($link)
                                                    <a href="{{ $link }}" target="_blank" class="social-icon" aria-label="{{ $platform }}">
                                                        @if($platform == 'website')
                                                            <i class="fa-solid fa-globe"></i>
                                                        @else
                                                            <i class="fa-brands fa-{{ $platform }}"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Contact CTA -->
    <div class="contact-cta">
        <h2>Have Questions?</h2>
        <p>We'd love to hear from you. Reach out to us for feedback, suggestions, or just to say hello.</p>
        <a href="{{ route('contact') }}" class="btn-cta">
            <span>Contact Us</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

@endsection
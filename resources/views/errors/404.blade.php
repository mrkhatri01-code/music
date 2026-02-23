@extends('layouts.app')

@section('title', 'Page Not Found - 404')
@section('description', 'The page you are looking for could not be found.')

@section('content')
    <div class="container"
        style="padding: 4rem 1rem; text-align: center; min-height: 60vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">

        {{-- Animated Icon or Graphic --}}
        <div style="font-size: 8rem; margin-bottom: 1rem; position: relative; display: inline-block;">
            <i class="fa-solid fa-compact-disc fa-spin"
                style="--fa-animation-duration: 10s; color: var(--color-primary); opacity: 0.1; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(1.5); z-index: 0;"></i>
            <span
                style="position: relative; z-index: 1; font-weight: 800; background: var(--gradient-hero); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 10rem; line-height: 1;">404</span>
        </div>

        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--color-text-primary);">
            Lost the Rhythm?
        </h1>

        <p
            style="font-size: 1.1rem; color: var(--color-text-secondary); max-width: 500px; margin-bottom: 2.5rem; line-height: 1.6;">
            It looks like the track you're looking for has been skipped, moved, or never existed. Let's get you back to the
            music.
        </p>

        {{-- Search Form --}}
        <div style="width: 100%; max-width: 500px; margin-bottom: 2.5rem;">
            <form action="{{ route('search') }}" method="GET" style="position: relative;">
                <input type="text" name="q" placeholder="Search for songs, artists, or lyrics..." required
                    style="width: 100%; padding: 1rem 1.5rem; padding-right: 3.5rem; border-radius: 50px; border: 2px solid var(--color-border); outline: none; transition: all 0.3s; font-size: 1rem; background: var(--color-surface); box-shadow: var(--shadow-sm);">
                <button type="submit"
                    style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: var(--color-primary); color: white; border: none; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; transition: background 0.3s; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Action Buttons --}}
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
            <a href="{{ route('home') }}" class="btn action-btn-primary">
                <i class="fa-solid fa-house" style="margin-right: 0.5rem;"></i> Go Home
            </a>
            <a href="{{ route('trending') }}" class="btn action-btn-secondary">
                <i class="fa-solid fa-fire" style="margin-right: 0.5rem; color: var(--color-warning);"></i> Trending
            </a>
        </div>

    </div>

    <style>
        input:focus {
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
        }

        .action-btn-primary {
            background: var(--color-primary);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: var(--shadow-md);
            transition: transform 0.2s;
        }

        .action-btn-secondary {
            background: white;
            color: var(--color-text-primary);
            border: 1px solid var(--color-border);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg) !important;
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .container span {
                font-size: 6rem !important;
            }

            .container div:first-child {
                font-size: 5rem !important;
            }

            h1 {
                font-size: 1.75rem !important;
            }
        }
    </style>
@endsection
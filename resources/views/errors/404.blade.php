@extends('layouts.app')

@section('title', 'Page Not Found - 404')
@section('description', 'The page you are looking for could not be found.')

@section('content')
    <div style="text-align: center; padding: 4rem 2rem;">
        <div
            style="font-size: 8rem; font-weight: 700; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">
            404
        </div>

        <h1 style="font-size: 2rem; color: #2d3748; margin-top: 1rem; margin-bottom: 0.5rem;">
            Page Not Found
        </h1>

        <p style="font-size: 1.1rem; color: #718096; margin-bottom: 2rem;">
            The page you're looking for doesn't exist or has been moved.
        </p>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('home') }}"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                <i class="fa-solid fa-house"></i> Go Home
            </a>

            <a href="{{ route('trending') }}"
                style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; background: #e2e8f0; color: #2d3748; text-decoration: none; border-radius: 8px; font-weight: 600;">
                <i class="fa-solid fa-fire"></i> Trending Songs
            </a>
        </div>

        <div
            style="margin-top: 3rem; padding: 2rem; background: #f7fafc; border-radius: 12px; text-align: left; max-width: 600px; margin-left: auto; margin-right: auto;">
            <h3 style="font-size: 1.25rem; color: #2d3748; margin-bottom: 1rem;">
                <i class="fa-solid fa-compass"></i> Quick Links
            </h3>

            <div style="display: grid; gap: 0.75rem;">
                <a href="{{ route('new') }}"
                    style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-music"></i> New Songs
                </a>
                <a href="{{ route('artists.top') }}"
                    style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-microphone"></i> Top Artists
                </a>
                <a href="{{ route('album.index') }}"
                    style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-compact-disc"></i> Albums
                </a>
                <a href="{{ route('movie.index') }}"
                    style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-clapperboard"></i> Movies
                </a>
                <a href="{{ route('genre.index') }}"
                    style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-guitar"></i> Genres
                </a>
            </div>
        </div>
    </div>
@endsection
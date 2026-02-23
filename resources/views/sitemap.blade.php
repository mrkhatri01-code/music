@extends('layouts.app')

@section('title', 'Sitemap')
@section('description', 'Navigate through all pages, artists, albums, and genres on ' . $siteName)

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="mb-4 font-weight-bold text-center">Sitemap</h1>
                        <p class="text-center text-muted mb-5">Explore all content available on {{ $siteName }}</p>

                        <div class="row">
                            {{-- General Pages --}}
                            <div class="col-md-4 mb-4">
                                <h3 class="h5 font-weight-bold mb-3 text-primary border-bottom pb-2">General</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                                    <li class="mb-2"><a href="{{ route('trending') }}" class="text-dark">Trending Songs</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('new') }}" class="text-dark">New Releases</a></li>
                                    <li class="mb-2"><a href="{{ route('upcoming') }}" class="text-dark">Upcoming Lyrics</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-dark">Contact Us</a></li>
                                    <li class="mb-2"><a href="{{ route('about') }}" class="text-dark">About Us</a></li>
                                    <li class="mb-2"><a href="{{ route('privacy') }}" class="text-dark">Privacy Policy</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('terms') }}" class="text-dark">Terms of Service</a>
                                    </li>
                                    <li class="mb-2"><a href="{{ route('dmca') }}" class="text-dark">DMCA</a></li>
                                </ul>
                            </div>

                            {{-- Genres --}}
                            <div class="col-md-4 mb-4">
                                <h3 class="h5 font-weight-bold mb-3 text-primary border-bottom pb-2">Genres</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="{{ route('genre.index') }}"
                                            class="text-dark font-weight-bold">All Genres</a></li>
                                    @foreach($genres as $genre)
                                        <li class="mb-1">
                                            <a href="{{ route('genre.show', $genre->slug) }}"
                                                class="text-secondary">{{ $genre->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Movies --}}
                            <div class="col-md-4 mb-4">
                                <h3 class="h5 font-weight-bold mb-3 text-primary border-bottom pb-2">Movies</h3>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="{{ route('movie.index') }}"
                                            class="text-dark font-weight-bold">All Movies</a></li>
                                    @foreach($movies as $movie)
                                        <li class="mb-1">
                                            <a href="{{ route('movie.show', $movie->slug) }}"
                                                class="text-secondary">{{ $movie->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="row mt-4">
                            {{-- Artists --}}
                            <div class="col-md-6 mb-4">
                                <h3 class="h5 font-weight-bold mb-3 text-primary border-bottom pb-2">Top Artists</h3>
                                <ul class="list-unstyled row">
                                    <li class="col-12 mb-2"><a href="{{ route('artists.top') }}"
                                            class="text-dark font-weight-bold">All Artists</a></li>
                                    @foreach($artists as $artist)
                                        <li class="col-md-6 mb-1">
                                            <a href="{{ route('artist.show', $artist->slug) }}"
                                                class="text-secondary">{{ $artist->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Albums --}}
                            <div class="col-md-6 mb-4">
                                <h3 class="h5 font-weight-bold mb-3 text-primary border-bottom pb-2">Albums</h3>
                                <ul class="list-unstyled row">
                                    <li class="col-12 mb-2"><a href="{{ route('album.index') }}"
                                            class="text-dark font-weight-bold">All Albums</a></li>
                                    @foreach($albums as $album)
                                        <li class="col-md-6 mb-1">
                                            <a href="{{ route('album.show', $album->slug) }}"
                                                class="text-secondary">{{ $album->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <p>
                                <a href="{{ route('sitemap.xml') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fa-solid fa-code mr-1"></i> XML Sitemap
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-secondary:hover {
            color: var(--color-primary) !important;
            text-decoration: underline;
        }
    </style>
@endsection
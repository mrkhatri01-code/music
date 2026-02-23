<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $artists = Artist::select('id', 'name_english as name', 'slug')->get();
        $albums = Album::select('id', 'name as title', 'slug')->get();
        $genres = Genre::select('id', 'name', 'slug')->get();
        $movies = Movie::select('id', 'name as title', 'slug')->get();

        return view('sitemap', compact('artists', 'albums', 'genres', 'movies'));
    }

    public function xml()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Homepage
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily');

        // Static pages
        $sitemap .= $this->addUrl(route('trending'), '0.9', 'daily');
        $sitemap .= $this->addUrl(route('new'), '0.9', 'daily');
        $sitemap .= $this->addUrl(route('artists.top'), '0.8', 'weekly');
        $sitemap .= $this->addUrl(route('album.index'), '0.8', 'weekly');
        $sitemap .= $this->addUrl(route('genre.index'), '0.8', 'weekly');
        $sitemap .= $this->addUrl(route('movie.index'), '0.8', 'weekly');

        // HTML Sitemap
        $sitemap .= $this->addUrl(route('sitemap'), '0.8', 'weekly');

        // Songs
        $songs = Song::where('is_published', true)
            ->with('artist')
            ->get();

        foreach ($songs as $song) {
            $sitemap .= $this->addUrl(
                route('song.show', [$song->artist->slug, $song->slug]),
                '0.7',
                'weekly',
                $song->updated_at
            );
        }

        // Artists
        $artists = Artist::all();
        foreach ($artists as $artist) {
            $sitemap .= $this->addUrl(
                route('artist.show', $artist->slug),
                '0.7',
                'weekly',
                $artist->updated_at
            );
        }

        // Albums
        $albums = Album::all();
        foreach ($albums as $album) {
            $sitemap .= $this->addUrl(
                route('album.show', $album->slug),
                '0.7',
                'weekly',
                $album->updated_at
            );
        }

        // Genres
        $genres = Genre::all();
        foreach ($genres as $genre) {
            $sitemap .= $this->addUrl(
                route('genre.show', $genre->slug),
                '0.6',
                'weekly',
                $genre->updated_at
            );
        }

        // Movies
        $movies = Movie::all();
        foreach ($movies as $movie) {
            $sitemap .= $this->addUrl(
                route('movie.show', $movie->slug),
                '0.7',
                'weekly',
                $movie->updated_at
            );
        }

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrl($loc, $priority = '0.5', $changefreq = 'weekly', $lastmod = null)
    {
        $url = '<url>';
        $url .= '<loc>' . htmlspecialchars($loc) . '</loc>';

        if ($lastmod) {
            $url .= '<lastmod>' . $lastmod->toAtomString() . '</lastmod>';
        }

        $url .= '<changefreq>' . $changefreq . '</changefreq>';
        $url .= '<priority>' . $priority . '</priority>';
        $url .= '</url>';

        return $url;
    }
}

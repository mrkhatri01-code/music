<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trending
Route::get('/trending', [HomeController::class, 'trendingWeek'])->name('trending');
Route::get('/trending/today', [HomeController::class, 'trendingToday'])->name('trending.today');
Route::get('/trending/week', [HomeController::class, 'trendingWeek'])->name('trending.week');
Route::get('/trending/month', [HomeController::class, 'trendingMonth'])->name('trending.month');

// New Songs
Route::get('/new', [HomeController::class, 'newSongs'])->name('new');
Route::get('/new/{year}', [HomeController::class, 'newSongsByYear'])->name('new.year');

// Artists
Route::get('/top-artists', [HomeController::class, 'topArtists'])->name('artists.top');
Route::get('/artist/{slug}', [ArtistController::class, 'show'])->name('artist.show');

// Albums
use App\Http\Controllers\AlbumController;
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/album/{slug}', [AlbumController::class, 'show'])->name('album.show');

// Songs
Route::get('/lyrics/{artistSlug}/{songSlug}', [SongController::class, 'show'])->name('song.show');
Route::post('/song/{songSlug}/report', [SongController::class, 'report'])->name('song.report');

// Genres
Route::get('/genre', [GenreController::class, 'index'])->name('genre.index');
Route::get('/genre/{slug}', [GenreController::class, 'show'])->name('genre.show');

// Movies
Route::get('/movies', [MovieController::class, 'index'])->name('movie.index');
Route::get('/movie/{slug}', [MovieController::class, 'show'])->name('movie.show');



// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Mood-based Pages
Route::get('/love-songs', [PageController::class, 'loveSongs'])->name('mood.love');
Route::get('/sad-songs', [PageController::class, 'sadSongs'])->name('mood.sad');
Route::get('/romantic-songs', [PageController::class, 'romanticSongs'])->name('mood.romantic');
Route::get('/party-songs', [PageController::class, 'partySongs'])->name('mood.party');
Route::get('/trending-on-tiktok', [PageController::class, 'trendingOnTikTok'])->name('mood.tiktok');

// Legal & Info Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/dmca', [PageController::class, 'dmca'])->name('dmca');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;
use App\Http\Controllers\Admin\SongController as AdminSongController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\SettingsController;

// Admin Login (Guest only)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Admin Protected Routes
Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Artists Management
    Route::resource('artists', AdminArtistController::class)->names([
        'index' => 'admin.artists.index',
        'create' => 'admin.artists.create',
        'store' => 'admin.artists.store',
        'edit' => 'admin.artists.edit',
        'update' => 'admin.artists.update',
        'destroy' => 'admin.artists.destroy',
    ]);

    // Albums Management
    // Note: use statement should be at top of file, or fully qualified.
    // However, since it's just a class name resolution, I'll use fully qualified here to be safe and clean.
    Route::resource('albums', \App\Http\Controllers\Admin\AlbumController::class)->names([
        'index' => 'admin.albums.index',
        'create' => 'admin.albums.create',
        'store' => 'admin.albums.store',
        'edit' => 'admin.albums.edit',
        'update' => 'admin.albums.update',
        'destroy' => 'admin.albums.destroy',
    ]);

    // Songs Management
    Route::resource('songs', AdminSongController::class)->names([
        'index' => 'admin.songs.index',
        'create' => 'admin.songs.create',
        'store' => 'admin.songs.store',
        'edit' => 'admin.songs.edit',
        'update' => 'admin.songs.update',
        'destroy' => 'admin.songs.destroy',
    ]);

    // Genres Management
    Route::resource('genres', AdminGenreController::class)->names([
        'index' => 'admin.genres.index',
        'create' => 'admin.genres.create',
        'store' => 'admin.genres.store',
        'edit' => 'admin.genres.edit',
        'update' => 'admin.genres.update',
        'destroy' => 'admin.genres.destroy',
    ]);

    // Movies Management
    Route::resource('movies', AdminMovieController::class)->names([
        'index' => 'admin.movies.index',
        'create' => 'admin.movies.create',
        'store' => 'admin.movies.store',
        'edit' => 'admin.movies.edit',
        'update' => 'admin.movies.update',
        'destroy' => 'admin.movies.destroy',
    ]);

    // Settings & Reports
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Ad Manager
    Route::get('/ads', [SettingsController::class, 'ads'])->name('admin.ads.index');
    Route::post('/ads', [SettingsController::class, 'updateAds'])->name('admin.ads.update');

    Route::get('/reports', [SettingsController::class, 'reports'])->name('admin.reports.index');
    Route::post('/reports/{report}/status', [SettingsController::class, 'updateReportStatus'])->name('admin.reports.update-status');
    Route::delete('/reports/{report}', [SettingsController::class, 'destroy'])->name('admin.reports.destroy');
});

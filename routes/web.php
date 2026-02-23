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
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PasswordResetRequestController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/



// Homepage
Route::domain('nepa-ly.com')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Trending
    Route::get('/trending', [HomeController::class, 'trendingWeek'])->name('trending');
    Route::get('/trending/today', [HomeController::class, 'trendingToday'])->name('trending.today');
    Route::get('/trending/week', [HomeController::class, 'trendingWeek'])->name('trending.week');
    Route::get('/trending/month', [HomeController::class, 'trendingMonth'])->name('trending.month');

    // New Songs
    Route::get('/new', [HomeController::class, 'newSongs'])->name('new');
    Route::get('/new/{year}', [HomeController::class, 'newSongsByYear'])->name('new.year');

    // Upcoming Lyrics
    Route::get('/upcoming-lyrics', [PageController::class, 'upcomingSongs'])->name('upcoming');

    // Artists
    Route::get('/top-artists', [HomeController::class, 'topArtists'])->name('artists.top');
    Route::get('/artist/{slug}', [ArtistController::class, 'show'])->name('artist.show');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/album/{slug}', [AlbumController::class, 'show'])->name('album.show');

    // Songs
    Route::get('/lyrics/{artistSlug}/{songSlug}', [SongController::class, 'show'])->name('song.show');
    Route::get('/lyrics/{artistSlug}/{songSlug}/print', [SongController::class, 'print'])->name('song.print');
    Route::get('/report/{artistSlug}/{songSlug}', [SongController::class, 'showReportForm'])->name('song.report.form');
    Route::post('/song/{songSlug}/report', [SongController::class, 'report'])->name('song.report');
    Route::post('/subscribe', [\App\Http\Controllers\SubscriptionController::class, 'store'])->name('subscribe');

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
    Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
    Route::get('/dmca', [PageController::class, 'dmca'])->name('dmca');
    Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy');
    Route::get('/terms-of-service', [PageController::class, 'termsOfService'])->name('terms');
    Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

    // SEO
    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');
    Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');
});



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

// Auth
use App\Http\Controllers\Auth\LoginController;
Route::domain('nepa-ly.com')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    // Password Reset Request
    Route::get('/password/reset', [PasswordResetRequestController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset', [PasswordResetRequestController::class, 'sendResetLinkEmail'])->name('password.email');
});

// Admin Login (Guest only)
Route::domain('admin.nepa-ly.com')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

    });

    // Admin Protected Routes
    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Artists Management
        Route::put('/artists/{artist}/account', [AdminArtistController::class, 'updateAccount'])->name('admin.artists.update-account');
        Route::resource('artists', AdminArtistController::class)->names([
            'index' => 'admin.artists.index',
            'create' => 'admin.artists.create',
            'store' => 'admin.artists.store',
            'edit' => 'admin.artists.edit',
            'update' => 'admin.artists.update',
            'destroy' => 'admin.artists.destroy',
        ]);

        // Team Members Management
        Route::resource('team-members', \App\Http\Controllers\Admin\TeamMemberController::class)->names([
            'index' => 'admin.team-members.index',
            'create' => 'admin.team-members.create',
            'store' => 'admin.team-members.store',
            'edit' => 'admin.team-members.edit',
            'update' => 'admin.team-members.update',
            'destroy' => 'admin.team-members.destroy',
        ]);

        // About Us Content Management
        Route::get('settings/about', [\App\Http\Controllers\Admin\SettingsController::class, 'about'])->name('admin.settings.about');
        Route::post('settings/about', [\App\Http\Controllers\Admin\SettingsController::class, 'updateAbout'])->name('admin.settings.about.update');

        // DMCA & Privacy Policy Management
        Route::get('settings/dmca', [\App\Http\Controllers\Admin\SettingsController::class, 'dmca'])->name('admin.settings.dmca');
        Route::post('settings/dmca', [\App\Http\Controllers\Admin\SettingsController::class, 'updateDmca'])->name('admin.settings.dmca.update');

        Route::get('settings/privacy-policy', [\App\Http\Controllers\Admin\SettingsController::class, 'privacyPolicy'])->name('admin.settings.privacy-policy');
        Route::post('settings/privacy-policy', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePrivacyPolicy'])->name('admin.settings.privacy-policy.update');

        Route::get('settings/disclaimer', [\App\Http\Controllers\Admin\SettingsController::class, 'disclaimer'])->name('admin.settings.disclaimer');
        Route::post('settings/disclaimer', [\App\Http\Controllers\Admin\SettingsController::class, 'updateDisclaimer'])->name('admin.settings.disclaimer.update');

        // Albums Management
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

        // Song restore and permanent delete
        Route::post('songs/{id}/restore', [AdminSongController::class, 'restore'])->name('admin.songs.restore');
        Route::delete('songs/{id}/force-delete', [AdminSongController::class, 'forceDelete'])->name('admin.songs.force-delete');

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
        Route::put('/settings/credentials', [SettingsController::class, 'updateCredentials'])->name('admin.settings.credentials.update');

        // System Maintenance
        Route::get('/system', [SettingsController::class, 'system'])->name('admin.system.index');
        Route::post('/system/cache', [SettingsController::class, 'clearCache'])->name('admin.system.cache');
        Route::post('/system/sessions', [SettingsController::class, 'clearSessions'])->name('admin.system.sessions');

        // Ad Manager
        Route::get('/ads', [SettingsController::class, 'ads'])->name('admin.ads.index');
        Route::post('/ads', [SettingsController::class, 'updateAds'])->name('admin.ads.update');
        Route::delete('/ads/popup-image', [SettingsController::class, 'deletePopupImage'])->name('admin.ads.delete-popup-image');

        // Reports
        Route::get('/reports', [SettingsController::class, 'reports'])->name('admin.reports.index');
        Route::get('/reports/{report}', [SettingsController::class, 'showReport'])->name('admin.reports.show');
        Route::post('/reports/{report}/status', [SettingsController::class, 'updateReportStatus'])->name('admin.reports.update-status');
        Route::delete('/reports/{report}', [SettingsController::class, 'destroy'])->name('admin.reports.destroy');

        // Contacts
        Route::get('/contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('admin.contacts.show');
        Route::patch('/contacts/{contact}/status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('admin.contacts.update-status');
        Route::delete('/contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('admin.contacts.destroy');

        // Subscriptions
        Route::get('/subscriptions', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
        Route::patch('/subscriptions/{subscription}/status', [\App\Http\Controllers\Admin\SubscriptionController::class, 'toggleStatus'])->name('admin.subscriptions.status');

        // Visitor Tracker
        Route::get('/visitors', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('admin.visitors.index');

        // Artist Registration Requests
        Route::get('/artist-requests', [\App\Http\Controllers\Admin\ArtistRequestController::class, 'index'])->name('admin.artist-requests.index');
        Route::post('/artist-requests/{id}/approve', [\App\Http\Controllers\Admin\ArtistRequestController::class, 'approve'])->name('admin.artist-requests.approve');
        Route::post('/artist-requests/{id}/reject', [\App\Http\Controllers\Admin\ArtistRequestController::class, 'reject'])->name('admin.artist-requests.reject');

        // Password Reset Requests
        Route::get('/password-requests', [\App\Http\Controllers\Admin\PasswordResetRequestController::class, 'index'])->name('admin.password-requests.index');
        Route::patch('/password-requests/{id}/resolve', [\App\Http\Controllers\Admin\PasswordResetRequestController::class, 'resolve'])->name('admin.password-requests.resolve');
        Route::delete('/password-requests/{id}', [\App\Http\Controllers\Admin\PasswordResetRequestController::class, 'destroy'])->name('admin.password-requests.destroy');
    });
});


// Artist Panel Routes
// Artist Panel Routes
Route::domain('artists.nepa-ly.com')->group(function () {
    Route::name('artist.')->group(function () {

        // Artist Login Routes (Guests only)
        Route::middleware('guest')->group(function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

            // Artist Registration (Public)
            Route::get('/register', [\App\Http\Controllers\ArtistRegistrationController::class, 'showForm'])->name('register');
            Route::post('/register', [\App\Http\Controllers\ArtistRegistrationController::class, 'submit'])->name('register.submit');

        });

        // Root redirect (Accessible to all)
        Route::get('/', function () {
            return redirect()->route('artist.login');
        });

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::middleware(['auth', 'artist'])->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\Artist\DashboardController::class, 'index'])->name('dashboard');

            // Profile
            Route::get('/profile/create', [\App\Http\Controllers\Artist\DashboardController::class, 'createProfile'])->name('profile.create');
            Route::post('/profile/create', [\App\Http\Controllers\Artist\DashboardController::class, 'storeProfile'])->name('profile.store');
            Route::get('/profile', [\App\Http\Controllers\Artist\DashboardController::class, 'profile'])->name('profile');
            Route::put('/profile', [\App\Http\Controllers\Artist\DashboardController::class, 'updateProfile'])->name('profile.update');
            Route::put('/password', [\App\Http\Controllers\Artist\DashboardController::class, 'updatePassword'])->name('password.update');

            // Songs
            Route::get('/songs', [\App\Http\Controllers\Artist\DashboardController::class, 'songs'])->name('songs.index');
            Route::get('/songs/create', [\App\Http\Controllers\Artist\DashboardController::class, 'createSong'])->name('songs.create');
            Route::post('/songs', [\App\Http\Controllers\Artist\DashboardController::class, 'storeSong'])->name('songs.store');
            Route::get('/songs/{id}/edit', [\App\Http\Controllers\Artist\DashboardController::class, 'editSong'])->name('songs.edit');
            Route::put('/songs/{id}', [\App\Http\Controllers\Artist\DashboardController::class, 'updateSong'])->name('songs.update');

            // Albums
            Route::get('/albums', [\App\Http\Controllers\Artist\DashboardController::class, 'albums'])->name('albums.index');
            Route::get('/albums/create', [\App\Http\Controllers\Artist\DashboardController::class, 'createAlbum'])->name('albums.create');
            Route::post('/albums', [\App\Http\Controllers\Artist\DashboardController::class, 'storeAlbum'])->name('albums.store');
            Route::get('/albums/{id}/edit', [\App\Http\Controllers\Artist\DashboardController::class, 'editAlbum'])->name('albums.edit');
            Route::put('/albums/{id}', [\App\Http\Controllers\Artist\DashboardController::class, 'updateAlbum'])->name('albums.update');

            // Utilities
            Route::post('/romanize', [\App\Http\Controllers\Artist\DashboardController::class, 'romanize'])->name('romanize');
        });
    });
});


// Fallback Route for Debugging (Temporary)


# Nepali Lyrics Platform (MusicPHP)

A comprehensive web application for managing and displaying Nepali song lyrics, featuring trending charts, artist profiles, new releases, and a robust admin dashboard. Built with the Laravel framework.

## 🛠 Technology Stack

### Backend
*   **Framework**: [Laravel 10.x](https://laravel.com)
*   **Language**: PHP 8.1+
*   **Database**: MySQL
*   **ORM**: Eloquent

### Frontend
*   **Templating**: Laravel Blade
*   **Styling**: Custom CSS (Vanilla)
*   **Icons**: FontAwesome 6
*   **Interactivity**: Vanilla JavaScript

## 📂 Project Structure

```plaintext
musicphp/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Request handling logic (SongController, ArtistController, etc.)
│   │   └── Middleware/     # Request filtering
│   └── Models/             # Eloquent models (Song, Artist, Genre, etc.)
├── config/                 # Application configuration files
├── database/
│   ├── migrations/         # Database schema definitions
│   └── seeders/            # Database seeding classes
├── public/                 # Web server entry point and static assets (images, css, js)
├── resources/
│   ├── css/                # Source CSS files
│   └── views/              # Blade templates
│       ├── layouts/        # Base page layouts
│       ├── pages/          # Static pages (about, contact)
│       ├── song/           # Song-related views
│       └── trending/       # Trending section views
├── routes/
│   ├── web.php             # Web routes definition
│   └── api.php             # API routes definition
├── storage/                # Logs, compiled views, file uploads
└── tests/                  # Automated tests
```

## 🚀 Getting Started

Follow these steps to set up the project locally.

### Prerequisites
*   PHP >= 8.1
*   Composer
*   MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone <repository-url>
    cd musicphp
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Environment Configuration**
    Copy the example environment file and configure your database settings.
    ```bash
    cp .env.example .env
    ```
    Open `.env` and update the database credentials:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations**
    Set up the database tables.
    ```bash
    php artisan migrate
    ```

6.  **Start Local Server**
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://localhost:8000`.

## ✨ Key Features
*   **Trending Section**: Automated tracking of daily and weekly trending songs based on views.
*   **Artist Profiles**: Dedicated pages for artists with their song collections.
*   **Search**: Full-text search for songs and artists.
*   **Admin Dashboard**: Manage songs, artists, genres, and view statistics.
*   **Responsive Design**: Mobile-friendly interface for reading lyrics on any device.

## 📝 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


<div align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>

# MusicPHP

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)](LICENSE)

**MusicPHP** is a robust and feature-rich music and media management system built with the **Laravel** framework. It provides a seamless experience for users to discover, listen to, and explore songs, albums, and artists, while offering powerful tools for administrators to manage content, track visitors, and analyze trends.

</div>

---

## 🚀 Key Features

### 🎵 Public Frontend
- **Trending & Discovery**: View trending songs by Today, Week, or Month. Discover new releases and upcoming lyrics.
- **Mood-Based Playlists**: Curated sections for specific moods like *Love Songs*, *Sad Songs*, *Party Songs*, and *Trending on TikTok*.
- **Comprehensive Media Library**: Explore detailed pages for **Artists**, **Albums**, **Songs**, and **Movies**.
- **Search Functionality**: Real-time autocomplete search to find content instantly.
- **User Engagement**:
  - View lyrics for songs.
  - Report issues with content.
  - Subscribe to newsletters.

### 🛠 Admin Dashboard
- **Content Management**: Complete CRUD operations for:
  - 🎤 Artists
  - 💿 Albums
  - 🎼 Songs (with Lyrics & Reporting)
  - 🎬 Movies
  - 🏷 Genres
- **Analytics & Tracking**:
  - **Visitor Tracker**: Monitor traffic and user activity.
  - **Reports**: Handle user-submitted reports for broken songs or lyrics.
- **Monetization & Settings**:
  - **Ad Manager**: Manage advertisement placements.
  - **Site Settings**: Configure general site options.
  - **Contact Management**: View and respond to user inquiries.

---

## 🏗 Project Structure

A high-level overview of the project's file structure:

```
musicphp/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Admin & User Controllers
│   │   ├── Middleware/     # Auth & Role Middleware
│   │   └── Requests/       # Form Validation
│   └── Models/             # Eloquent Models (Song, Album, Artist, etc.)
├── config/                 # Application Configuration
├── database/
│   ├── migrations/         # Database Schema
│   └── seeders/            # Fake Data Generators
├── public/                 # Static Assets (Images, CSS, JS)
├── resources/
│   └── views/              # Blade Templates
│       ├── admin/          # Admin Dashboard Views
│       ├── layouts/        # Master Layouts
│       └── ...             # Frontend Views (Home, Artist, etc.)
├── routes/
│   ├── web.php             # Web Routes (User & Admin)
│   └── api.php             # API Endpoints
└── tests/                  # Application Tests
```

---

## ⚙️ Usage Flow

1.  **User Access**: Visitors land on the homepage (`/`) where they can see the latest and trending music.
2.  **Navigation**: Users navigate through `Artists`, `Albums`, or specific `Mood` categories.
3.  **Consumption**: Clicking a song takes the user to `lyrics/{artist}/{song}` to view details.
4.  **Admin Login**: Administrators access the panel via `/admin/login`.
5.  **Management**: Admins use the dashboard to upload new songs, manage artist profiles, and view site statistics.

---

## 💻 Getting Started

Follow these steps to set up the project locally.

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/yourusername/musicphp.git
    cd musicphp
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Setup**
    Copy the example environment file and configure your database settings.
    ```bash
    cp .env.example .env
    ```
    Update `.env` with your database credentials:
    ```ini
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

6.  **Start the Server**
    ```bash
    php artisan serve
    ```
    Access the application at `http://localhost:8000`.

---

## 🔒 Security

If you discover any security related issues, please email the administrator instead of using the issue tracker.

## 📄 License

The MusicPHP project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

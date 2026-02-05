# Aruna and Ink - Music & Media Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.1-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5">
  <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3">
</p>

<p align="center">
  A modern, feature-rich music and media management system built with Laravel 10. Designed for seamless music discovery, listening, and comprehensive content management.
</p>

---

## :sparkles: Features

### :globe_with_meridians: **Public Frontend**
- **Premium UX**: Responsive design with glassmorphism effects and smooth transitions.
- **Music Discovery**: View trending songs by **Today**, **Week**, or **Month**.
- **Mood Playlists**: Curated sections like *Love Songs*, *Sad Songs*, and *Trending on TikTok*.
- **Advanced Search**: Real-time autocomplete to find artists, albums, and songs instantly.
- **Media Library**: Detailed profile pages for Artists. Albums, and Songs with lyrics.
- **User Engagement**: Report broken content, view upcoming lyrics, and subscribe to updates.

### :wrench: **Admin Panel**
- **Dashboard Overview**: Track visitor stats, total songs, and artist counts.
- **Content Management**: Full CRUD for Artists, Albums, Songs, Movies, and Genres.
- **Reports Handling**: Manage user reports for broken songs or incorrect lyrics.
- **Monetization**: Integrated Ad Manager to control advertisement placements.
- **Settings**: Configure site metadata, contact info, and SEO settings.
- **Visitor Tracker**: Analytics to monitor site traffic and usage.

### :lock: **Security & Optimization**
- **Authentication**: Secure admin login and session management.
- **Validation**: Server-side form validation for all inputs.
- **SEO Optimized**: Dynamic meta tags and OpenGraph support for better sharing.

---

## :building_construction: Tech Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **Backend** | Laravel 10.x | Core framework, routing, MVC architecture |
| **Frontend** | Blade Templates | Server-side rendering of views |
| **Styling** | Custom CSS3 | Glassmorphism design system with variables |
| **Database** | MySQL 8.0 | Relational data storage |
| **Scripting** | Vanilla JS | Interactive elements and search |
| **Fonts** | Poppins & Noto Sans | Typography (English & Nepali support) |

---

## :file_folder: Project Structure

```
musicphp/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Admin & Public Controllers
│   │   └── Middleware/        # Auth & Role Middleware
│   ├── Models/                # Eloquent Models (Song, Album, Artist)
│   └── Providers/             # Service Providers
├── config/                    # Application Configuration
├── database/
│   ├── migrations/            # Database Schema Definitions
│   └── seeders/               # Test Data Generators
├── public/
│   ├── css/                   # Custom Stylesheets
│   ├── images/                # Static Assets & Uploads
│   └── js/                    # Frontend Scripts
├── resources/
│   └── views/
│       ├── admin/             # Dashboard Views
│       ├── layouts/           # Master Blade Layouts
│       └── ...                # Public Frontend Views
└── routes/
    └── web.php                # Application Routes
```

---

## :arrows_counterclockwise: Application Workflow

### 1. **User Discovery Flow**

```mermaid
graph TD
    A[Landing Page] --> B{Discovery Mode}
    B -->|Search| C[Autocomplete Results]
    B -->|Browse| D[Trending/Moods]
    C --> E[Song/Artist Page]
    D --> E
    E --> F{User Action}
    F -->|Play| G[Listen to Music]
    F -->|Read| H[View Lyrics]
    F -->|Report| I[Submit Issue]
```

### 2. **Admin Management Flow**

```mermaid
graph LR
    A[Admin Login] --> B[Dashboard]
    B --> C{Manage Content}
    C -->|Upload| D[Create Song/Album]
    C -->|Edit| E[Update Artist Details]
    C -->|Monitor| F[View Reports & Visitors]
    D --> G[Database]
    E --> G
```

---

## :rocket: Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/musicphp.git
   cd musicphp
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update `.env` file**
   Set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=musicphp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   - Public Site: `http://127.0.0.1:8000`
   - Admin Panel: `http://127.0.0.1:8000/admin/login`

---

## :art: Design System

### Color Palette
```css
:root {
    --color-primary: #2563eb;       /* Blue-600 */
    --color-accent: #7c3aed;        /* Violet-600 */
    --color-bg: #f8fafc;            /* Slate-50 */
    --color-surface: #ffffff;       /* White */
    --color-text-primary: #111827;  /* Gray-900 */
    --gradient-hero: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
}
```

### Typography
- **Headings**: `Poppins` (Bold, ExtraBold)
- **Body**: `Poppins` (Regular)
- **Nepali Text**: `Noto Sans Devanagari`

---

## :shield: Security

- **Restricted Admin Access**: Middleware protection for admin routes.
- **CSRF Protection**: All forms secured with Laravel tokens.
- **Input Sanitization**: Built-in protection against SQL injection and XSS.

---

## :page_facing_up: License

The Aruna and Ink project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">Made with ❤️ by Prabhakar Khatri</p>

# BRMP Aneka Kacang: Seed Stock Information & Management System

A web-based information and stock management system for **BRMP Aneka Kacang** (Balai Perakitan dan Pengujian Tanaman Aneka Kacang). This application provides a public-facing landing page that displays real-time seed stock data, and a secure admin panel for managing all seed-related records including varieties, lots, production processes, lab test results, orders, and stock transactions.

---

## Features

### Landing Page (Public)
- Real-time stock availability overview per commodity (Kedelai, Kacang Hijau, Kacang Tanah) and seed class (BS, FS, SS).
- Interactive visual guide explaining seed multiplication hierarchy (Breeder Seed, Foundation Seed, Stock Seed).
- Comprehensive catalog cards per variety with real-time stock counters.
- Dedicated lot inspection page.

### Admin Panel (Role-Based Access)
- **Role-Based Authorization**: Powered by Spatie Permission (Administrator, Petugas Benih, Order Processor).
- **Interactive Dashboard**: Summary metrics, interactive pie chart for clean stock distributions, production summaries, and recent activity feed.
- **Seed & Lot Management**: Manage seed varieties and lots with automatic lot number generation (format: `NNN-[KATEGORI]-XX-[KELAS]-[LOKASI]-[TH]`).
- **Production Workflow**: Track seed processing (Grading and Sorting) with real-time input/output/waste balance validation.
- **Order Management & Seed Allocation**: Complete order lifecycle tracking (Pending, Diproses, Siap, Selesai, Dibatalkan) with exact lot allocation.
- **Stock Recalculation**: Automatic stock calculation via model observers on every inventory transaction.
- **Report Export**: High-speed export of clean stock availability reports to CSV and Excel (.xlsx) formats via OpenSpout.
- **Audit Trail & Activity Log**: Automatic action logging via Spatie Activitylog.
- **Enhanced UX**: Compact sidebar navigation, Lucide icons, and automated session expiry redirection (HTTP 419).

### REST API
- Token-based API authentication via Laravel Sanctum (Bearer Token).
- Endpoints for categorized seed lots and production process history.

---

## Technology Stack

| Component | Technology | Details |
|---|---|---|
| Backend Framework | Laravel 12 | Laravel Framework v12.64.0 |
| Language | PHP 8.3 | Minimum requirement `^8.2`, active runtime PHP 8.3.16 |
| Frontend Reactivity | Livewire v4 | Livewire v4.3.3 (includes Alpine.js v3.4.2) |
| Icons | Lucide Icons | Lucide v1.57.0 (dynamic inline SVGs) |
| CSS Architecture | Custom Vanilla CSS (Nuvio System) | Token-based styling (`tokens.css`, `components.css`), no Tailwind utility in views |
| Typography | Google Fonts | - **Admin:** Inter<br>- **Landing:** Hanken Grotesk & Young Serif<br>- **Login:** Instrument Sans & Newsreader |
| Build Tool | Vite 7 | Vite v7.3.6 (Laravel Vite Plugin v2.0.0) |
| Database | PostgreSQL 17 | PostgreSQL 17.3 |
| Authentication & Access | Laravel Session + Sanctum + Spatie Permission | - Web session auth<br>- API Bearer tokens via Laravel Sanctum v4.0<br>- Role & Permission via Spatie Laravel Permission v8.3 |
| Reporting / Export | OpenSpout v5.3 | High-performance streaming export for CSV and Excel (.xlsx) |
| Activity Logging | Spatie Laravel Activitylog | Spatie Laravel Activitylog v4.12.3 |
| Debug (dev only) | Laravel Debugbar | Barryvdh Laravel Debugbar v4.4.0 |
| Local Server | Laragon + Nginx / PHP CLI Server | Development environment |

---

## Installation

### Prerequisites
- PHP >= 8.2 (PHP 8.3 recommended)
- Composer >= 2.x
- Node.js >= 18.x and NPM
- PostgreSQL 17

### Steps

```bash
# Clone the repository
git clone https://github.com/Syauqi-men/Seeds.git
cd Seeds

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Configure database in .env
DB_CONNECTION=
DB_HOST=127.0.0.1
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Set admin credentials in .env (used by Seeders)
ADMIN_EMAIL=
ADMIN_PASSWORD=your_secure_password

# Generate application key
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**
# BRMP Aneka Kacang: Seed Stock Information & Management System

A web-based information and stock management system for **BRMP Aneka Kacang** (Balai Riset dan Modernisasi Pertanian Aneka Kacang). This application provides a public-facing landing page that displays real-time seed stock data, and a secure admin panel for managing all seed-related records including varieties, lots, production processes, lab test results, and stock transactions.
---

## Features

### Landing Page (Public)
- Browse all registered **seed varieties** 

### Admin Panel (Login Required)
- Secure admin authentication via Laravel Breeze
- **Dashboard** with summary statistics: total varieties, lots, ready stock, depleted lots, total raw & clean stock
- Full **CRUD** management for seed processing
- **Automatic stock recalculation** via Observer pattern on every save/update/delete.
- **Activity Log** with date and module filters (full audit trail of all admin actions)
---

## Technology Stack

| Component | Technology |
|-----------|-----------|
| Backend Framework | Laravel 12 |
| Language | PHP 8.2 |
| Frontend Reactivity | Livewire v4 (includes Alpine.js) |
| CSS | Custom Vanilla CSS (Emerald theme, no Tailwind) |
| Typography | Inter + Plus Jakarta Sans (Google Fonts) |
| Build Tool | Vite |
| Database | PostgreSQL 17 |
| Authentication | Laravel Breeze |
| Activity Logging | Spatie Laravel Activitylog v4.12.3 |
| Debug (dev only) | Laravel Debugbar |
| Local Server | Laragon + Nginx (development) |

---


## Installation

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
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

# Configure database in .env (currently use postgres)
DB_CONNECTION=
DB_HOST=127.0.0.1
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

# Set admin credentials in .env (used by AdminSeeder)
ADMIN_EMAIL=admin@brmp.go.id
ADMIN_PASSWORD=your_secure_password

# Generate application key
php artisan key:generate

# Create the PostgreSQL database (if not exists)
# Run this in psql or pgAdmin:
# CREATE DATABASE brmp_seed;

# Run migrations and seed the database
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**
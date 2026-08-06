BRMP Aneka Kacang — Seed Stock Information & Management System
A web-based information and stock management system for BRMP Aneka Kacang (Balai Riset dan Mekanisasi Pertanian Aneka Kacang). This application provides a public-facing landing page that displays real-time seed stock data, and a secure admin panel for managing all seed-related records including varieties, lots, production processes, lab test results, and stock transactions.

Built as an internship project, the system replaces manual record-keeping with a structured digital workflow — every stock change is automatically calculated and audit-logged without any manual triggers.

Features
Landing Page (Public)
Fully responsive layout across all screen sizes
Browse all registered seed varieties (Kedelai, Kacang Tanah, Kacang Hijau) with live filtering
Browse all seed lots with real-time search, category filter, and status filter (powered by Livewire)
Displays dynamic stock data (raw stock & clean stock) sourced directly from the database
Timestamps showing when each lot was last updated
Admin Panel (Login Required)
Secure admin authentication via Laravel Breeze
Dashboard with summary statistics: total varieties, lots, ready stock, depleted lots, total raw & clean stock
Recent transaction feed and activity audit trail on the dashboard
Full CRUD management for:
Seed Varieties (seeds) — name, class (NS/BS/FS/SS), category
Seed Lots (seed_lots) — lot number (auto-generated), status, harvest date, origin/arrival weight & moisture
Production Processes (production_processes) — input/output/shrinkage/waste quantities, moisture before & after
Lab Tests (lab_tests) — germination rate, moisture content, pass/fail result
Stock Transactions (stock_transactions) — IN / OUT / ADJUSTMENT entries with reference number
Automatic stock recalculation via Observer pattern on every save/update/delete — no manual triggers needed
Activity Log with date and module filters — full audit trail of all admin actions (powered by Spatie Laravel Activitylog)
Delete confirmation modals on all destructive actions
Technology Stack
Component	Technology
Backend Framework	Laravel 12
Language	PHP 8.2
Frontend Reactivity	Livewire v4 (includes Alpine.js)
CSS	Custom Vanilla CSS (Emerald theme, no Tailwind)
Typography	Inter + Plus Jakarta Sans (Google Fonts)
Build Tool	Vite
Database	PostgreSQL 17
Authentication	Laravel Breeze
Activity Logging	Spatie Laravel Activitylog v4.12.3
Debug (dev only)	Laravel Debugbar
Local Server	Laragon + Nginx (development)
Architecture Notes

seeds (varieties) ─┬─▶ seed_lots ─┬─▶ production_processes
                   │               ├─▶ lab_tests
                   │               └─▶ stock_transactions
                   │
                   └── Lot Number Format: LOT-{ABBR}-{YEAR}-{000}
                         e.g. LOT-KDL-2025-001 (Kedelai)
                              LOT-KTH-2025-001 (Kacang Tanah)
                              LOT-KHJ-2025-001 (Kacang Hijau)
Stock Observer Pattern:
SeedLotObserver automatically recalculates two stock fields on every change:

raw_stock — sum of all IN transactions minus OUT ± ADJUSTMENT
clean_stock — sum of all production process output quantities
Installation
Prerequisites
PHP >= 8.2
Composer
Node.js & NPM
PostgreSQL 17
Steps
bash

# Clone the repository
git clone https://github.com/username/brmp-aneka-kacang.git
cd brmp-aneka-kacang
# Install PHP dependencies
composer install
# Install Node dependencies
npm install
# Copy environment file
cp .env.example .env
# Configure database in .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=brmp_seed
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
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
The application will be available at http://127.0.0.1:8000

Default Admin Credentials
After running php artisan migrate --seed, the default admin account is:


URL:      http://127.0.0.1:8000/login
Email:    admin@brmp.go.id
Password: (value of ADMIN_EMAIL / ADMIN_PASSWORD in .env)
Important: Change ADMIN_PASSWORD in .env before deploying to any public or production environment, then re-run php artisan db:seed --class=AdminSeeder --force.

Seeded Test Data
The database seeder populates the following sample data for development and testing:

Entity	Count
Admin users	1
Seed varieties	12 (4 Kedelai, 4 Kacang Tanah, 4 Kacang Hijau)
Seed lots	37 (includes 13 lots for Anjasmoro to test pagination)
Production processes	~80 records
Lab test results	~55 records
Stock transactions	~150 records
Enum Reference
Enum	Values
SeedCategory	Kedelai, Kacang Tanah, Kacang Hijau
VarClass	NS (Nucleus Seed), BS (Breeder Seed), FS (Foundation Seed), SS (Stock Seed)
LotStatus	Raw, Processing, Quarantine, Ready, Depleted
TransactionType	IN, OUT, ADJUSTMENT
TestResult	PASSED, FAILED
Logo
Place the BRMP logo file at:

public/images/logo-brmp.png
If the file is absent, a fallback SVG icon will be displayed automatically in the navbar.

License
This project was developed as part of an internship at BRMP Aneka Kacang. All rights reserved by the respective institution.

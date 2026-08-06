<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
# BRMP Aneka Kacang — Seed Stock Information & Management System
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
A web-based information and stock management system for **BRMP Aneka Kacang** (Balai Riset dan Mekanisasi Pertanian Aneka Kacang). This application provides a public-facing landing page that displays real-time seed stock data, and a secure admin panel for managing all seed-related records including varieties, lots, production processes, lab test results, and stock transactions.
## About Laravel
Built as an internship project, the system replaces manual record-keeping with a structured digital workflow — every stock change is automatically calculated and audit-logged without any manual triggers.
Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
---
- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).
## Features
Laravel is accessible, powerful, and provides tools required for large, robust applications.
### Landing Page (Public)
- Fully responsive layout across all screen sizes
- Browse all registered **seed varieties** (Kedelai, Kacang Tanah, Kacang Hijau) with live filtering
- Browse all **seed lots** with real-time search, category filter, and status filter (powered by Livewire)
- Displays dynamic stock data (raw stock & clean stock) sourced directly from the database
- Timestamps showing when each lot was last updated
## Learning Laravel
### Admin Panel (Login Required)
- Secure admin authentication via Laravel Breeze
- **Dashboard** with summary statistics: total varieties, lots, ready stock, depleted lots, total raw & clean stock
- Recent transaction feed and activity audit trail on the dashboard
- Full **CRUD** management for:
  - Seed Varieties (`seeds`) — name, class (NS/BS/FS/SS), category
  - Seed Lots (`seed_lots`) — lot number (auto-generated), status, harvest date, origin/arrival weight & moisture
  - Production Processes (`production_processes`) — input/output/shrinkage/waste quantities, moisture before & after
  - Lab Tests (`lab_tests`) — germination rate, moisture content, pass/fail result
  - Stock Transactions (`stock_transactions`) — IN / OUT / ADJUSTMENT entries with reference number

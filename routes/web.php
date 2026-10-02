<?php

use App\Http\Controllers\Admin\{ ActivityLogController,
            DashboardController, LabTestController, OrderAllocationController,
            OrderController, ProductionProcessController, SeedCategoryController,
            SeedController, SeedLotController, SeedMutationController,
            StockTransactionController, UserController, WorkerController };
use App\Http\Controllers\LandingController;

use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/benih', [LandingController::class, 'benih'])->name('benih.index');
Route::get('/lot-benih', [LandingController::class, 'lotBenih'])->name('lot-benih.index');

// Auth routes
require __DIR__.'/auth.php';

// Admin Panel — akses semua role yang sudah login
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard — semua role bisa akses
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Log Aktivitas — semua role bisa lihat
        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

        // Khusus Administrator 
        Route::middleware('role:Administrator')->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
            Route::resource('seed-categories', SeedCategoryController::class)->except(['show']);
            Route::resource('workers', WorkerController::class)->except(['show']);
        });

        // Administrator + Petugas Benih 
        Route::middleware('role:Administrator|Petugas Benih')->group(function () {
            Route::resource('seeds', SeedController::class);
            Route::resource('seed-lots', SeedLotController::class);
            Route::resource('seed-mutations', SeedMutationController::class)->only(['index','create','store','destroy']);
            Route::resource('production-processes', ProductionProcessController::class);
            Route::resource('lab-tests', LabTestController::class);
        });

        // ── Administrator + Order Processor ─────────────────────────────
        Route::middleware('role:Administrator|Order Processor')->group(function () {
            Route::resource('stock-transactions', StockTransactionController::class);
            Route::resource('orders', OrderController::class)->only(['create', 'store', 'destroy']);
        });

        // ── Administrator + Order Processor + Petugas Benih ──────────────
        Route::middleware('role:Administrator|Order Processor|Petugas Benih')->group(function () {
            Route::resource('orders', OrderController::class)->only(['index', 'show', 'edit', 'update']);
        });

        // ── Alokasi Lot Benih — Petugas Benih + Administrator ────────────
        Route::middleware('role:Administrator|Petugas Benih')->group(function () {
            // GET  : ambil daftar lot + alokasi existing (AJAX)
            Route::get('orders/{order}/items/{item}/lots', [OrderAllocationController::class, 'lots'])
                ->name('orders.items.lots');
            // POST : simpan alokasi
            Route::post('orders/{order}/items/{item}/allocations', [OrderAllocationController::class, 'store'])
                ->name('orders.items.allocations.store');
            // DELETE : hapus semua alokasi item
            Route::delete('orders/{order}/items/{item}/allocations', [OrderAllocationController::class, 'destroy'])
                ->name('orders.items.allocations.destroy');
        });
    });

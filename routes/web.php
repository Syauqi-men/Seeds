<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LabTestController;
use App\Http\Controllers\Admin\ProductionProcessController;
use App\Http\Controllers\Admin\SeedController;
use App\Http\Controllers\Admin\SeedLotController;
use App\Http\Controllers\Admin\StockTransactionController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing Page  
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/benih', [LandingController::class, 'benih'])->name('benih.index');
Route::get('/lot-benih', [LandingController::class, 'lotBenih'])->name('lot-benih.index');

// Auth routes  
require __DIR__.'/auth.php';

// Admin Panel  
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('seeds', SeedController::class);
        Route::resource('seed-lots', SeedLotController::class);
        Route::resource('production-processes', ProductionProcessController::class);
        Route::resource('lab-tests', LabTestController::class);
        Route::resource('stock-transactions', StockTransactionController::class);

        Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    });

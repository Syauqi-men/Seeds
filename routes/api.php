<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SeedDataController;
use Illuminate\Support\Facades\Route;

// Max attempts 5 times, prevent BF
Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');

$apiAccess = ['auth:sanctum', 'role:' . implode('|', AuthController::ALLOWED_ROLES), 'throttle:60,1'];

Route::middleware(['web', ...$apiAccess])->group(function () {
    Route::get('me',                   [AuthController::class, 'me']);
    Route::get('seed-lots',            [SeedDataController::class, 'seedLots']);
    Route::get('production-processes', [SeedDataController::class, 'productionProcesses']);
    Route::get('stock-summary',        [SeedDataController::class, 'stockSummary']);
});

// Logout without token 
Route::middleware($apiAccess)->post('logout', [AuthController::class, 'logout']);

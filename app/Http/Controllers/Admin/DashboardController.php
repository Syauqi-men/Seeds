<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LotStatus;
use App\Http\Controllers\Controller;
use App\Models\Seed;
use App\Models\SeedLot;
use App\Models\StockTransaction;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_seeds'    => Seed::count(),
            'total_lots'     => SeedLot::count(),
            'lots_ready'     => SeedLot::where('status', LotStatus::Ready)->count(),
            'lots_depleted'  => SeedLot::where('status', LotStatus::Depleted)->count(),
            'total_raw'      => SeedLot::sum('raw_stock'),
            'total_clean'    => SeedLot::sum('clean_stock'),
        ];

        $recentTransactions = StockTransaction::with('seedLot.seed')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = Activity::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'recentActivities'));
    }
}

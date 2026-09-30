<?php

namespace App\Http\Controllers;

use App\Models\Seed;
use App\Models\SeedLot;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LandingController extends Controller
{
    public function index()
    {
        return redirect()->route('benih.index');
    }

    public function benih()
    {
        // Eager load limit 10 per seed
        $seeds = Seed::with(['seedLots' => function ($query) {
            $query->orderBy('updated_at', 'desc');
        }, 'category'])
            ->join('seed_categories', 'seeds.category_id', '=', 'seed_categories.id')
            ->orderBy('seed_categories.name')
            ->orderBy('seeds.var_name')
            ->select('seeds.*')
            ->get();

        $recentActivities = Activity::where('log_name', '!=', 'system')
            ->latest()
            ->take(5)
            ->get();

        return view('landing.benih', compact('seeds', 'recentActivities'));
    }

    public function lotBenih(Request $request)
    {
        return view('landing.lot-benih');
    }
}

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
        // Eager load dengan limit 10 per seed, anti N+1 (PRD §4.1)
        $seeds = Seed::with(['seedLots' => function ($query) {
            $query->orderBy('updated_at', 'desc');
        }])->orderBy('category')->orderBy('var_name')->get();

        // Aktivitas terbaru dari log publik (PRD §0.7)
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

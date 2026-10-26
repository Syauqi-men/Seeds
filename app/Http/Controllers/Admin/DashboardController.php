<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProcessType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItemAllocation;
use App\Models\ProductionProcess;
use App\Models\Seed;
use App\Models\SeedLot;
use App\Models\StockTransaction;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    /** Urutan komoditas yang ditampilkan di kartu dashboard. */
    private const COMMODITIES = ['Kedelai', 'Kacang Hijau', 'Kacang Tanah'];

    /** Kelas benih yang ditampilkan. */
    private const CLASSES = ['BS', 'FS', 'SS'];

    public function index()
    {
        $stats = [
            'total_seeds' => Seed::count(),
            'total_lots'  => SeedLot::count(),
            'total_raw'   => SeedLot::sum('raw_stock'),
            'total_clean' => SeedLot::sum('clean_stock'),
        ];

        $commodities = self::COMMODITIES;
        $classes     = self::CLASSES;

        $zeroByCommodity = array_fill_keys($commodities, 0.0);
        $zeroMatrix      = array_fill_keys(
            $commodities,
            array_fill_keys($classes, 0.0)
        );

        // Produksi: Grading, Sorting, Unprocess (per komoditas)
        $production = [
            'grading'   => $zeroByCommodity,
            'sorting'   => $zeroByCommodity,
            'unprocess' => $zeroByCommodity,
        ];

        // Stok bersih per komoditas & kelas
        $stock = $zeroMatrix;

        $lots = SeedLot::with('seed.category')->get();
        foreach ($lots as $lot) {
            $commodity = $lot->seed?->category?->name;
            if (! in_array($commodity, $commodities, true)) {
                continue;
            }

            // Unprocess = stok mentah yang belum diproses
            $production['unprocess'][$commodity] += (float) $lot->raw_stock;

            $class = $lot->seed->var_class?->value;
            if (in_array($class, $classes, true)) {
                $stock[$commodity][$class] += (float) $lot->clean_stock;
            }
        }

        // Grading & Sorting = total output hasil proses
        $processes = ProductionProcess::with('seedLot.seed.category')->get();
        foreach ($processes as $process) {
            $commodity = $process->seedLot?->seed?->category?->name;
            if (! in_array($commodity, $commodities, true)) {
                continue;
            }

            $key = $process->process_type === ProcessType::Grading ? 'grading' : 'sorting';
            $production[$key][$commodity] += (float) $process->output_quantity;
        }

        // Distribusi: benih tersalur (pesanan selesai) per komoditas & kelas
        $distributed = $zeroMatrix;

        $allocations = OrderItemAllocation::with('seedLot.seed.category')
            ->whereHas('orderItem.order', fn ($q) => $q->where('status', 'completed'))
            ->get();

        foreach ($allocations as $allocation) {
            $seed      = $allocation->seedLot?->seed;
            $commodity = $seed?->category?->name;
            $class     = $seed?->var_class?->value;

            if (in_array($commodity, $commodities, true) && in_array($class, $classes, true)) {
                $distributed[$commodity][$class] += (float) $allocation->alloc_quantity;
            }
        }

        // Jumlah customer unik dari nama pemesan (pesanan tidak dibatalkan)
        $customerCount = Order::where('status', '!=', 'cancelled')
            ->pluck('cust_name')
            ->map(fn ($name) => mb_strtolower(trim((string) $name)))
            ->filter()
            ->unique()
            ->count();

        $recentTransactions = StockTransaction::with('seedLot.seed')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = Activity::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'stats',
            'commodities',
            'classes',
            'production',
            'stock',
            'distributed',
            'customerCount',
            'recentTransactions',
            'recentActivities'
        ));
    }
}

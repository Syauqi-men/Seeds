<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductionProcess;
use App\Models\SeedLot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SeedDataController extends Controller
{
    public function seedLots(Request $request): JsonResponse
    {
        $lots = $this->seedLotQuery($request)->get();

        return response()->json([
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'data'         => $this->groupSeedLotsByCategory($lots),
        ]);
    }

    /**
     * GET /api/production-processes
     *
     * Riwayat proses produksi per kategori, varietas, dan lot.
     */
    public function productionProcesses(Request $request): JsonResponse
    {
        $processes = $this->productionProcessQuery($request)->latest('processed_at')->get();

        return response()->json([
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'total_proses' => $processes->count(),
            'data'         => $this->groupProcessesByCategory($processes),
        ]);
    }

    /*
    GET /api/stock-summary 
    Ringkasan stok bersih dikelompokkan per kategori,
     */
    public function stockSummary(): JsonResponse
    {
        $summary = DB::table('seed_lots')
            ->join('seeds', 'seed_lots.seed_id', '=', 'seeds.id')
            ->join('seed_categories', 'seeds.category_id', '=', 'seed_categories.id')
            ->select(
                'seed_categories.name as kategori',
                'seeds.var_class as kelas',
                'seeds.var_name as varietas',
                DB::raw('SUM(seed_lots.clean_stock) as total_stok_bersih')
            )
            ->groupBy('seed_categories.name', 'seeds.var_class', 'seeds.var_name')
            ->havingRaw('SUM(seed_lots.clean_stock) > 0')
            ->orderBy('seed_categories.name')
            ->orderBy('seeds.var_class')
            ->orderBy('seeds.var_name')
            ->get();

        $grouped = $summary->groupBy('kategori')
            ->map(fn (Collection $items, int|string $kategori): array => [
                'kategori'   => (string) $kategori,
                'total_data' => $items->count(),
                'list'       => $items->map(fn (object $item): array => [
                    'kelas'          => $item->kelas,
                    'varietas'       => $item->varietas,
                    'stok_bersih_kg' => (float) $item->total_stok_bersih,
                ])->values(),
            ])
            ->values();

        return response()->json([
            'generated_at' => now()->format('Y-m-d H:i:s'),
            'data'         => $grouped,
        ]);
    }

    // Seed Lots: helper
    // Query lot benih + filter opsional (kategori, kelas, varietas).
    private function seedLotQuery(Request $request): Builder
    {
        $query = SeedLot::query()->with('seed.category');

        if ($request->filled('kategori')) {
            $kategori = $request->input('kategori');
            $query->whereHas('seed.category', fn (Builder $q) => $q->where('name', 'like', "%{$kategori}%"));
        }
        if ($request->filled('kelas')) {
            $kelas = $request->input('kelas');
            $query->whereHas('seed', fn (Builder $q) => $q->where('var_class', $kelas));
        }
        if ($request->filled('varietas')) {
            $varietas = $request->input('varietas');
            $query->whereHas('seed', fn (Builder $q) => $q->where('var_name', 'like', "%{$varietas}%"));
        }

        return $query;
    }

    /**
     * Kelompokkan lot berdasarkan kategori, kelas, dan varietas.
     *
     * @param  Collection<int, SeedLot>  $lots
     */
    private function groupSeedLotsByCategory(Collection $lots): Collection
    {
        return $lots
            ->groupBy(fn (SeedLot $lot): string => $lot->seed?->category?->name ?? 'Tanpa Kategori')
            ->map(fn (Collection $categoryLots, int|string $categoryName): array => [
                'kategori' => (string) $categoryName,
                'varietas' => $this->groupSeedLotsByVariety($categoryLots),
            ])
            ->sortBy('kategori')
            ->values();
    }

    /**
     * @param  Collection<int, SeedLot>  $lots
     */
    private function groupSeedLotsByVariety(Collection $lots): Collection
    {
        return $lots
            ->groupBy(fn (SeedLot $lot): string => $this->varietyKey($lot))
            ->map(fn (Collection $varietyLots): array => $this->formatSeedLotVariety($varietyLots))
            ->sortBy([['kelas', 'asc'], ['nama', 'asc']])
            ->values();
    }

    /**
     * Satu baris varietas: kelas, nama, daftar lot, dan total stok bersih.
     *
     * @param  Collection<int, SeedLot>  $lots
     */
    private function formatSeedLotVariety(Collection $lots): array
    {
        /** @var SeedLot $first */
        $first = $lots->first();

        return [
            'kelas'                => $first->seed->var_class->value,
            'nama'                 => $first->seed->var_name,
            'lots'                 => $lots->map(fn (SeedLot $lot): array => $this->formatSeedLot($lot))->values(),
            'total_stok_bersih_kg' => round((float) $lots->sum('clean_stock'), 2),
        ];
    }

    private function formatSeedLot(SeedLot $lot): array
    {
        return [
            'lot_number'     => $lot->lot_number,
            'stok_bersih_kg' => (float) $lot->clean_stock,
        ];
    }

    private function varietyKey(SeedLot $lot): string
    {
        return $lot->seed->var_class->value . '|' . $lot->seed->var_name;
    }

    //  Production Processes helper

    // Query proses produksi + filter opsional.
    private function productionProcessQuery(Request $request): Builder
    {
        $query = ProductionProcess::query()->with('seedLot.seed.category', 'worker');

        if ($request->filled('process_type')) {
            $query->where('process_type', $request->input('process_type'));
        }
        if ($request->filled('lot_number')) {
            $lotNumber = $request->input('lot_number');
            $query->whereHas('seedLot', fn (Builder $q) => $q->where('lot_number', $lotNumber));
        }
        if ($request->filled('kategori')) {
            $kategori = $request->input('kategori');
            $query->whereHas('seedLot.seed.category', fn (Builder $q) => $q->where('name', 'like', "%{$kategori}%"));
        }
        if ($request->filled('varietas')) {
            $varietas = $request->input('varietas');
            $query->whereHas('seedLot.seed', fn (Builder $q) => $q->where('var_name', 'like', "%{$varietas}%"));
        }
        if ($request->filled('from')) {
            $query->whereDate('processed_at', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('processed_at', '<=', $request->input('to'));
        }

        return $query;
    }

    /**
     * Kelompokkan proses berdasarkan kategori, varietas, dan lot.
     *
     * @param  Collection<int, ProductionProcess>  $processes
     */
    private function groupProcessesByCategory(Collection $processes): Collection
    {
        return $processes
            ->groupBy(fn (ProductionProcess $p): string => $p->seedLot?->seed?->category?->name ?? 'Tanpa Kategori')
            ->map(fn (Collection $catProcs, int|string $catName): array => [
                'kategori' => (string) $catName,
                'varietas' => $this->groupProcessesByVariety($catProcs),
            ])
            ->sortBy('kategori')
            ->values();
    }

    /**
     * @param  Collection<int, ProductionProcess>  $processes
     */
    private function groupProcessesByVariety(Collection $processes): Collection
    {
        return $processes
            ->groupBy(fn (ProductionProcess $p): string => $this->varietyKey($p->seedLot))
            ->map(function (Collection $varProcs): array {
                /** @var ProductionProcess $first */
                $first = $varProcs->first();

                return [
                    'kelas' => $first->seedLot->seed->var_class->value,
                    'nama'  => $first->seedLot->seed->var_name,
                    'lots'  => $this->groupProcessesByLot($varProcs),
                ];
            })
            ->sortBy([['kelas', 'asc'], ['nama', 'asc']])
            ->values();
    }

    /**
     * @param  Collection<int, ProductionProcess>  $processes
     */
    private function groupProcessesByLot(Collection $processes): Collection
    {
        return $processes
            ->groupBy(fn (ProductionProcess $p): string => $p->seedLot->lot_number)
            ->map(fn (Collection $lotProcs, int|string $lotNumber): array => [
                'lot_number'      => (string) $lotNumber,
                'proses'          => $lotProcs->map(fn (ProductionProcess $p): array => $this->formatProcess($p))->values(),
                'total_input_kg'  => round((float) $lotProcs->sum('input_quantity'), 2),
                'total_output_kg' => round((float) $lotProcs->sum('output_quantity'), 2),
                'total_sortir_kg' => round((float) $lotProcs->sum('sortir_quantity'), 2),
                'total_limbah_kg' => round((float) $lotProcs->sum('waste_quantity'), 2),
            ])
            ->values();
    }

    private function formatProcess(ProductionProcess $p): array
    {
        return [
            'id'             => $p->id,
            'jenis_proses'   => $p->process_type->value,
            'pekerja'        => $p->worker?->name,
            'input_kg'       => (float) $p->input_quantity,
            'output_kg'      => (float) $p->output_quantity,
            'sortir_kg'      => (float) $p->sortir_quantity,
            'limbah_kg'      => (float) $p->waste_quantity,
            'tanggal_proses' => $p->processed_at?->format('Y-m-d'),
            'catatan'        => $p->notes,
        ];
    }
}

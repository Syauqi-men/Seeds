<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAllocation;
use App\Models\SeedLot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderAllocationController extends Controller
{

    public function lots(Order $order, OrderItem $item)
    {
        abort_if($item->order_id !== $order->id, 404);

        $lots = SeedLot::with('seed')
            ->where('seed_id', $item->seed_id)
            ->where('clean_stock', '>', 0)
            ->orderBy('harvest_date')
            ->get()
            ->map(fn($lot) => [
                'id'           => $lot->id,
                'lot_number'   => $lot->lot_number,
                'harvest_date' => $lot->harvest_date?->format('d/m/Y'),
                'location'     => $lot->location,
                'clean_stock'  => (float) $lot->clean_stock,
            ]);

        $existingAllocations = $item->allocations()
            ->with('seedLot')
            ->get()
            ->map(fn($a) => [
                'id'             => $a->id,
                'seed_lot_id'    => $a->seed_lot_id,
                'lot_number'     => $a->seedLot->lot_number ?? '-',
                'alloc_quantity' => (float) $a->alloc_quantity,
            ]);

        return response()->json([
            'item' => [
                'id'         => $item->id,
                'seed_name'  => $item->seed->var_name ?? '-',
                'seed_class' => $item->seed_class instanceof \App\Enums\VarClass
                    ? $item->seed_class->value
                    : $item->seed_class,
                'quantity'   => (float) $item->quantity,
            ],
            'lots'                => $lots,
            'existing_allocations'=> $existingAllocations,
        ]);
    }

    public function store(Request $request, Order $order, OrderItem $item)
    {
        abort_if($item->order_id !== $order->id, 404);

        $data = $request->validate([
            'allocations'                       => 'required|array|min:1',
            'allocations.*.seed_lot_id'         => 'required|exists:seed_lots,id',
            'allocations.*.alloc_quantity'      => 'required|numeric|min:0.01',
        ], [
            'allocations.required'                  => 'Minimal satu baris alokasi lot wajib diisi.',
            'allocations.*.seed_lot_id.required'    => 'Lot benih wajib dipilih.',
            'allocations.*.seed_lot_id.exists'      => 'Lot benih tidak ditemukan.',
            'allocations.*.alloc_quantity.required' => 'Jumlah alokasi wajib diisi.',
            'allocations.*.alloc_quantity.numeric'  => 'Jumlah alokasi harus berupa angka.',
            'allocations.*.alloc_quantity.min'      => 'Jumlah alokasi harus lebih dari 0.',
        ]);

        $totalAllocated = collect($data['allocations'])->sum('alloc_quantity');
        $diff = abs($totalAllocated - (float) $item->quantity);

        if ($diff > 0.001) {
            $lebihKurang = $totalAllocated > $item->quantity ? 'melebihi' : 'kurang dari';
            return response()->json([
                'message' => 'Total alokasi (' . number_format($totalAllocated, 2) . ' kg) '
                    . $lebihKurang . ' jumlah yang dipesan (' . number_format($item->quantity, 2) . ' kg). '
                    . 'Total alokasi harus persis sama dengan jumlah pesanan.',
            ], 422);
        }

        foreach ($data['allocations'] as $alloc) {
            $lot = SeedLot::find($alloc['seed_lot_id']);
            $alreadyAllocatedElsewhere = OrderItemAllocation::where('seed_lot_id', $lot->id)
                ->whereHas('orderItem', fn($q) => $q->where('id', '!=', $item->id))
                ->sum('alloc_quantity');

            $available = $lot->clean_stock - $alreadyAllocatedElsewhere;

            if ($alloc['alloc_quantity'] > $available) {
                return response()->json([
                    'message' => "Lot {$lot->lot_number}: stok tersedia hanya " . number_format($available, 2) . " kg, tidak bisa mengalokasikan " . number_format($alloc['alloc_quantity'], 2) . " kg.",
                ], 422);
            }
        }

        DB::transaction(function () use ($item, $data) {
            // Remake old allocation
            $item->allocations()->delete();

            foreach ($data['allocations'] as $alloc) {
                $item->allocations()->create([
                    'seed_lot_id'    => $alloc['seed_lot_id'],
                    'alloc_quantity' => $alloc['alloc_quantity'],
                ]);
            }
        });

        return response()->json([
            'message' => 'Alokasi berhasil disimpan.',
        ]);
    }

    // Delete all allocation for order item
    public function destroy(Order $order, OrderItem $item)
    {
        abort_if($item->order_id !== $order->id, 404);

        $item->allocations()->delete();

        return response()->json(['message' => 'Alokasi berhasil dihapus.']);
    }
}

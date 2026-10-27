<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Seed;
use App\Models\SeedCategory;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('Order') && !$user->hasRole('Administrator')) {
            $statusOrder = ['ready', 'completed', 'preparing', 'pending', 'cancelled'];
        } else {
            $statusOrder = ['pending', 'preparing', 'ready', 'completed', 'cancelled'];
        }

        $statusLabels = [
            'pending'   => 'Pending',
            'preparing' => 'Diproses',
            'ready'     => 'Siap',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $statusBadges = [
            'pending'   => 'badge-quarantine',
            'preparing' => 'badge-processing',
            'ready'     => 'badge-ready',
            'completed' => 'badge-ready',
            'cancelled' => 'badge-depleted',
        ];

        // Get all orders, group by status
        $allOrders = Order::with(['user', 'petugasBenih', 'items.seed'])
            ->latest()
            ->get();

        $groupedOrders = collect($statusOrder)->mapWithKeys(function ($status) use ($allOrders) {
            return [$status => $allOrders->where('status', $status)->values()];
        });

        return view('admin.orders.index', compact('groupedOrders', 'statusOrder', 'statusLabels', 'statusBadges'));
    }

    public function create()
    {
        $categories = SeedCategory::orderBy('name')->get();
        $seeds = Seed::orderBy('var_name')->get();

        // Ringkasan stok bersih (clean stock) per kategori -> kelas -> varietas
        $stockSummary = SeedCategory::with(['seeds' => function ($q) {
            $q->withSum('seedLots', 'clean_stock')
              ->orderBy('var_name');
        }])
        ->orderByRaw("CASE 
            WHEN name LIKE '%Kedelai%' THEN 1 
            WHEN name LIKE '%Hijau%' THEN 2 
            WHEN name LIKE '%Tanah%' THEN 3 
            ELSE 4 END")
        ->get()
        ->map(function ($cat) {
            $byClass = $cat->seeds->groupBy(fn($s) => $s->var_class->value);

            // Kelas benih: BS, FS, SS
            $targetClasses = ['BS', 'FS', 'SS'];

            $classesData = [];
            foreach ($targetClasses as $cls) {
                $classesData[$cls] = $byClass->get($cls, collect())->map(function ($s) {
                    return [
                        'id'       => $s->id,
                        'name'     => $s->var_name,
                        'class'    => $s->var_class->value,
                        'stock'    => (float) ($s->seed_lots_sum_clean_stock ?? 0),
                    ];
                });
            }

            return [
                'category_id'       => $cat->id,
                'category_name'     => $cat->name,
                'total_clean_stock' => (float) $cat->seeds->sum('seed_lots_sum_clean_stock'),
                'classes'           => $classesData,
            ];
        });

        return view('admin.orders.create', compact('seeds', 'categories', 'stockSummary'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cust_name'       => 'required|string|max:150',
            'order_type'      => 'required|in:commercial,seed_aid,internal_transfer,lab_sample',
            'payment_status'  => 'required|in:unpaid,paid,exempt',
            'reference_num'   => 'nullable|string|max:100',
            'notes'           => 'nullable|string|max:500',

            'items'                => 'required|array|min:1',
            'items.*.seed_id'      => 'required|exists:seeds,id',
            'items.*.seed_class'   => 'required|in:BS,FS,SS',
            'items.*.quantity'     => 'required|numeric|min:0.01',
        ], [
            'cust_name.required'          => 'Nama pemesan wajib diisi.',
            'cust_name.max'               => 'Nama pemesan maksimal 150 karakter.',
            'order_type.required'         => 'Tipe pesanan wajib dipilih.',
            'order_type.in'               => 'Tipe pesanan tidak valid.',
            'payment_status.required'     => 'Status pembayaran wajib dipilih.',
            'payment_status.in'           => 'Status pembayaran tidak valid.',
            'reference_num.max'           => 'No. referensi maksimal 100 karakter.',
            'notes.max'                   => 'Catatan maksimal 500 karakter.',
            'items.required'              => 'Minimal harus ada satu item pesanan.',
            'items.min'                   => 'Minimal harus ada satu item pesanan.',
            'items.*.seed_id.required'    => 'Varietas benih wajib dipilih di setiap baris.',
            'items.*.seed_id.exists'      => 'Varietas benih yang dipilih tidak ditemukan.',
            'items.*.seed_class.required' => 'Kelas benih wajib dipilih di setiap baris.',
            'items.*.seed_class.in'       => 'Kelas benih tidak valid.',
            'items.*.quantity.required'   => 'Jumlah (kg) wajib diisi di setiap baris.',
            'items.*.quantity.numeric'    => 'Jumlah (kg) harus berupa angka.',
            'items.*.quantity.min'        => 'Jumlah (kg) harus lebih dari 0.',
        ]);

        DB::transaction(function () use ($data) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'cust_name'      => $data['cust_name'],
                'order_type'     => $data['order_type'],
                'payment_status' => $data['payment_status'],
                'reference_num'  => $data['reference_num'] ?? null,
                'notes'          => $data['notes'] ?? null,
                'status'         => 'pending',
            ]);

            foreach ($data['items'] as $item) {
                $order->items()->create([
                    'seed_id'    => $item['seed_id'],
                    'seed_class' => $item['seed_class'],
                    'quantity'   => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pesanan berhasil dicatat.');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'petugasBenih', 'items.seed', 'items.allocations.seedLot']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['items.seed', 'items.allocations.seedLot']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        /** @var User $user */
        $user = Auth::user();
        $isAdmin = $user->hasRole('Administrator');
        $isOrderProcessor = $user->hasRole('Order');
        $isPetugasBenih = $user->hasRole('Seed');

        $rules = [];

        if ($isAdmin || $isOrderProcessor) {
            $rules['cust_name']       = 'required|string|max:150';
            $rules['order_type']      = 'required|in:commercial,seed_aid,internal_transfer,lab_sample';
            $rules['payment_status']  = 'required|in:unpaid,paid,exempt';
            $rules['reference_num']   = 'nullable|string|max:100';
            $rules['notes']           = 'nullable|string|max:500';
        }

        if ($isAdmin || $isPetugasBenih) {
            $rules['status'] = 'required|in:pending,preparing,ready,completed,cancelled';
        }

        $data = $request->validate($rules, [
            'cust_name.required'      => 'Nama pemesan wajib diisi.',
            'cust_name.max'           => 'Nama pemesan maksimal 150 karakter.',
            'order_type.required'     => 'Tipe pesanan wajib dipilih.',
            'order_type.in'           => 'Tipe pesanan tidak valid.',
            'payment_status.required' => 'Status pembayaran wajib dipilih.',
            'payment_status.in'       => 'Status pembayaran tidak valid.',
            'status.required'         => 'Status pesanan wajib dipilih.',
            'status.in'               => 'Status pesanan tidak valid.',
            'reference_num.max'       => 'No. referensi maksimal 100 karakter.',
            'notes.max'               => 'Catatan maksimal 500 karakter.',
        ]);

        if ($isPetugasBenih && !$isAdmin && empty($order->petugas_benih_id)) {
            $data['petugas_benih_id'] = $user->id;
        }

        $oldStatus = $order->status;
        $newStatus = $data['status'] ?? $order->status;

        if (in_array($newStatus, ['completed', 'ready'])) {
            $order->load('items.allocations.seedLot', 'items.seed');
            $itemsBelumLengkap = [];

            foreach ($order->items as $item) {
                $totalAlokasi = $item->allocations->sum('alloc_quantity');
                if (abs($totalAlokasi - (float) $item->quantity) > 0.001) {
                    $itemsBelumLengkap[] = ($item->seed->var_name ?? 'Item #' . $item->id)
                        . ' (dialokasikan: ' . number_format($totalAlokasi, 2)
                        . ' kg, dipesan: ' . number_format($item->quantity, 2) . ' kg)';
                }
            }

            if (!empty($itemsBelumLengkap)) {
                return back()
                    ->withInput()
                    ->with('error', 'Tidak dapat mengubah status ke "' . ($newStatus === 'completed' ? 'Selesai' : 'Siap') . '". '
                        . 'Alokasi karung belum lengkap untuk: ' . implode('; ', $itemsBelumLengkap) . '.');
            }
        }

        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            DB::transaction(function () use ($order, $data) {
                $order->load('items.allocations.seedLot', 'items.seed');

                foreach ($order->items as $item) {
                    foreach ($item->allocations as $alloc) {
                        $lot = $alloc->seedLot;
                        $lot->clean_stock -= $alloc->alloc_quantity;
                        $lot->save();

                        StockTransaction::create([
                            'seed_lot_id'      => $lot->id,
                            'transaction_type' => 'OUT',
                            'quantity'         => $alloc->alloc_quantity,
                            'reference_no'     => $order->reference_num ?? 'ORD-' . $order->id,
                            'notes'            => 'Pengeluaran pesanan: ' . $order->cust_name
                                                . ' (Varietas: ' . ($item->seed->var_name ?? '-') . ')',
                            'transacted_at'    => now(),
                        ]);
                    }
                }

                $order->update($data);
            });

            return redirect()->route('admin.orders.index')
                             ->with('success', 'Pesanan diselesaikan. Stok telah dipotong otomatis dan tercatat di riwayat transaksi.');
        }

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            DB::transaction(function () use ($order, $data) {
                foreach ($order->items as $item) {
                    $item->allocations()->delete();
                }

                $order->update($data);
            });

            return redirect()->route('admin.orders.index')
                             ->with('success', 'Pesanan dibatalkan. Semua alokasi karung telah dilepas.');
        }

        $order->update($data);

        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        if (!in_array($order->status, ['pending', 'cancelled'])) {
            return back()->with('error', 'Hanya pesanan berstatus Pending atau Cancelled yang dapat dihapus.');
        }

        $order->delete();
        return redirect()->route('admin.orders.index')
                         ->with('success', 'Pesanan berhasil dihapus.');
    }
}

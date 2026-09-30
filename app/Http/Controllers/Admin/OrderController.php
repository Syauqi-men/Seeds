<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Seed;
use App\Models\SeedCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'petugasBenih', 'items.seed'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $categories = SeedCategory::orderBy('name')->get();
        $seeds = Seed::orderBy('var_name')->get();

        return view('admin.orders.create', compact('seeds', 'categories'));
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
            'items.*.seed_class'   => 'required|in:NS,BS,FS,SS',
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
        $order->load(['items.seed']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        /** @var User $user */
        $user = Auth::user();
        $isAdmin = $user->hasRole('Administrator');
        $isOrderProcessor = $user->hasRole('Order Processor');
        $isPetugasBenih = $user->hasRole('Petugas Benih');

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

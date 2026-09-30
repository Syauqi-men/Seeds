<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeedLot;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with('seedLot.seed')->latest()->paginate(15);
        return view('admin.stock-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.stock-transactions.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rows'                    => 'required|array|min:1',
            'rows.*.seed_lot_id'      => 'required|exists:seed_lots,id',
            'rows.*.transaction_type' => 'required|in:IN,OUT,ADJUSTMENT,GRADING,SORTING',
            'rows.*.quantity'         => 'required|numeric',
            'rows.*.reference_no'     => 'nullable|string|max:100',
            'rows.*.notes'            => 'nullable|string|max:500',
            'rows.*.transacted_at'    => 'nullable|date',
        ], [
            'rows.required'                    => 'Minimal harus ada satu baris transaksi.',
            'rows.*.seed_lot_id.required'      => 'Lot benih wajib dipilih di setiap baris.',
            'rows.*.seed_lot_id.exists'        => 'Lot benih yang dipilih tidak ditemukan.',
            'rows.*.transaction_type.required' => 'Tipe transaksi wajib dipilih di setiap baris.',
            'rows.*.transaction_type.in'       => 'Tipe transaksi tidak valid.',
            'rows.*.quantity.required'         => 'Jumlah (kg) wajib diisi di setiap baris.',
            'rows.*.quantity.numeric'          => 'Jumlah (kg) harus berupa angka.',
            'rows.*.reference_no.max'          => 'No. Referensi maksimal 100 karakter.',
            'rows.*.notes.max'                 => 'Catatan maksimal 500 karakter.',
            'rows.*.transacted_at.date'        => 'Tanggal transaksi tidak valid.',
        ]);

        foreach ($request->rows as $row) {
            StockTransaction::create([
                'seed_lot_id'      => $row['seed_lot_id'],
                'transaction_type' => $row['transaction_type'],
                'quantity'         => $row['quantity'],
                'reference_no'     => $row['reference_no'] ?? null,
                'notes'            => $row['notes'] ?? null,
                'transacted_at'    => $row['transacted_at'] ?: null,
            ]);
        }

        return redirect()->route('admin.stock-transactions.index')
                         ->with('success', count($request->rows) . ' transaksi stok berhasil dicatat.');
    }

    public function show(StockTransaction $stockTransaction)
    {
        $stockTransaction->load('seedLot.seed');
        return view('admin.stock-transactions.show', compact('stockTransaction'));
    }

    public function edit(StockTransaction $stockTransaction)
    {
        $lots = SeedLot::with('seed')->get();
        return view('admin.stock-transactions.edit', compact('stockTransaction', 'lots'));
    }

    public function update(Request $request, StockTransaction $stockTransaction)
    {
        $data = $request->validate([
            'seed_lot_id'      => 'required|exists:seed_lots,id',
            'transaction_type' => 'required|in:IN,OUT,ADJUSTMENT,GRADING,SORTING',
            'quantity'         => 'required|numeric',
            'reference_no'     => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
            'transacted_at'    => 'nullable|date',
        ], [
            'seed_lot_id.required'      => 'Lot benih wajib dipilih.',
            'seed_lot_id.exists'        => 'Lot benih yang dipilih tidak ditemukan.',
            'transaction_type.required' => 'Tipe transaksi wajib dipilih.',
            'transaction_type.in'       => 'Tipe transaksi tidak valid.',
            'quantity.required'         => 'Jumlah (kg) wajib diisi.',
            'quantity.numeric'          => 'Jumlah (kg) harus berupa angka.',
            'reference_no.max'          => 'No. Referensi maksimal 100 karakter.',
            'notes.max'                 => 'Catatan maksimal 500 karakter.',
            'transacted_at.date'        => 'Tanggal transaksi tidak valid.',
        ]);

        $stockTransaction->update($data);
        return redirect()->route('admin.stock-transactions.index')
                         ->with('success', 'Transaksi stok berhasil diperbarui.');
    }

    public function destroy(StockTransaction $stockTransaction)
    {
        $stockTransaction->delete();
        return redirect()->route('admin.stock-transactions.index')
                         ->with('success', 'Transaksi stok berhasil dihapus.');
    }
}

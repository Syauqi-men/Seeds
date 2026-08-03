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
        $data = $request->validate([
            'seed_lot_id'      => 'required|exists:seed_lots,id',
            'transaction_type' => 'required|in:IN,OUT,ADJUSTMENT',
            'quantity'         => 'required|numeric',
            'reference_no'     => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
            'transacted_at'    => 'nullable|date',
        ]);

        StockTransaction::create($data);
        return redirect()->route('admin.stock-transactions.index')->with('success', 'Transaksi stok berhasil dicatat.');
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
            'transaction_type' => 'required|in:IN,OUT,ADJUSTMENT',
            'quantity'         => 'required|numeric',
            'reference_no'     => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:500',
            'transacted_at'    => 'nullable|date',
        ]);

        $stockTransaction->update($data);
        return redirect()->route('admin.stock-transactions.index')->with('success', 'Transaksi stok berhasil diperbarui.');
    }

    public function destroy(StockTransaction $stockTransaction)
    {
        $stockTransaction->delete();
        return redirect()->route('admin.stock-transactions.index')->with('success', 'Transaksi stok berhasil dihapus.');
    }
}

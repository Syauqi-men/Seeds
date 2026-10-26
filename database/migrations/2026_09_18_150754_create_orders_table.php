<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->foreignId('petugas_benih_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->comment('Petugas gudang yang memproses pesanan ini');

            $table->string('cust_name')->comment('Nama pemesan (direkap dari pesanan offline, tidak memiliki akun di sistem)');

            $table->string('reference_num')
                  ->nullable()
                  ->unique()
                  ->comment('Nomor surat / referensi dokumen resmi');

            $table->enum('order_type', [
                'commercial',        
                'seed_aid',          
                'internal_transfer', 
                'lab_sample',        
            ])->comment('Tipe pesanan menentukan logika pembayaran');

            $table->enum('status', [
                'pending',    
                'preparing',  
                'ready',      
                'completed',  
                'cancelled', 
            ])->default('pending');

            $table->enum('payment_status', [
                'unpaid',  
                'paid',    
                'exempt',  
            ])->default('unpaid')->comment('Untuk commercial wajib paid sebelum status menjadi preparing');

            $table->text('notes')->nullable()->comment('Catatan tambahan dari petugas');

            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
            $table->index('order_type');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


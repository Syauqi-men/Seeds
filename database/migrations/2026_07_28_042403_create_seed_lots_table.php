<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seed_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seed_id')->constrained('seeds')->cascadeOnDelete();
            $table->string('lot_number')->unique();
            $table->date('harvest_date')->nullable();
            $table->decimal('origin_weight', 10, 2)->nullable();
            $table->decimal('origin_moisture', 5, 2)->nullable();
            $table->decimal('arrival_weight', 10, 2)->nullable();
            $table->decimal('arrival_moisture', 5, 2)->nullable();
            $table->string('location', 10)->nullable()
                  ->comment('Alias lokasi: KP, JG, NG, MN, GT');
            $table->string('lot_code_prefix', 20)->default('KD-DP-BS')
                  ->comment('Kode prefix lot (tersimpan di DB, tidak ditampilkan di form)');
            $table->decimal('raw_stock', 10, 2)->default(0)
                  ->comment('Stok mentah dari transaksi stok (IN - OUT ± ADJ)');
            $table->decimal('clean_stock', 10, 2)->default(0)
                  ->comment('Stok bersih dari output proses Sorting');
            $table->decimal('graded_stock', 10, 2)->default(0)
                  ->comment('Stok grading dari output proses Grading');
            $table->timestamps();

            $table->index('seed_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seed_lots');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seed_lot_id')
                  ->constrained('seed_lots')
                  ->cascadeOnDelete();
            $table->string('process_type', 20)
                  ->default('Sorting')
                  ->comment('Sorting atau Grading');
            $table->foreignId('worker_id')
                  ->nullable()
                  ->constrained('workers')
                  ->nullOnDelete();
            $table->decimal('input_quantity', 10, 2)
                  ->comment('Jumlah benih masuk proses (kg)');
            $table->decimal('output_quantity', 10, 2)
                  ->comment('Jumlah benih keluar/hasil proses (kg)');
            $table->decimal('shrinkage_quantity', 10, 2)
                  ->default(0)
                  ->comment('Susut berat selama proses (kg)');
            $table->decimal('waste_quantity', 10, 2)
                  ->default(0)
                  ->comment('Limbah/reject dari proses (kg)');
            $table->date('processed_at')
                  ->nullable()
                  ->comment('Tanggal pelaksanaan proses');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('seed_lot_id');
            $table->index('worker_id');
            $table->index('process_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_processes');
    }
};

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
            $table->foreignId('seed_lot_id')->constrained('seed_lots')->cascadeOnDelete();
            $table->decimal('input_quantity', 10, 2);
            $table->decimal('output_quantity', 10, 2);
            $table->decimal('shrinkage_quantity', 10, 2)->default(0);
            $table->decimal('waste_quantity', 10, 2)->default(0);
            $table->decimal('moisture_start', 5, 2)->nullable();
            $table->decimal('moisture_end', 5, 2)->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('seed_lot_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_processes');
    }
};

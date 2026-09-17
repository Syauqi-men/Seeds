<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seed_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seed_lot_id')
                  ->constrained('seed_lots')
                  ->cascadeOnDelete();
            $table->date('mutated_at')->nullable()->comment('Tanggal pelaksanaan mutasi');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('seed_lot_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seed_mutations');
    }
};

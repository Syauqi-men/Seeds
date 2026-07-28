<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seed_lot_id')->constrained('seed_lots')->cascadeOnDelete();
            $table->decimal('germination_rate', 5, 2); // 0–100, validated in model/form
            $table->decimal('moisture_content', 5, 2)->nullable();
            $table->enum('test_result', ['PASSED', 'FAILED']); // manual admin input
            $table->date('tested_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('seed_lot_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};

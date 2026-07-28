<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seed_lot_id')->constrained('seed_lots')->cascadeOnDelete();
            $table->enum('transaction_type', ['IN', 'OUT', 'ADJUSTMENT']); // PRD §5.3
            $table->decimal('quantity', 10, 2);
            $table->string('reference_no')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('transacted_at')->nullable();
            $table->timestamps();

            $table->index('seed_lot_id');
            $table->index('transaction_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};

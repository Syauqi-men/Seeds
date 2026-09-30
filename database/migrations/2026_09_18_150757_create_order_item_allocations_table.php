<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_allocations', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('order_item_id')
                  ->constrained('order_items')
                  ->cascadeOnDelete();
                  
            $table->foreignId('seed_lot_id')
                  ->constrained('seed_lots')
                  ->restrictOnDelete();
                  
            $table->decimal('alloc_quantity', 10, 2)
                  ->comment('Jumlah yang dialokasikan dari lot ini');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_allocations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();
                  
            $table->foreignId('seed_id')
                  ->constrained('seeds')
                  ->restrictOnDelete();
                  
            $table->enum('seed_class', ['BS', 'FS', 'SS'])
                  ->comment('Kelas benih yang dipesan');
                  
            $table->decimal('quantity', 10, 2)
                  ->comment('Jumlah yang dipesan dalam kg');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

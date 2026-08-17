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
            $table->decimal('raw_stock', 10, 2)->default(0);
            $table->decimal('clean_stock', 10, 2)->default(0);
            $table->enum('status', ['Raw', 'Processing', 'Quarantine', 'Ready', 'Depleted'])->default('Raw');
            $table->timestamps();

            $table->index('seed_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seed_lots');
    }
};

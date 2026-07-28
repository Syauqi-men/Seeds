<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->string('var_name');
            $table->enum('var_class', ['NS', 'BS', 'FS', 'SS']);
            $table->enum('category', ['Kedelai', 'Kacang Tanah', 'Kacang Hijau']);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['var_name', 'category']);
            $table->index('category');
            $table->index('var_class');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seeds');
    }
};

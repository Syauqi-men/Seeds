<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seed_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nama kategori, mis. Kedelai');
            $table->string('abbr', 10)->nullable()->comment('Singkatan, mis. KDL');
            $table->string('description')->nullable()->comment('Keterangan tambahan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seed_categories');
    }
};

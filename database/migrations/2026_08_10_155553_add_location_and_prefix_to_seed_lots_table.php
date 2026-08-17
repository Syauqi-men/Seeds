<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seed_lots', function (Blueprint $table) {
            $table->string('location', 10)->nullable()->after('arrival_moisture')
                  ->comment('Alias lokasi: KP, JG, NG, MN, GT');
            $table->string('lot_code_prefix', 20)->default('KD-DP-NS')->after('location')
                  ->comment('Kode prefix lot, mis. KD-DP-NS');
        });
    }

    public function down(): void
    {
        Schema::table('seed_lots', function (Blueprint $table) {
            $table->dropColumn(['location', 'lot_code_prefix']);
        });
    }
};

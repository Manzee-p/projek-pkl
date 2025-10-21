<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 
     */
    public function up(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->string('kode_tiket', 30)
                  ->unique()
                  ->after('tiket_id')
                  ->comment('Kode unik tiket otomatis, contoh: TCK-20251017-0001');
        });
    }

    /**
     */
    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};

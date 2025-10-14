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
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // ID laporan otomatis
            $table->unsignedBigInteger('user_id');
            $table->string('judul');
            $table->string('kategori'); // bug, kerusakan, keluhan, dll
            $table->enum('prioritas', ['rendah','sedang','tinggi','urgent']);
            $table->text('deskripsi');
            $table->string('lampiran')->nullable(); // file opsional
            $table->timestamps();

            // foreign key
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

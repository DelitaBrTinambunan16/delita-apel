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
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengubah kolom gender yang sudah ada.
            // Di sini, saya asumsikan Anda ingin mempertahankan tipe enum
            // tetapi mungkin ingin mengubah nilainya, atau hanya membuatnya NOT NULL
            // Jika Anda hanya ingin mengubah opsi enum:
            $table->enum('gender', ['Pria', 'Wanita', 'Lain-lain'])
                  ->nullable() // Tetap opsional seperti sebelumnya
                  ->change();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan perubahan pada kolom gender jika rollback dilakukan
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengembalikan ke definisi awal
            $table->enum('gender', ['Male', 'Female', 'Other'])
                  ->nullable()
                  ->change();
        });
    }
};

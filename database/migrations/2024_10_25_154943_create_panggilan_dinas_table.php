<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_panggilan_dinas', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by');
            $table->date('tanggal_panggil');
            $table->text('catatan')->nullable();
            $table->foreignId('permohonan_id')
                         ->constrained('permohonan')
                         ->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panggilan_dinas');
    }
};

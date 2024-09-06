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
        Schema::create('riwayat_permohonan_diteruskan', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('diteruskan_ke')->nullable();
            $table->string('opsi')->nullable();
            $table->string('status')->nullable();
            $table->string('dokumen_terlampir')->nullable();
            $table->text('alasan_penolakan')->nullable();
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
        Schema::dropIfExists('riwayat_permohonan_diteruskan');
    }
};

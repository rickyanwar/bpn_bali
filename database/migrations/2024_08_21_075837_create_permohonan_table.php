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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('di_305');
            $table->string('di_302');
            $table->date('tanggal_pengukuran');
            $table->string('no_surat');
            $table->string('nama_pemohon');
            $table->string('no_berkas');
            $table->string('kecamatan');
            $table->string('desa');
            $table->integer('luas');
            $table->string('status');
            $table->string('jenis_permohonan');
            $table->integer('created_by');
            $table->integer('diteruskan_ke')->nullable();
            $table->string('diteruskan_ke_role')->nullable();
            $table->text('note')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};

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
        Schema::table('permohonan', function (Blueprint $table) {
            $table->text('catatan_penerusan')->nullable();
            $table->text('status_panggil')->nullable();
            $table->date('tgl_panggilan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn('catatan_penerusan');
            $table->dropColumn('status_panggil');
            $table->dropColumn('tgl_panggilan');
        });
    }
};

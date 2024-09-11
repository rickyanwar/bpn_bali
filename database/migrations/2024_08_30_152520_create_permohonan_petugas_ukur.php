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
        Schema::create('permohonan_petugas_ukur', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_id')
                         ->constrained('permohonan')
                         ->onDelete('cascade');
            $table->integer('petugas_ukur');
            $table->integer('pendamping');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_petugas_ukur');
    }
};

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
            $table->string('jadwal_pengukuran')->nullable()->after('di_302');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('permohonan', function (Blueprint $table) {
        //     $table->dropColumn('jadwal_pengukuran');
        // });
    }
};

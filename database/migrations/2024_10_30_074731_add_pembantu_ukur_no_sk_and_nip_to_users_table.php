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

        Schema::table('users', function (Blueprint $table) {
            $table->string('pembantu_ukur_no_sk')->nullable()->after('pembantu_ukur_nik'); // Replace 'last_column_name' with the column after which you want to add `pembantu_ukur_no_sk`
            $table->string('nip')->nullable()->after('pembantu_ukur_no_sk');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pembantu_ukur_no_sk', 'nip']);
        });

    }
};

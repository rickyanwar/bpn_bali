<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement("
        CREATE VIEW view_permohonan AS
SELECT
    p.id AS id,
    p.no_surat,
    p.no_berkas,
    p.nama_pemohon,
    p.kecamatan,
    p.desa,
    p.luas,
    p.jenis_kegiatan,
    p.diteruskan_ke,
    p.tanggal_mulai_pengukuran,
    p.tanggal_berakhir_pengukuran,
    p.status,
    p.created_by,
    -- Subquery to get latest diteruskan_ke_id and related user name
    (SELECT riwayat.diteruskan_ke
     FROM riwayat_permohonan_diteruskan AS riwayat
     WHERE riwayat.permohonan_id = p.id
     ORDER BY riwayat.created_at DESC
     LIMIT 1) AS latest_diteruskan_ke_id,
    (SELECT u.name
     FROM riwayat_permohonan_diteruskan AS riwayat
     JOIN users AS u ON riwayat.diteruskan_ke = u.id
     WHERE riwayat.permohonan_id = p.id
     ORDER BY riwayat.created_at DESC
     LIMIT 1) AS riwayat_diteruskan_ke_latest,
    (SELECT riwayat.diteruskan_ke_role
     FROM riwayat_permohonan_diteruskan AS riwayat
     WHERE riwayat.permohonan_id = p.id
     ORDER BY riwayat.created_at DESC
     LIMIT 1) AS latest_diteruskan_ke_role,
    (SELECT u.name
     FROM permohonan_petugas_ukur AS pu
     JOIN users AS u ON pu.petugas_ukur = u.id
     WHERE pu.permohonan_id = p.id
     LIMIT 1) AS petugas_ukur_utama,
    -- Computed column for perlu_diteruskan
    CASE
        WHEN p.status = 'selesai' THEN false
        ELSE
            CASE
                -- Check for Indah Corry and Priskha Primamayanti
                WHEN (SELECT riwayat.diteruskan_ke
                      FROM riwayat_permohonan_diteruskan AS riwayat
                      WHERE riwayat.permohonan_id = p.id
                      ORDER BY riwayat.created_at DESC
                      LIMIT 1) IN (
                      SELECT u.id
                      FROM users u
                      WHERE u.name IN ('Indah Corry', 'Priskha Primamayanti')
                    )
                THEN false
                ELSE
                    CASE
                        -- Determine whether to use tanggal_mulai_pengukuran or riwayat.created_at
                        WHEN (SELECT riwayat.diteruskan_ke_role
                              FROM riwayat_permohonan_diteruskan AS riwayat
                              WHERE riwayat.permohonan_id = p.id
                              ORDER BY riwayat.created_at DESC
                              LIMIT 1) = 'Petugas Ukur'
                        THEN
                            CASE
                                WHEN DATE(p.tanggal_mulai_pengukuran) < CURDATE() - INTERVAL 3 DAY THEN true
                                ELSE false
                            END
                        ELSE
                            CASE
                                WHEN (SELECT riwayat.created_at
                                      FROM riwayat_permohonan_diteruskan AS riwayat
                                      WHERE riwayat.permohonan_id = p.id
                                      ORDER BY riwayat.created_at DESC
                                      LIMIT 1) < CURDATE() - INTERVAL 2 DAY THEN true
                                ELSE false
                            END
                    END
                    END
                END AS perlu_diteruskan
            FROM permohonan p;

        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        DB::statement("DROP VIEW IF EXISTS view_permohonan");

    }
};

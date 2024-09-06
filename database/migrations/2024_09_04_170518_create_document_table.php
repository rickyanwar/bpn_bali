<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Documents;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Documents::create(
            [
            'nama_dokumen' => 'Surat Pemberitahuan Pengukuran Bidang Tanah',
            ],
        );

        Documents::create(
            [
                    'nama_dokumen' => 'Surat Tugas Pengukuran',
                    ],
        );


        Documents::create(
            [
                    'nama_dokumen' => 'Lampiran Surat Tugas Pengukuran',
                    ],
        );

        Documents::create(
            [
                    'nama_dokumen' => 'Surat Perintah Kerja',
                    ],
        );

        Documents::create(
            [
                    'nama_dokumen' => 'Dokumen Register Pengukuran',
                    ],
        );

        Documents::create(
            [
                    'nama_dokumen' => 'Register Setor Berkas',
                    ],
        );

    }
}

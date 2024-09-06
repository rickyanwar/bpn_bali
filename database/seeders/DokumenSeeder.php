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
            'nama_dokumen' => 'Surat Pengukuran',
            ],
        );

        Documents::create(
            [
                    'nama_dokumen' => 'Surat Tugas Pembantu Ukur',
                    ],
        );


        Documents::create(
            [
                    'nama_dokumen' => 'Surat Tugas Pembantu Ukur',
                    ],
        );


    }
}

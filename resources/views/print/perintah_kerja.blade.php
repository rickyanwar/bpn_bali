@extends('layouts.print')
@section('content')
    @php

        function monthToRoman($month)
        {
            $romanMonths = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII',
            ];

            return $romanMonths[intval($month)] ?? '';
        }
    @endphp
    <style>
        table.table-no-padding {
            margin-top: 10px;
            vertical-align: top;
        }

        table.table-no-padding td {
            padding: 0px !important;
        }

        .custom-list {
            list-style-type: none;
            /* Remove default list styling */
            counter-reset: list-counter;
            /* Initialize counter */
        }

        .custom-list li {
            counter-increment: list-counter;
            /* Increment counter for each <li> */
            position: relative;
        }

        .custom-list li::before {
            content: counter(list-counter, lower-alpha) ") ";
            /* Set format a) b) c) */
            position: absolute;
            left: -20px;
            /* Adjust the left margin if needed */
        }
    </style>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td style="width: 100px; vertical-align: middle;">
                        <img src="{{ public_path('assets/images/logo_bpn.png') }}" alt="Logo" style="max-width: 100px;">
                    </td>
                    <td style="text-align: center; vertical-align: middle; padding-bottom:0px">
                        <h3 style="margin: 0;font-size:20px;">
                            KEMENTRIAN AGRARIA DAN TATA RUANG /<br>BADAN PERTANAHAN NASIONAL <br>KANTOR PERTANAHAN
                            KABUPATEN TABANAN
                        </h3>
                        <p style="font-size:12px;margin: 0; font-family: 'cambria', sans-serif; margin-top:0px">JALAN PULAU
                            SERIBU
                            NO. 16
                            TABANAN Telp.
                            0361-811573</p>
                        <hr>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content" style="padding-left: 13%;
            padding-right: 6%;">
            <div class="text-center">
                <u>
                    <h3 class="mb-0 no-margin" style="font-family: Arial, sans-serif; font-weight:normal">SURAT PERINTAH
                        KERJA
                    </h3>
                </u>
                <p class="no-margin">Nomor : {{ $data->no_surat_perintah_kerja ?? '' }}</p>
            </div>
            <p style="text-align: justify">
                Berdasarkan Nota Dinas Kepala Seksi Survei dan Pemetaan
                No.
                /ND.51.02.3/{{ monthToRoman(\Carbon\Carbon::parse($data->created_at)->format('m')) }}/{{ \Carbon\Carbon::parse($data->created_at)->format('Y') }}
                Tanggal {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}.
                Perihal Penyampaian Daftar Pekerjaan Pengukuran dan Pemetaan Kantor Pertanahan Kabupaten Tabanan yang akan
                dilaksanakan oleh Surveyor Kadaster yang bertandatangan dibawah ini Kepala Kantor Pertanahan Kabupaten
                Tabanan dengan ini memerintahkan kepada :
            </p>
            @php
                $firstPetugas = $data->petugasUkur->first();
            @endphp

            <table class="table-no-padding">
                <tr>
                    <td width="30%">1) <span style="display: inline-block; width: 20px;"></span> Nama</td>
                    <td width="1%">:</td>
                    <td>{{ $firstPetugas->petugas->name }}</td>
                </tr>
                <tr>
                    <td width="30%">2) <span style="display: inline-block; width: 20px;"></span> Pekerjaan</td>
                    <td width="1%">:</td>
                    <td>{{ $firstPetugas->petugas->jabatan }}</td>
                </tr>
                <tr>
                    <td width="30%">3) <span style="display: inline-block; width: 20px;"></span> No SK / NIP</td>
                    <td width="1%">:</td>
                    <td></td>
                </tr>
                <tr>
                    <td width="30%">4) <span style="display: inline-block; width: 20px;"></span> Untuk Melaksanakan </td>
                    <td width="1%">:</td>
                    <td>Pengukuran dan Pemetaan</td>
                </tr>
                <tr>
                    <td width="30%">5) <span style="display: inline-block; width: 23px;"></span>Beban Biaya </td>
                    <td width="1%">:</td>
                    <td>Rp.</td>
                </tr>
                <tr>
                    <td width="30%">6) <span style="display: inline-block; width: 20px;"></span> Besar Biaya </td>
                    <td width="1%">:</td>
                    <td>Rp.</td>
                </tr>
                <tr>
                    <td width="30%">7) <span style="display: inline-block; width: 20px;"></span> Waktu Pelaksanaan </td>
                    <td width="1%">:</td>
                    <td width>{{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="width: 80%; vertical-align: top;">8) <span
                            style="display: inline-block; width: 20px;"></span> Hasil Pekerjaan yang harus diserahkan:</td>

                </tr>

            </table>

            <ol type="a" class="no-margin custom-list" style="margin-left: 60px">
                <li>Gambar Ukur;</li>
                <li>Pengolahan data dan Penggambaran;</li>
                <li>Berita Acara Penyelesian Pekerjaan;</li>
                <li>Berita Acara Serah Terima Pekerjaan.</li>
            </ol>
            <p>Demikian untuk dilaksanakan sesuai ketentuan yang berlaku</p>
            <div style="margin-top: 2rem !important;">
                <p class="text-center">Tabanan,
                    {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->subDay()->translatedFormat('d F Y') }}
                </p>
                <p class="text-center">Atas Nama Kepala Kantor Pertanahan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                    Kepala Seksi Survei dan Pemetaan</p>

                <p class="text-center" style="opacity: 0.5; margin:20px">Ditandatangani Secara <br>
                    Elektronik
                </p>

                <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 197704241999031002</p </div>
            </div>
        </div>
    </div>
@endsection

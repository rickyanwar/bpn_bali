@extends('layouts.print')
@section('content')
    <style>
        table.table-no-padding {
            margin-top: 10px;
            vertical-align: top;
        }

        table.table-no-padding td {
            padding: 0px !important;
        }
    </style>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td style="width: 100px; vertical-align: middle;">
                        <img src="{{ public_path('assets/images/logo_bpn.png') }}" alt="Logo" style="max-width: 100px;">
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <h3 style="margin: 0; font-family: 'cambria', sans-serif; font-size:20px">
                            KEMENTRIAN AGRARIA DAN TATA RUANG/<br>BADAN PERTANAHAN NASIONAL <br>KANTOR PERTANAHAN
                            KABUPATEN TABANAN
                        </h3>
                    </td>
                </tr>
            </table>
            <p style="font-size:12px;margin: 0; font-family: 'cambria', sans-serif;">JALAN PULAU SERIBU NO. 16 TABANAN
                Telp. 0361-811573</p>
            <hr>
        </div>
        <div class="text-center">
            <u>
                <h3 class="mb-0 no-margin">Surat Perintah Kerja</h3>
            </u>
            <p class="no-margin">Nomor : {{ $data->no_surat_perintah_kerja ?? '' }}</p>
        </div>
        <p>
            Berdasarkan Nota Dinas Kepala Seksi Survei dan Pemetaan No. /ND.51.02.3/ VI/2024 Tanggal 03 Juli 2024.
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
                <td width="5%">:</td>
                <td>{{ $firstPetugas->petugas->name }}</td>
            </tr>
            <tr>
                <td width="30%">2) <span style="display: inline-block; width: 20px;"></span> Pekerjaan</td>
                <td width="5%">:</td>
                <td></td>
            </tr>
            <tr>
                <td width="30%">3) <span style="display: inline-block; width: 20px;"></span> No SK NIP</td>
                <td width="5%">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td width="30%">4) <span style="display: inline-block; width: 20px;"></span> Untuk Melaksanakan </td>
                <td width="5%">:</td>
                <td>Pengukuran dan Pemetaan</td>
            </tr>
            <tr>
                <td width="30%">5) <span style="display: inline-block; width: 23px;"></span>Beban Biaya </td>
                <td width="5%">:</td>
                <td>Rp.</td>
            </tr>
            <tr>
                <td width="30%">6) <span style="display: inline-block; width: 20px;"></span> Besar Biaya </td>
                <td width="5%">:</td>
                <td>Rp.</td>
            </tr>
            <tr>
                <td width="30%">7) <span style="display: inline-block; width: 20px;"></span> Waktu Pelaksanaan </td>
                <td width="5%">:</td>
                <td width>{{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="width: 80%; vertical-align: top;">8) <span
                        style="display: inline-block; width: 20px;"></span> Hasil Pekerjaan yang harus diserahkan:</td>

            </tr>

        </table>

        <ol type="a" class="no-margin" style="margin-left: 60px">
            <li>Gambar Ukur</li>
            <li>Pengolahan data dan penggambaran</li>
            <li>Berita Acara Penyelesian Pekerjaan</li>
            <li>Berita Acara Serah Terima Pekerjaan</li>
        </ol>
        <p>Demikian untuk di laksanakan sesuai ketentuan yang berlaku</p>
        <div class="mt-5">
            <p class="text-center">Tabanan,
                {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</p>
            <p class="text-center">Atas Nama kepala kantor pertahanan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                Kepala Seksi Survei dan Pemetaan</p>
            <br>
            <br>

            <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 182736263738272839</p </div>
        </div>
    </div>
@endsection

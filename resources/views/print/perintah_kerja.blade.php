@extends('layouts.print')
@section('content')
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo_bpn.png') }}" alt="Logo">
            <!-- Replace with the actual logo path -->
            <div>
                <h2>KEMENTRIAN AGRARIA DAN TATA RUANG/ BADAN PERTANAHAN NASIONAL<br>
                    KANTOR PERTANAHAN KABUPATEN TABANAN</h2>
                <p>JALAN PULAU SERIBU NO. 16 TABANAN Telp. 0361-811573</p>
            </div>
        </div>
        <div class="text-center">
            <u>
                <h3 class="mb-0">Perintah Kerja</h3>
            </u>
            <p class="no-margin">Nomor : {{ $data->no_surat }}</p>
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
                <td width="30%">1) Nama</td>
                <td width="5%">:</td>
                <td>{{ $firstPetugas->petugas->name }}</td>
            </tr>
            <tr>
                <td width="15%">2) Pekerjaan</td>
                <td width="5%">:</td>
                <td></td>
            </tr>
            <tr>
                <td width="15%">3) No SK NIP</td>
                <td width="5%">:</td>
                <td>-</td>
            </tr>
            <tr>
                <td width="15%">4) Untuk Melaksanakan </td>
                <td width="5%">:</td>
                <td>Pengukuran dan Pemetaan</td>
            </tr>
            <tr>
                <td width="15%">5) Beban Biaya </td>
                <td width="5%">:</td>
                <td>Rp.</td>
            </tr>
            <tr>
                <td width="15%">6) Besar Biaya </td>
                <td width="5%">:</td>
                <td>Rp.</td>
            </tr>
            <tr>
                <td width="15%">7) Waktu Pelaksanaan </td>
                <td width="5%">:</td>
                <td>{{ $data->tanggal_mulai_pengukuran }}</td>
            </tr>
            <tr>
                <td width="15%">8) Hasil Pekrjaan yang harus di serahkan </td>
                <td width="5%">:</td>
                <td>
                    <br>
                    <br>
                    <ol type="a">
                        <li>Gambar Ukur</li>
                        <li>Pengolahan data dan penggambaran</li>
                        <li>Berita Acara Penyelesian Pekerjaan</li>
                        <li>Berita Acara Serah Terima Pekerjaan</li>
                    </ol>
                </td>
            </tr>
        </table>
        <p>Demikian untuk di laksanakan sesuai ketentuan yang berlaku</p>
        <div class="mt-5">
            <p class="text-center">Tabanan, {{ $data->tanggal_mulai_pengukuran }}</p>
            <p class="text-center">Atas Nama kepala kantor pertahanan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                Kepala Seksi Survei dan Pemetaan</p>
            <br>
            <br>

            <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 182736263738272839</p </div>
        </div>
    </div>
@endsection

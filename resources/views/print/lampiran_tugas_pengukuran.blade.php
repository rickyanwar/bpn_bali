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
        <h3 style="text-align: center;">LAMPIRANSURAT TUGAS PENGUKURAN</h3>
        <p style="text-align: center;">Nomor : {{ $data->no_surat }}</p>

        <p>Dengan ini kepala kantor mengugaskan kepada</p>
        <ol>
            <li>Pembantu Ukur : </li>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Nama </th>
                    <th>Keterangan</th>
                </tr>
                @foreach ($data->petugasUkur as $petugas)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $petugas->pembantu_ukur }}</td>
                        <td>Pembantu Ukur</td>
                    </tr>
                @endforeach
            </table>
            <li class="mt-1">Lokasi Kegiatan: </li>
            <table class="table-no-padding">

                <tr>
                    <td width="15%">a. Kelurahan</td>
                    <td width="5%">:</td>
                    <td>{{ $data->desa }}</td>
                </tr>
                <tr>
                    <td width="15%">b. Kecamatan</td>
                    <td width="5%">:</td>
                    <td>{{ $data->kecamatan }}</td>
                </tr>
                <tr>
                    <td width="15%">c. Volume</td>
                    <td width="5%">:</td>
                    <td>{{ $data->luas }} m2</td>
                </tr>
            </table>
            <li class="mt-1">Waktu: </li>
            <table class="table-no-padding">

                <tr>
                    <td width="20%">a. Mulai Tanggal</td>
                    <td>:</td>
                    <td>{{ $data->tanggal_mulai_pengukuran }}</td>
                </tr>
                <tr>
                    <td width="20%">b. Tanggal Selesai</td>
                    <td>:</td>
                    <td>{{ $data->tanggal_berakhir_pengukuran }}</td>
                </tr>

            </table>
            <li class="mt-1">Biaya Di bebankan pada: </li>
            <table class="table-no-padding">

                <tr>
                    <td width="20%">a. DI 304</td>
                    <td>:</td>
                    <td>{{ $data->di_305 }}</td>
                </tr>
                <tr>
                    <td width="20%">b. DI 302</td>
                    <td>:</td>
                    <td>{{ $data->di_302 }}</td>
                </tr>

            </table>
            <li class="mt-1">Hasil Pelaksanaan Tugas supaya dilaporkan: </li>
            <p>Demikian Surat Tugas ini dibuat untuk di laksanakan dengan penuh tangung jawab dan di pergunakan
                sebagimana mestinya</p>
        </ol>
        <div class="row">
            <div class="col-6">
            </div>
            <div class="col-6">
                <table>

                    <tr>
                        <td width="30%">Di Keluarkan di</td>
                        <td>:</td>
                        <td>{{ $data->desa }}</td>
                    </tr>
                    <tr>
                        <td width="40%">Pada Tanggal</td>
                        <td>:</td>
                        <td>{{ $data->tanggal_mulai_pengukuran }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p>Bahwa benar Petugas Ukur telah datang ke lokasi <br> Pada Tanggal
                </p>
            </div>
            <div class="col-6">
                <p class="text-center">Atas kepala kantor pertahanan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                    Kepala Seksi Survei dan Pemetaan</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <p>Mengetahui Kepala Desa</p>
            </div>
            <div class="col-6">
                <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 182736263738272839</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{ $qrCode }}
            </div>
        </div>
    </div>
@endsection

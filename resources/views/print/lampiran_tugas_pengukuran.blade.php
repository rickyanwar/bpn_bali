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
        <h3 class="text-center no-margin">LAMPIRAN SURAT TUGAS PENGUKURAN</h3>
        <p class="text-center no-margin">Nomor : {{ $data->no_surat }}</p>

        <div class="content">
            <p>Dengan ini kepala kantor mengugaskan kepada</p>
            <ol>
                <li>Pembantu Ukur : </li>
                <table border="1">
                    <tr>
                        <th>No.</th>
                        <th>Nama </th>
                        <th>NIK</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach ($data->petugasUkur as $petugas)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $petugas->pembantu_ukur ?? '' }}</td>
                            <td>{{ $petugas->pembantu_ukur_nik ?? '' }}</td>
                            <td>Pembantu Ukur</td>
                        </tr>
                    @endforeach
                </table>
                <li class="mt-1">Lokasi Kegiatan: </li>
                <table class="table-no-padding" style="margin-top:0px">
                    <tr>
                        <td width="21%">a. Kelurahan</td>
                        <td width="1%">:</td>
                        <td>{{ $data->desa }}</td>
                    </tr>
                    <tr>
                        <td width="21%">b. Kecamatan</td>
                        <td width="1%">:</td>
                        <td>{{ $data->kecamatan }}</td>
                    </tr>
                    <tr>
                        <td width="21%">c. Volume</td>
                        <td width="1%">:</td>
                        <td>{{ $data->luas }} m2</td>
                    </tr>
                </table>
                <li class="mt-1">Waktu: </li>
                <table class="table-no-padding" style="margin-top:0px">

                    <tr>
                        <td width="21%">a. Mulai Tanggal</td>
                        <td width="1%">:</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td width="21%">b. Tanggal Selesai</td>
                        <td width="1%">:</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal_berakhir_pengukuran)->translatedFormat('d F Y') }}</td>
                    </tr>

                </table>
                <li class="mt-1">Biaya dibebankan pada: </li>
                <table class="table-no-padding" style="margin-top:0px">

                    <tr>
                        <td width="21%">a. DI 304</td>
                        <td width="1%">:</td>
                        <td>{{ $data->di_305 }}</td>
                    </tr>
                    <tr>
                        <td width="21%">b. DI 302</td>
                        <td width="1%">:</td>
                        <td>{{ $data->di_302 }}</td>
                    </tr>

                </table>
                <li class="mt-1">Hasil Pelaksanaan Tugas supaya dilaporkan: </li>
                <p style="margin:0px">Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab
                    dan dipergunakan sebagaimana mesti nya.</p>
            </ol>
            <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                    <table>
                        <tr>
                            <td class="no-padding">Dikeluarkan</td>
                            <td class="no-padding">: TABANAN</td>
                        </tr>
                        <tr>
                            <td class="no-padding">Pada Tanggal</td>
                            <td class="no-padding">:
                                {{ \Carbon\Carbon::parse($data->updated_at)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    </table>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p>Bahwa benar Petugas Ukur telah datang ke lokasi <br> Pada Tanggal
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-center">Atas Nama Kepala Kantor Pertanahan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                        Kepala Seksi Survei dan Pemetaan</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <p>Mengetahui Kepala Desa {{ $data->desa }}</p>
                </div>
                <div class="col-6">
                    <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 197704241999031002</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.print')
@section('content')
    <div class="container">
        <div id="content-to-print">
            <div class="header">
                <table>
                    <tr>
                        <td style="width: 100px; vertical-align: middle;">
                            <img src="{{ public_path('assets/images/logo_bpn.png') }}" alt="Logo"
                                style="max-width: 100px;">
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

            <div class="content">
                <div class="info-surat mt-1">
                    <div class="row" style="text-align: left;">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>{{ $data->no_surat }}</td>
                                </tr>
                                <tr>
                                    <td>Lampiran</td>
                                    <td>:</td>
                                    <td>{{ $data->lampiran }}</td>
                                </tr>
                                <tr>
                                    <td>Perihal</td>
                                    <td>:</td>
                                    <td>
                                        <p>Pemberitahuan akan dilaksanakan pengukuran Bidang Tanah</p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-6">
                            <table>
                                <tr>
                                    <td>Tabanan</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Kepada</td>
                                    <td>:</td>
                                    <td> Yth- {{ $data->nama_pemohon }} <br> di - {{ $data->desa }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Main Paragraph, now spans full width -->

                <p style="width: 100%; clear: both; margin-top: 10px; word-break: break-word;">
                    <span style="display: inline-block; width: 20px;"></span>
                    Sehubungan dengan Permohonan Pendaftaran Hak Atas Tanah Sdr {{ $data->nama_pemohon }}
                    Kec {{ $data->kecamatan }}<br>
                    Tanggal {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d-m-Y') }} dengan
                    Daftar Isian 302: {{ $data->di_302 }},
                    Desa {{ $data->desa }} Kab Tabanan,
                    Dengan ini kami beritahukan bahwa pelaksanaan pengukuran batas bidang tanah akan dilaksanakan nanti
                    pada:
                </p>

                <div class="row">
                    <div class="col-8">
                        <table style="text-align: left">
                            <tr>
                                <td width="40%">Hari / Tanggal</td>
                                <td width="5%">:</td>
                                <td>{{ $data->tanggal_mulai_pengukuran }}</td>
                            </tr>
                            <tr>
                                <td>Pukul</td>
                                <td>:</td>
                                <td>09:00 Wita</td>
                            </tr>
                            @php
                                $firstPetugas = $data->petugasUkur[0];
                            @endphp
                            <tr>
                                <td>Petugas Ukur</td>
                                <td>:</td>
                                <td>{{ $firstPetugas->petugas->name }} / {{ $firstPetugas->petugas->no_hp ?? '-' }}
                                    08593436423421</td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-4">
                        <img src="data:image/png;base64, {!! $qrCode !!}" alt="qr" style="max-width: 70px;" />
                    </div>
                </div>
                <p style="width: 100%; clear: both; word-break: break-word;">
                    Dimohon agar Sdr memberitahukan dan mengundang para penyanding (wajib), dan Aparat Desa
                    (apabila diperlukan) untuk hadir pada saat pengukuran. Hal ini untuk memenuhi ketentuan
                    pasal 18 ayat (2) Peraturan pemerintah Nomor 24 tahun 1997 yo pasal 19 PMNA/Ka BPN No.3/1997.
                </p>

                <!-- Signature Section -->
                <div class="row">
                    <div class="col-6">
                        <p class="text-center">Demikian untuk menjadi perhatiannya</p>
                    </div>
                    <div class="col-6 mt-5">
                        <p class="text-center">An. Kepala Kantor Pertanahan <br> Kabupaten Tabanan <br>
                            Kepala Seksi
                            Survei dan Pemetaan</p>
                        <br><br><br>
                        <p class="text-center"><u>DARMANSYAH, S.ST., M.H</u> <br> NIP. 197704241999031002</p>
                    </div>
                </div>

                <!-- Tembusan Section -->
                <div style="width: 100%; clear: both; margin-top: 10px; word-break: break-word;">
                    <p>Tembusan disampaikan kepada YTH:</p>
                    <ol>
                        <li>Sdr Perbekel {{ $data->desa }} </li>
                        <li>Sdr {{ $data->nama_pemohon }}</li>
                    </ol>
                    <p>Tempat Menunggu: Kantor Desa {{ $data->desa }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

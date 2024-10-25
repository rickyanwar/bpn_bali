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
                                KEMENTRIAN AGRARIA DAN TATA RUANG /<br>BADAN PERTANAHAN NASIONAL <br>KANTOR PERTANAHAN
                                KABUPATEN TABANAN <br> PROVINSI BALI
                            </h3>
                        </td>
                    </tr>
                </table>
                <p style="font-size:12px;margin: 0; font-family: 'cambria', sans-serif;">Jalan Pulau Seribu No.16 Tabanan,
                    Kode Pos. 8211, Tip. 0361-811573, Email: kantah tabanan@yahoo.co.id</p>
                <hr>
            </div>

            <div class="content">
                <div class="info-surat mt-1">
                    <div class="row" style="text-align: left;">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td width="20%">Nomor</td>
                                    <td width="5%">:</td>
                                    <td>&nbsp;{{ $data->no_surat }}</td>
                                </tr>
                                <tr>
                                    <td>Lampiran</td>
                                    <td>:</td>
                                    <td>&nbsp;{{ $data->lampiran }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;">Perihal</td>
                                    <td style="vertical-align: top;"> :</td>
                                    <td>
                                        &nbsp;Pemberitahuan akan Dilaksanakan Pengukuran Bidang Tanah
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-6">
                            <table>
                                <tr>
                                    <td colspan="3"> Tabanan,
                                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td width="20%" style="vertical-align: top;">Kepada</td>
                                    <td width="5%" style="vertical-align: top;">:</td>
                                    <td style="margin-top:10px"> Yth. {{ $data->nama_pemohon }} <br> Di. </td>
                                </tr>
                                <tr>
                                    <td width="20%"></td>
                                    <td width="5%"></td>
                                    <td style="vertical-align: right;"> &nbsp; &nbsp; &nbsp;{{ $data->desa }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Main Paragraph, now spans full width -->

                <p
                    style="width:
                                        100%; clear: both; padding-top: 20px; word-break: break-word;">
                    <span style="display: inline-block; width: 20px;"></span>
                    Sehubungan dengan Permohonan Pendaftaran Hak Atas Tanah Sdr
                    {{ $data->nama_pemohon }}
                    Tanggal
                    {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d/m/Y') }}
                    dengan
                    Daftar Isian 302: {{ $data->di_302 }},
                    Desa {{ $data->desa }}, Kec {{ $data->kecamatan }}, Kab Tabanan,
                    Dengan ini kami beritahukan bahwa pelaksanaan pengukuran batas bidang tanah akan
                    dilaksanakan nanti
                    pada:
                </p>

                <div class="row">
                    <div class="col-8">
                        <table style="text-align: left">
                            <tr>
                                <td width="40%">Hari / Tanggal</td>
                                <td width="5%">:</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->locale('id')->translatedFormat('l, d F Y') }}
                                </td </tr>
                            <tr>
                                <td>Pukul</td>
                                <td>:</td>
                                <td>09.00 Wita</td>
                            </tr>
                            @php
                                $firstPetugas = $data->petugasUkur[0];
                            @endphp
                            <tr>
                                <td>Petugas Ukur</td>
                                <td>:</td>
                                <td>{{ $firstPetugas->petugas->name }} /
                                    {{ $firstPetugas->petugas->no_hp ?? '-' }}
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-2">
                        <img src="data:image/png;base64, {!! $qrCode !!}" alt="qr" style="max-width: 70px;" />
                    </div>
                </div>
                <p style="width: 100%; clear: both; word-break: break-word;">
                    Dimohon agar Sdr memberitahukan dan mengundang para penyanding (wajib), dan
                    Aparat Desa
                    (apabila diperlukan) untuk hadir pada saat pengukuran. Hal ini untuk memenuhi
                    ketentuan
                    pasal 18 ayat (2) Peraturan pemerintah Nomor 24 tahun 1997 yo pasal 19 PMNA/Ka
                    BPN No.3/1997.
                </p>

                <!-- Signature Section -->
                <div class="row">
                    <div class="col-6">
                        <p class="text-center">Demikian untuk menjadi perhatiannya</p>
                    </div>
                    <div class="col-6 " style="position: relative; margin-top:50px">
                        <p class="text-center">An. KEPALA KANTOR PERTANAHAN <br> KABUPATEN. TABANAN
                            <br>
                            KEPALA SEKSI SURVEI DAN PEMETAAN
                        </p>

                        <img src="{{ public_path('assets/images/signature-darmansyah.png') }}" alt="Signature"
                            style="width: 200px; position: absolute; margin: 0 auto; opacity: 0.3; right:15%;top:10%">

                        <br><br>
                        <br>


                        <p class="text-center"><u><b>DARMANSYAH, S.ST., M.H</b>
                            </u> <br> NIP.
                            197704241999031002</p>

                    </div>
                </div>

                <!-- Tembusan Section -->
                <div style="width: 100%; clear: both; margin-top: 10px; word-break: break-word;">
                    <p>Tembusan disampaikan kepada Yth:</p>
                    <ol>
                        <li>Sdr. Perbekel {{ $data->desa }} </li>
                        <li>Sdr. {{ $data->nama_pemohon }}</li>
                    </ol>
                    <p>Tempat Menunggu : </p>
                    <p>Kantor Desa : {{ $data->desa }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

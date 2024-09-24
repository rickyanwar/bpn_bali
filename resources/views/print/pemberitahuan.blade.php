@extends('layouts.print')
@section('content')
    <div class="container">
        <div id="content-to-print">
            <div class="header">
                <img src="{{ asset('assets/images/logo_bpn.png') }}" alt="Logo">
                <!-- Replace with the actual logo path -->
                <div>
                    <h2>KEMENTRIAN AGRARIA DAN TATA RUANG/ BADAN PERTANAHAN NASIONAL<br>
                        KANTOR PERTANAHAN KABUPATEN TABANAN</h2>
                    <p>JALAN PULAU SERIBU NO. 16 TABANAN Telp. 0361-811573</p>
                </div>
            </div>
            <div class="info-surat mt-1">
                <div class="row" style="text-align: left">
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
                                <td>{{ $data->no_surat }}</td>
                            </tr>
                            <tr>
                                <td>Perihal</td>
                                <td>:</td>
                                <td>-</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-6">
                        <table>
                            <tr>
                                <td>Tabanan</td>
                                <td>:</td>
                                <td>{{ $data->no_berkas }}</td>
                            </tr>

                            <tr>
                                <td>Kepada</td>
                                <td>:</td>
                                <td> Yth- {{ $data->nama_pemohon }} <br>
                                    di - {{ $data->desa }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="content">
                <p><span style="margin-left: 50px"></span>
                    Sehubungan dengan Permohonan Pendaftaran Hak Atas Tanah Sdr {{ $data->nama_pemohon }}
                    Kec {{ $data->kecamatan }} Tanggal, {{ $data->created_at }}
                    dengan Daftar Isian 302: {{ $data->di_302 }}
                    Desa {{ $data->desa }} Kab Tabanan, Dengan ini kami beritahukan bahwa
                    pelaksanaan pengukuran batas bidang tanah akan dilaksanakan nanti pada:
                </p>
                <table border="1" style="text-align: left">
                    <tr>
                        <td>Hari / Tanggal</td>
                        <td>:</td>
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
                        <td>{{ $firstPetugas->petugas->name }}</td>
                    </tr>
                </table>
                <p>
                    Dimohon agar Sdr memberitahukan dan mengundang para penyanding (wajib), dan
                    Aparat Desa (apabila diperlukan) untuk hadir pada saat pengukuran. Hal ini untuk memenuhi ketentuan
                    pasal 18 ayat (2) Peraturan pemerintah Nomor 24 tahun 1997 yo pasal 19 PMNA/Ka BPN No.3/1997.
                </p>


                <div class="row ">
                    <div class="col-6">
                        <p class="text-center">
                            Demikian Atas Perhatianya
                        </p>
                    </div>
                    <div class="col-6 mt-5">
                        <p class="text-center">An. Kepala Kantor Pertanahan Kabupaten Tabanan, Tabanan <br>
                            Kepala Seksi Survei dan Pemetaan</p>
                        <br>
                        <br>
                        <br>
                        <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 182736263738272839</p>
                    </div>
                </div>

                <div>

                    <p>Tembusan di sampikan kepada YTH</p>
                    <ol>
                        <li>Sdr Perbekel</li>
                        <li>Sdr</li>
                    </ol>
                    <p>Tempat Menunggu :</p>
                    <p>Kantor Desa : </p>
                </div>
                <div class="col-12">
                    {{ $qrCode }}
                </div>
            </div>
        </div>
    </div>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas Pengukuran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f4eb;
        }

        .container {
            width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-left: 30px;
            margin-right: 30px;
            text-align: center;
            color: #000000;
        }

        .header img {
            max-width: 100px;
            /* Adjust the size as needed */
            margin-right: 20px;
        }

        .header p {
            margin: -10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 1.5cm; */
        }

        td {
            padding: 5px;
        }

        .signature {
            margin-top: 2cm;
            margin-right: 30%;
            text-align: right;
        }


        .content {
            margin-left: 13%;
            margin-right: 7%;

        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            padding-left: 15%;
            padding-right: 5%;
        }

        .col {
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        /* Column sizes (like Bootstrap's col-1 to col-12 system) */
        .col-1 {
            flex: 0 0 8.33%;
            max-width: 8.33%;
        }

        .col-2 {
            flex: 0 0 16.66%;
            max-width: 16.66%;
        }

        .col-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }

        .col-4 {
            flex: 0 0 33.33%;
            max-width: 33.33%;
        }

        .col-5 {
            flex: 0 0 41.66%;
            max-width: 41.66%;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-7 {
            flex: 0 0 58.33%;
            max-width: 58.33%;
        }

        .col-8 {
            flex: 0 0 66.66%;
            max-width: 66.66%;
        }

        .col-9 {
            flex: 0 0 75%;
            max-width: 75%;
        }

        .col-10 {
            flex: 0 0 83.33%;
            max-width: 83.33%;
        }

        .col-11 {
            flex: 0 0 91.66%;
            max-width: 91.66%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Example styling for visualization */
        .box {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            text-align: center;
            padding: 20px;
            margin-bottom: 15px;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 6rem !important;
        }

        .mt-1 {
            margin-top: 1rem !important;
        }


        .info-surat td {
            padding: 0px;
        }
    </style>
</head>

<body>
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
        </div>
    </div>
</body>

</html>

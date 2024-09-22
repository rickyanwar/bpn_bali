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

        table.table-no-padding {
            margin-top: 10px;
        }

        table.table-no-padding td {
            padding: 0px !important;
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
                        <td>{{ $petugas->petugas_pendamping->name }}</td>
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
</body>

</html>

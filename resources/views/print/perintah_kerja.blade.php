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

        .mb-0 {
            margin-bottom: 0px !important;
        }


        .info-surat td {
            padding: 0px;
        }

        .no-padding {
            padding: 0px !important;
        }

        .no-margin {
            margin-bottom: 0px;
            margin-top: 0px;
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
</body>

</html>
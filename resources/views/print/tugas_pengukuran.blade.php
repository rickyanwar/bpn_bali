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
            width: 850px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .double {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
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
            margin-left: 15%;
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

        .left-column {
            width: 70%;
        }

        .right-column {
            width: 30%;
            text-align: center;
            /* border-left: 1px solid #ddd; */
            padding-left: 15px;
        }

        ul {
            list-style-type: lower-alpha;
            padding: 0;
        }

        li {
            margin-left: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Logo_BPN-KemenATR_%282017%29.png"
                alt="Logo">
            <!-- Replace with the actual logo path -->
            <div>
                <h2>KEMENTRIAN AGRARIA DAN TATA RUANG/ BADAN PERTANAHAN NASIONAL<br>
                    KANTOR PERTANAHAN KABUPATEN TABANAN</h2>
                <p>JALAN PULAU SERIBU NO. 16 TABANAN Telp. 0361-811573</p>
            </div>
        </div>

        <h3 style="text-align: center;">SURAT TUGAS PENGUKURAN</h3>
        <p style="text-align: center;">Nomor : {{ $data->no_surat }}</p>

        <div class="content">
            <p>Dengan ini Kepala Kantor menugaskan kepada:</p>

            <p>1. a. Petugas Ukur</p>
            <table border="1">
                <tr>
                    <th>No.</th>
                    <th>Nama / NIP</th>
                    <th>Pangkat / Golongan</th>
                    <th>Jabatan</th>
                </tr>
                @foreach ($data->petugasUkur as $petugas)
                    <tr>
                        <td>{{ $loop->iteration }}.</td>
                        <td>{{ $petugas->petugas->name }}</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endforeach
            </table>
            <div class="double">
                <div class="left-column">
                    <p>b. Dengan tugas ini untuk melaksanakan Pemecahan Bidang Lokasi dan Volume
                        Kegiatan:</p>
                    <ul>
                        <li>Kelurahan: <span class="highlight">{{ $data->desa }}</span></li>
                        <li>Kecamatan: <span class="highlight">{{ $data->kecamatan }}</span></li>
                        <li>Volume: <span class="highlight">{{ $data->luas }} m2</span></li>
                    </ul>

                    <p>2. Waktu:</p>
                    <ul>
                        <li>Mulai Tanggal: <span class="highlight">03 Juli 2024</span></li>
                        <li>Sampai Tanggal: <span class="highlight">03 Juli 2024</span></li>
                    </ul>

                    <p>3. Biaya dibebankan pada:</p>
                    <ul>
                        <li>DI 305: <span class="highlight">{{ $data->di_305 }}</span></li>
                        <li>DI 302: <span class="highlight">{{ $data->di_302 }}</span></li>
                    </ul>

                    <p>4. Hasil Pelaksanaan Tugas supaya dilaporkan.</p>

                    <p>Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab dan dipergunakan
                        sebagaimana mestinya.</p>
                </div>

                <div class="right-column">
                    <h4>Survey Kepuasan Layanan Pengukuran Bidang Tanah</h4>
                    <img src="https://pngimg.com/d/qr_code_PNG33.png" alt="QR Code" style="width:150px;">
                </div>
            </div>
            <p>KEMENTERIAN AGRARIA DAN TATA RUANG/BADAN PERTANAHAN NASIONAL<br>KANTOR PERTANAHAN KABUPATEN
                TABANAN</p>

        </div>


        <div class="signature">
            <p>Dikeluarkan di: TABANAN</p>
            <p>Pada Tanggal: {{ $data->tanggal_mulai_pengukuran }}</p>
        </div>

        <div class="row">
            <div class="col-6">
                <p>Bahwa benar Petugas Ukur telah datang ke lokasi <br> Pada Tanggal
                    {{ $data->tanggal_mulai_pengukuran }}</p>
            </div>
            <div class="col-6">
                <p class="text-center">Atas Nama Kepala Kantor Pertahanan <br> Kantor Pertanahan Kabupaten Tabanan <br>
                    Kepala Seksi Survei dan Pemetaan</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <p>Mengetahui <br> Nama Pemohon : NI WAYAN SURIANI</p>
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

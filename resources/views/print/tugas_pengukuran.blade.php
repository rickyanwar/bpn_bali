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

           <div class="text-center">
               <u>
                   <h3 class="mb-0 no-margin">SURAT TUGAS PENGUKURAN</h3>
               </u>
               <p class="no-margin">Nomor : {{ $data->no_surat }}</p>
           </div>
           <div class="content mt-1">
               <p>Dengan ini Kepala Kantor menugaskan kepada:</p>

               <p class="no-margin">1. a. Petugas Ukur</p>
               <table border="1" style="margin-bottom: 20px">
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
                           <td>{{ $petugas->petugas->golongan ?? '' }}</td>
                           <td>{{ $petugas->petugas->jabatan ?? '' }}</td>
                       </tr>
                   @endforeach
               </table>
               <div class="row">
                   <div class="col-6">
                       <p class="no-margin">b. Dengan tugas ini untuk melaksanakan Pemecahan Bidang Lokasi dan Volume
                           Kegiatan:</p>
                       <ol class="no-margin" type="a">
                           <li>Kelurahan: <span class="highlight">{{ $data->desa }}</span></li>
                           <li>Kecamatan: <span class="highlight">{{ $data->kecamatan }}</span></li>
                           <li>Volume: <span class="highlight">{{ $data->luas }} m2</span></li>
                       </ol>

                       <p class="no-margin">2. Waktu:</p>
                       <ol class="no-margin" type="a">
                           <li>Mulai Tanggal: <span class="highlight">03 Juli 2024</span></li>
                           <li>Sampai Tanggal: <span class="highlight">03 Juli 2024</span></li>
                       </ol>

                       <p class="no-margin">3. Biaya dibebankan pada:</p>
                       <ol class="no-margin" type="a">
                           <li>DI 305: <span class="highlight">{{ $data->di_305 }}</span></li>
                           <li>DI 302: <span class="highlight">{{ $data->di_302 }}</span></li>
                       </ol>
                       <p class="no-margin">4. Hasil Pelaksanaan Tugas supaya dilaporkan.</p>

                   </div>
                   {{--  <div class="col-6">
                       <h4>Survey Kepuasan Layanan Pengukuran Bidang Tanah</h4>
                       <img src="https://pngimg.com/d/qr_code_PNG33.png" alt="QR Code" style="width:150px;">
                   </div>
                   <p class="no-margin" style="">KEMENTERIAN AGRARIA DAN TATA RUANG/BADAN PERTANAHAN
                       NASIONAL<br>KANTOR PERTANAHAN KABUPATEN
                       TABANAN</p>  --}}
                   <div class="col-6">
                       <img src="{{ public_path('assets/images/qr-kepuasan.png') }}" alt="qr"
                           style="max-width: 300px;">
                   </div>
               </div>
               <p style="width: 100%; clear: both; word-break: break-word;">Demikian Surat Tugas ini dibuat untuk
                   dilaksanakan dengan penuh tanggung jawab dan dipergunakan
                   sebagaimana mestinya.</p>

               <div class="row">
                   <div class="col-6"></div>
                   <div class="col-6">
                       <p class="no-margin">Dikeluarkan di: TABANAN</p>
                       <p class="no-margin">Pada Tanggal:
                           {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}
                       </p>
                   </div>
               </div>
               <div class="row">
                   <div class="col-6">
                       <p>Bahwa benar Petugas Ukur telah datang ke lokasi <br> Pada Tanggal
                           {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</p>
                   </div>
                   <div class="col-6">
                       <p class="text-center">Atas Nama Kepala Kantor Pertahanan <br> Kantor Pertanahan Kabupaten Tabanan
                           <br>
                           Kepala Seksi Survei dan Pemetaan
                       </p>
                   </div>
               </div>
               <div class="row mt-5">
                   <div class="col-6">
                       <p>Mengetahui <br> Nama Pemohon : {{ $data->nama_pemohon }}</p>
                   </div>
                   <div class="col-6">
                       <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 182736263738272839</p>
                   </div>
               </div>
           </div>



       </div>
   @endsection

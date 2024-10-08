   @extends('layouts.print')
   @section('content')
       <div class="container">
           <style>
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

               .double {
                   display: flex;
                   justify-content: space-between;
                   margin-top: 20px;
               }
           </style>
           <div class="header">
               <img src="{{ asset('assets/images/logo_bpn.png') }}" alt="Logo">
               <!-- Replace with the actual logo path -->
               <div class="header-content">
                   <h3 class="">KEMENTRIAN AGRARIA DAN TATA RUANG/ BADAN PERTANAHAN NASIONAL<br>
                       KANTOR PERTANAHAN KABUPATEN TABANAN</h3>
                   <p style="font-size:12px">JALAN PULAU SERIBU NO. 16 TABANAN Telp. 0361-811573</p>
               </div>
           </div>

           <h3 style="text-align: center; margin-bottom: 0px">SURAT TUGAS PENGUKURAN</h3>
           <p class="m-0" style="text-align: center;margin-b">Nomor : {{ $data->no_surat }}</p>

           <div class="content mt-1">
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
                   <p>KEMENTERIAN AGRARIA DAN TATA RUANG/BADAN PERTANAHAN NASIONAL<br>KANTOR PERTANAHAN KABUPATEN
                       TABANAN</p>
               </div>


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
       </div>
   @endsection

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

           .label {
               display: inline-block;
               width: 100px;
               /* Adjust this width to fit your labels */
               margin-right: 10px;
               /* Adjust space between label and value */
           }

           .label-space {
               display: inline-block;
               width: 110px;
               /* Adjust the width as needed for all labels */
               margin-right: 10px;
               vertical-align: ;
               /* Space between label and value */
           }

           .label-value {
               margin-left: 15px;
               margin-top: 3px;
           }
       </style>
       <div class="container">
           <div class="header">
               <table>
                   <tr>
                       <td style="width: 100px; vertical-align: middle;">
                           <img src="{{ public_path('assets/images/logo_bpn.png') }}" alt="Logo" style="max-width: 100px;">
                       </td>
                       <td style="text-align: center; vertical-align: middle; padding-bottom:0px">
                           <h3 style="margin: 0;font-size:20px;">
                               KEMENTRIAN AGRARIA DAN TATA RUANG /<br>BADAN PERTANAHAN NASIONAL <br>KANTOR PERTANAHAN
                               KABUPATEN TABANAN
                           </h3>
                           <p style="font-size:12px;margin: 0; font-family: 'cambria', sans-serif; margin-top:0px">JALAN
                               PULAU
                               SERIBU
                               NO. 16
                               TABANAN Telp.
                               0361-811573</p>
                       </td>
                   </tr>
               </table>
           </div>

           <div class="text-center">
               <h3 class="mb-0 no-margin" style="font-family: Arial, sans-serif;font-size:14px">SURAT TUGAS PENGUKURAN</h3>

               <p class="no-margin" style="font-family: Arial, sans-serif;font-size: 12px">Nomor : {{ $data->no_surat }}</p>
           </div>
           <div class="content mt-1">
               <p>Dengan ini Kepala Kantor menugaskan kepada:</p>

               <div class="row">
                   <p class="no-margin">1. a. Petugas Ukur:</p>
                   <table class="no-margin" border="1" style="margin-bottom: 20px;margin-left:27px">
                       <tr>
                           <td width="1%" class="text-center">No.</td>
                           <td width="35%" class="text-center">Nama / NIP</td>
                           <td width="25%" class="text-center">Pangkat / Golongan</td>
                           <td width="39%" class="text-center">Jabatan</td>
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
                   <p class="no-margin">&nbsp;&nbsp;&nbsp; b. Dengan tugas ini untuk melaksanakan
                       {{ $data->jenis_kegiatan }}
                       <br>
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       Lokasi dan
                       Volume
                       Kegiatan:
                   </p>
               </div>

               <div class="row">
                   <div class="col-6">

                       {{--  <ol class="no-margin" type="a">
                           <li><span class="label-space">Kelurahan</span> <span class="highlight">:
                                   {{ $data->desa }}</span>
                           </li>
                           <li><span class="label-space">Kecamatan</span> <span class="highlight">:
                                   {{ $data->kecamatan }}</span></li>
                           <li><span class="label-space">Volume:</span> <span class="highlight">: {{ $data->luas }}
                                   m²</span></li>

                           <li>
                               Kelurahan: {{ $data->desa }}
                           </li>
                           <li>Kecamatan:
                               {{ $data->kecamatan }}</li>
                           <li>Volume: {{ $data->luas }}
                               m² =</li>
                       </ol>  --}}

                       <table style="margin-left: 25px; margin-top:3px " class="no-margin table-no-padding ">
                           <tr>
                               <td width="50%">a. Kelurahan</td>
                               <td>: {{ $data->desa }} </td>
                           </tr>
                           <tr>
                               <td width="50%">b. Kecamatan</td>
                               <td>: {{ $data->kecamatan }} </td>
                           </tr>
                           <tr>
                               <td width="50%">c. Luas</td>
                               <td>: {{ $data->luas }} m²</td>
                           </tr>
                       </table>

                       <p class="no-margin">2. Waktu:</p>


                       <table style="margin-left: 15px; margin-top:3px  " class="no-margin table-no-padding ">
                           <tr>
                               <td width="50%">a. Mulai Tanggal</td>
                               <td>:
                                   {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}
                               </td>
                           </tr>
                           <tr>
                               <td width="50%">b. Sampai Tanggal</td>
                               <td>:
                                   {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}
                               </td>
                           </tr>
                       </table>

                       <p class="no-margin">3. Biaya dibebankan pada:</p>
                       <table style="margin-left: 15px; margin-top:3px  " class="no-margin table-no-padding ">
                           <tr>
                               <td width="50%">a. DI 305</td>
                               <td>: {{ $data->di_305 }}
                               </td>
                           </tr>
                           <tr>
                               <td width="50%">b. DI 302</td>
                               <td>:
                                   {{ $data->di_302 }}
                               </td>
                           </tr>
                       </table>
                       <p class="no-margin">4. Hasil Pelaksanaan Tugas supaya dilaporkan.</p>

                   </div>
                   {{--  <div class="col-6">
                       <h4>Survey Kepuasan Layanan Pengukuran Bidang Tanah</h4>
                       <img src="https://pngimg.com/d/qr_code_PNG33.png" alt="QR Code" style="width:150px;">
                   </div>
                   <p class="no-margin" style="">KEMENTERIAN AGRARIA DAN TATA RUANG/BADAN PERTANAHAN
                       NASIONAL<br>KANTOR PERTANAHAN KABUPATEN
                       TABANAN</p>  --}}
                   <div class="col-6" style="margin-top:40px">
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
                       <table>
                           <tr>
                               <td class="no-padding">Dikeluarkan</td>
                               <td class="no-padding">: TABANAN</td>
                           </tr>
                           <tr>
                               <td class="no-padding">Pada Tanggal</td>
                               <td class="no-padding">:
                                   {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                               </td>
                           </tr>
                       </table>
                       <hr>
                   </div>
               </div>
               <div class="row">
                   <div class="col-6">
                       <p>Bahwa benar Petugas Ukur telah datang ke lokasi <br> Pada Tanggal
                           {{ \Carbon\Carbon::parse($data->tanggal_mulai_pengukuran)->translatedFormat('d F Y') }}</p>
                   </div>
                   <div class="col-6">
                       <p class="text-center">Atas Nama Kepala Kantor Pertanahan <br> Kantor Pertanahan Kabupaten Tabanan
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
                       <p class="text-center" style="opacity: 0.5;margin:0">Ditandatangani Secara
                           Elektronik
                       </p>
                       <p class="text-center"><u>DARMANSYAH, S.ST.,M.H</u> <br> NIP. 197704241999031002</p>
                   </div>
               </div>
           </div>



       </div>
   @endsection

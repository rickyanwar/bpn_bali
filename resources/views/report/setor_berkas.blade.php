@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    // $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{ __(' Report') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        {{--  <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>  --}}
    </li>
    <li class="breadcrumb-item">{{ __('Report Jadwal Pengukuran') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-4">
                        <div class="card-body table-border-style">
                            <h5></h5>
                            <div class="table-responsive">
                                <table class="table table-sm" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Pemohon</th>
                                            <th>Desa</th>
                                            <th>Kecamatan</th>
                                            <th>No Berkas</th>
                                            <th>DI 302</th>
                                            <th>Tahun</th>
                                            <th>Luas</th>
                                            <th>Jenis</th>
                                            <th>Petugas Ukur</th>
                                            <th>Tanggal Jadwal</th>
                                            <th>Tanggal Setor</th>
                                            <th>Koordinator</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    <script type="text/javascript">
        var table = $('#data-table').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All']
            ],
            dom: 'Blfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('report.jadwal_pengukuran') }}",
            },
            columns: [{
                    data: "nama_pemohon",
                    name: "nama_pemohon",
                },
                {
                    data: "desa",
                    name: "desa",
                },
                {
                    data: "kecamatan",
                    name: "kecamatan",
                },

                {
                    data: "no_berkas",
                    name: "no_berkas",
                },
                {
                    data: "di_302",
                    name: "di_302",
                },
                {
                    data: "tahun",
                    name: "tahun",
                },

                {
                    data: "luas",
                    name: "luas",
                },
                {
                    data: "jenis_kegiatan",
                    name: "jenis_kegiatan",
                },
                {
                    data: "petugas_ukur_utama",
                    name: "petugas_ukur_utama",
                },
                {
                    data: "tanggal_mulai_pengukuran",
                    name: "tanggal_mulai_pengukuran",
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    render: function(data) {
                        return data?.name ?? '-'
                    }
                },

            ],

        });

        $(document).on('click', '#submit-filter', function(e) {
            table.draw();
        })
    </script>
@endpush

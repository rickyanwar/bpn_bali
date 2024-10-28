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
    <li class="breadcrumb-item">{{ __('Setor Berkas') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex align-items-center ">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{--  {{ Form::label('issue_date', __('Issue Date'), ['class' => 'form-label']) }}
                                    {{ Form::date('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : '', ['class' => 'form-control month-btn', 'id' => 'pc-daterangepicker-1']) }}  --}}
                                    <label class="form-label">Tanggal </label>
                                    <input class="form-control month-btn" type="date" name="tanggal"
                                        id="pc-daterangepicker-1" value="{{ date('Y-m-d') }}">

                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 mr-2">
                                <label class="form-label">Petugas Ukur</label>
                                <select class="form-control" id="petugas-ukur-filter" name="petugas_ukur">
                                    <option value="">Semua</option>
                                    @foreach ($petugasUkur as $petugas)
                                        <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-auto
                                            float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary" id="submit-filter" data-toggle="tooltip"
                                    data-original-title="{{ __('apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('permohonan.index') }}" class="btn btn-sm btn-danger"
                                    data-toggle="tooltip" data-original-title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            buttons: [{
                    extend: 'copy',
                    title: function() {
                        return 'Setor Berkas ' + $('#pc-daterangepicker-1').val();
                    }
                },
                {
                    extend: 'excel',
                    title: function() {
                        return 'Setor Berkas ' + $('#pc-daterangepicker-1').val();
                    }
                },
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
                    orderable: false,
                    searchable: false,
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
            e.preventDefault(); // Prevent default anchor behavior
            var selectedDate = $('#pc-daterangepicker-1').val();
            var selectedPetugas = $('#petugas-ukur-filter').val();
            table.ajax.url("{{ route('report.setor_berkas') }}?tanggal=" + selectedDate + "&petugas_id=" +
                selectedPetugas).load();
        })
    </script>
@endpush

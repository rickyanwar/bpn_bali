@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    // $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{ __(' Permohonan') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        {{--  <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>  --}}
    </li>
    <li class="breadcrumb-item">{{ __('Permohonan') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">42</h1> <!-- Replace with your random number -->
                    <h5 style="font-weight: 100">Total Permohonan</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">42</h1> <!-- Replace with your random number -->
                    <h5 style="font-weight: 100">Diproses</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">42</h1> <!-- Replace with your random number -->
                    <h5 style="font-weight: 100">Di Tolak</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">42</h1> <!-- Replace with your random number -->
                    <h5 style="font-weight: 100">Selesai</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">

                        <div class="row d-flex align-items-center ">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box mt-3">
                                    <a href="{{ route('permohonan.create') }}" data-url="{{ route('permohonan.create') }}"
                                        class="btn btn-xl btn-primary btn-block ">
                                        Tambah Data Baru
                                    </a>

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{--  {{ Form::label('issue_date', __('Issue Date'), ['class' => 'form-label']) }}
                                    {{ Form::date('issue_date', isset($_GET['issue_date']) ? $_GET['issue_date'] : '', ['class' => 'form-control month-btn', 'id' => 'pc-daterangepicker-1']) }}  --}}
                                    <label class="form-label">Tanggal </label>
                                    <input class="form-control month-btn" type="date" name="tanggal"
                                        id="pc-daterangepicker-1">

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <label class="form-label">Status </label>
                                    <select class="custom-select" id="inputGroupSelect01">
                                        <option selected>Choose...</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-auto float-end ms-2 mt-4">
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
                                            <th> {{ __('No Surat') }}</th>
                                            <th> {{ __('Nama Pemohon') }}</th>
                                            <th>{{ __('No Berkas') }}</th>
                                            <th>{{ __('Tanggal Di buat') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Di Buat Oleh') }}</th>
                                            @if (Gate::check('edit invoice') || Gate::check('delete invoice') || Gate::check('show invoice'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                            {{-- <th>
                                        <td class="barcode">
                                            {!! DNS1D::getBarcodeHTML($invoice->sku, "C128",1.4,22) !!}
                                            <p class="pid">{{$invoice->sku}}</p>
                                        </td>
                                    </th> --}}
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
                'copy', 'csv', 'pdf', 'print',
            ],
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('permohonan.index') }}",
                data: {
                    issue_date: function() {
                        return $('#pc-daterangepicker-1').val();
                    },
                    customer: function() {
                        return $('#customer').val();
                    },
                    status: function() {
                        return $('#status').val();
                    },
                }
            },
            columns: [{
                    data: "no_surat",
                    name: "no_surat",
                },
                {
                    data: "nama_pemohon",
                    name: "nama_pemohon",
                },
                {
                    data: "no_berkas",
                    name: "no_berkas",
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
                {
                    data: "status_badge",
                    name: "status_badge",
                },
                {
                    data: 'createdby',
                    name: 'createdby',
                    render: function(data) {
                        return data?.name
                    }
                },
                {
                    data: 'actions',
                    name: 'actions',
                },



            ],
        });

        $(document).on('click', '#submit-filter', function(e) {
            table.draw();
        })
    </script>
@endpush

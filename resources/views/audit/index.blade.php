@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    // $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{ __(' Audit Trail') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        {{--  <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>  --}}
    </li>
    <li class="breadcrumb-item">{{ __('Audit Trail') }}</li>
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
                                            <th>Aksi</th>
                                            <th> Modul</th>
                                            <th>Deskripsi</th>
                                            <th>Created On</th>
                                            <th>Created At</th>
                                            <th>di Buat Oleh</th>
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
                url: "{{ route('audit.index') }}",
            },
            columns: [{
                    data: "action",
                    name: "action",
                },
                {
                    data: "module_name",
                    name: "module_name",
                },
                {
                    data: "description",
                    name: "description",
                },

                {
                    data: "created_on",
                    name: "created_on",
                },
                {
                    data: "created_at",
                    name: "created_at",
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

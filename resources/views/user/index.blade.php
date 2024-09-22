@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    // $profile=\App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    {{ __('Manage User') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        {{--  <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>  --}}
    </li>
    <li class="breadcrumb-item">{{ __('User') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip"
            title="{{ __('Create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
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
                                <table class="table" id="data-table">
                                    <thead>
                                        <tr>
                                            <th> {{ __('Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                            {{-- <th>
                                        <td class="barcode">
                                            {!! DNS1D::getBarcodeHTML($invoice->sku, "C128",1.4,22) !!}
                                            <p class="pid">{{$invoice->sku}}</p>
                                        </td>
                                    </th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
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
                url: "{{ route('users.index') }}",
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
                    data: "name",
                    name: "name",
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: 'is_active',
                    name: 'is_active',
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

        //On change to role Petugas Ukur
        $('#commonModal').one('shown.bs.modal', function() {
            $("#role").on('change', function(ret) {

                const userSelectContainer = $('#pendamping-select-container');
                const userSelect = $('#pendamping_id');

                let selectedOption = $(this).find('option:selected');
                let dataName = selectedOption.data('name');

                if (selectedOption.data('name') === 'Petugas Ukur') {
                    userSelectContainer.show();
                    userSelect.prop('required', true);
                } else {
                    userSelectContainer.hide();
                    userSelect.prop('required', false);
                }
            })
        });
    </script>
@endpush

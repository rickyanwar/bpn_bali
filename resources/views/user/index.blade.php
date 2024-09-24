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
                                            <th> {{ __('Role') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Pembantu Ukur') }}</th>
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
                    data: "role",
                    name: "role",
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: 'pembantu_ukur',
                    name: 'pembantu_ukur',
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
        $('#commonModal').on('shown.bs.modal', function() {
            $("#role").on('change', function(ret) {
                const pendampingInputContainer = $('#pendamping-container');
                const pendampingInput = $('#pembantu_ukur');

                let selectedOption = $(this).find('option:selected');
                let dataName = selectedOption.data('name');
                console.log(selectedOption.data('name'))
                if (selectedOption.data('name') === 'Petugas Ukur') {
                    pendampingInputContainer.show();
                    pendampingInput.prop('required', true);
                } else {
                    pendampingInputContainer.hide();
                    pendampingInput.prop('required', false);
                }
            })

            $("#role").trigger('change');
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ route('users.destroy', ':id') }}"
            url = url.replace(':id', id);

            swal({
                title: "Anda Yakin?",
                text: "Proses tidak dapat dibatalkan",
                icon: "warning",
                buttons: [
                    'Tidak, Batalkan!',
                    'Ya, Saya yakin!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let ajaxPost = ajaxRequest(url, 'DELETE', []).done(function(res) {
                        console.log('res')
                        swal({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                        }).then(function() {
                            table.draw();
                        });

                        show_toastr('success', xhr.responseJSON?.message);

                    })
                    ajaxPost.fail(function(e) {
                        swal({
                            icon: 'warning',
                            title: e.responseJSON.message || "Terjadi Kesalahan",
                            showConfirmButton: false,
                        });

                    })
                }
            })

        })
    </script>
@endpush

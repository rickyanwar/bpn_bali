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
    <li class="breadcrumb-item">{{ __('Permohonan') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">{{ $totalPermohonan ?? 0 }}</h1>
                    <h5 style="font-weight: 100">Total Permohonan</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">{{ $totalDiproses ?? 0 }}</h1>
                    <h5 style="font-weight: 100">Diproses</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">{{ $totalDitolak ?? 0 }}</h1>
                    <h5 style="font-weight: 100">Di Tolak</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600">{{ $totalSelesai ?? 0 }}</h1>
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
                            @if (auth()->user()->hasRole('Petugas Jadwal') || auth()->user()->can('manage all permohonan'))
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                    <div class="btn-box mt-3">
                                        <a href="{{ route('permohonan.create') }}"
                                            data-url="{{ route('permohonan.create') }}"
                                            class="btn btn-xl btn-primary btn-block ">
                                            Tambah Data Baru
                                        </a>
                                    </div>
                                </div>
                            @endif
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
                                    <select class="custom-select" id="status">
                                        <option value="">Pilih...</option>
                                        <option value="proses">Proses</option>
                                        <option value="tolak">Tolak</option>
                                        <option value="selesai">Selesai</option>
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
                                            <th> {{ __('No Berkas') }}</th>
                                            <th> {{ __('Nama Pemohon') }}</th>
                                            {{--  <th>{{ __('No Berkas') }}</th>  --}}
                                            <th>{{ __('Tanggal Pengukuran') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Di Teruskan Ke ') }}</th>
                                            <th>{{ __('Di Buat') }}</th>
                                            <th>{{ __('Action') }}</th>
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
                    data: "no_berkas",
                    name: "no_berkas",
                },
                {
                    data: "nama_pemohon",
                    name: "nama_pemohon",
                },

                {
                    data: "tanggal_mulai_pengukuran",
                    name: "tanggal_mulai_pengukuran",
                },
                {
                    data: "status_badge",
                    name: "status_badge",
                },
                {
                    data: 'diteruskan',
                    name: 'diteruskan',
                    render: function(data) {
                        return data?.name ?? '-';
                    },
                    orderable: false, // Disable ordering for actions column
                    searchable: false,
                },
                {
                    data: 'createdby',
                    name: 'createdby',
                    render: function(data) {
                        return data?.name
                    },
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'actions',
                    name: 'actions',
                },



            ],
            rowCallback: function(row, data, index) {
                // Check if `perlu_diteruskan` is true apply red color
                if (data.perlu_diteruskan) {
                    $(row).addClass('bg-danger text-white');
                }
            }
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            swal({
                title: "Anda Yakin ?",
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

                        show_toastr('error', xhr.responseJSON?.message);

                    })
                    ajaxPost.fail(function(e) {
                        console.log('e', e);
                        swal({
                            icon: 'warning',
                            title: e.responseJSON.message,
                            showConfirmButton: false,
                        });

                    })
                }
            })

        })

        $(document).on('click', '.btn-reject', function(e) {
            let url = $(this).data('url');
            console.log('url', url);
            const wrapper = document.createElement('div');
            let swalContent = `
                <p>Jika permohonan revisi, maka permohonan tersebut akan dikembalikan kepada petugas yang sebelumnya mengirimkannya</p>
            <div class="form-group">
                <textarea id="alasan_penolakan" class="form-control"></textarea>
            </div>`;

            wrapper.innerHTML = swalContent;

            swal({
                title: 'Alasan Penolakan/ Revisi',
                content: wrapper,
                buttons: {
                    cancel: 'Cancel',
                    confirm: 'Submit'
                },
                focusConfirm: false,
            }).then(function(result) {
                if (result) {
                    let formData = new FormData();
                    formData.append('alasan_penolakan', $('#alasan_penolakan').val());

                    let ajaxPost = ajaxRequest(url, 'POST', formData).done(function(res) {
                        swal({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.reload();
                        });
                    }).fail(function(xhr) {
                        console.log('xhr', xhr);
                        swal({
                            icon: 'warning',
                            title: xhr.responseJSON?.message,
                            showConfirmButton: false,
                        });
                    });
                }
            });
        });

        $(document).on('click', '#submit-filter', function(e) {
            e.preventDefault();

            var selectedDate = $('#pc-daterangepicker-1').val();
            var status = $('#status').val();
            table.ajax.url("{{ route('permohonan.index') }}?tanggal=" + selectedDate + "&status=" + status).load();
        });


        $(document).on('click', '.paksa_dialihkan_ke', function(e) {
            let id = $(this).data('id');
            // Ensure the modal is shown first
            $('#commonModal').modal('show');

            // Only initialize Select2 once when the modal is fully shown
            $('#commonModal').on('shown.bs.modal', function() {
                // Initialize Select2
                $('#dialihkan_ke').select2({
                    ajax: {
                        url: "{{ route('user.search') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term,
                            };
                        },
                        processResults: function(response) {
                            // Map the results from the API response to the format expected by Select2
                            let results = response.data.data.map(function(user) {
                                return {
                                    id: user.id,
                                    text: user.name
                                };
                            });

                            return {
                                results: results,
                                pagination: {
                                    more: response.data.next_page_url !==
                                        null // Check if there's a next page
                                }
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Pilih Petugas',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#commonModal') // Ensure the dropdown stays within the modal
                });
            });



            $(document).on('click', '#btn-alihkan-tugas', function(e) {
                e.preventDefault();

                var url = "{{ route('permohonan.pindah_tugas', ':id') }}";
                url = url.replace(':id', id);
                console.log('url', url);
                var form = $('#form-pindah-tugas')[0];
                var formData = new FormData(form);
                var findForm = $("#form-pindah-tugas");
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
                        let ajaxPost = ajaxRequest(url, 'POST', formData).done(function(res) {
                            console.log('res')
                            swal({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.replace(
                                    "{{ route('permohonan.index') }}");
                            });

                            show_toastr('error', xhr.responseJSON?.message);

                        })
                        ajaxPost.fail(function(e) {
                            console.log('e', e);
                            swal({
                                icon: 'warning',
                                title: e.responseJSON.message,
                                showConfirmButton: false,
                            });
                            if (parseInt(e.status) == 422) {
                                $.each(e.responseJSON.errors, function(elem, messages) {
                                    findForm.find('#' + elem).after(
                                        '<p class="text-danger text-sm">' +
                                        messages.join('') + '</p>');
                                    //ADD HAS FEEDBACK CLASS
                                    findForm.find('#' + elem).closest(
                                        '.form-group').addClass(
                                        "has-error has-feedback");

                                });
                            }
                        })
                    }
                })

            })
        });

        $(document).on('click', '.btn_teruskan', function(e) {
            let id = $(this).data('id');
            // Ensure the modal is shown first
            $('#commonModal').modal('show');

            // Only initialize Select2 once when the modal is fully shown
            $('#commonModal').on('shown.bs.modal', function() {
                // Destroy any existing Select2 instances before initializing a new one
                if ($('#user').data('select2')) {
                    $('#user').select2('destroy');
                }
                // Initialize Select2
                $('#teruskan_ke_role').on('change', function() {
                    const selectedRole = $(this).val();

                    if (selectedRole) {
                        // Show the user-selection section
                        $('#user-selection').show();

                        // Initialize Select2 with role based on selected option
                        $('#user').select2({
                            ajax: {
                                url: "{{ route('user.search') }}",
                                dataType: 'json',
                                delay: 250,
                                data: function(params) {
                                    console.log('Params:',
                                        params); // Debug: Log the search term
                                    return {
                                        term: params.term,
                                        role: selectedRole // Pass the selected option as role
                                    };
                                },
                                processResults: function(response) {
                                    // Map the results from the API response to the format expected by Select2
                                    let results = response.data.data.map(function(
                                        user) {
                                        return {
                                            id: user.id,
                                            text: user.name
                                        };
                                    });

                                    return {
                                        results: results,
                                        pagination: {
                                            more: response.data.next_page_url !==
                                                null // Check if there's a next page
                                        }
                                    };
                                },
                                cache: true
                            },
                            placeholder: 'Pilih Pengguna',
                            allowClear: true,
                            dropdownParent: $('#commonModal')
                        });

                        // Submit Request for teruskan permohonan
                        $(document).on('click', '#btn-submit-teruskan', function(e) {
                            e.preventDefault();
                            $('.text-danger').remove();
                            $(".form-group").removeClass('has-error has-feedback');

                            var url = "{{ route('permohonan.teruskan', ':id') }}";
                            url = url.replace(':id', id);
                            var form = $('#form-teruskan')[0];
                            var formData = new FormData(form);
                            var findForm = $("#form-teruskan");

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
                                    let ajaxPost = ajaxRequest(url, 'POST',
                                        formData).done(function(res) {
                                        console.log('res', res);
                                        swal({
                                            icon: 'success',
                                            title: res.message,
                                            showConfirmButton: false,
                                        }).then(function() {
                                            window.location.replace(
                                                "{{ route('permohonan.index') }}"
                                            );
                                        });
                                    }).fail(function(xhr) {
                                        console.log('xhr', xhr);
                                        swal({
                                            icon: 'warning',
                                            title: xhr.responseJSON
                                                ?.message,
                                            showConfirmButton: false,
                                        });
                                        if (xhr.status === 422) {
                                            $.each(xhr.responseJSON.errors,
                                                function(elem,
                                                    messages) {
                                                    findForm.find('#' +
                                                        elem).after(
                                                        '<p class="text-danger text-sm">' +
                                                        messages
                                                        .join('') +
                                                        '</p>');
                                                    findForm.find('#' +
                                                            elem)
                                                        .closest(
                                                            '.form-group'
                                                        )
                                                        .addClass(
                                                            "has-error has-feedback"
                                                        );
                                                });
                                        }
                                    });
                                }
                            });
                        });


                    } else {
                        // Hide the user-selection section if no option is selected
                        $('#user-selection').hide();
                    }
                });
            });



            $(document).on('click', '#btn-alihkan-tugas', function(e) {
                e.preventDefault();

                var url = "{{ route('permohonan.pindah_tugas', ':id') }}";
                url = url.replace(':id', id);
                console.log('url', url);
                var form = $('#form-pindah-tugas')[0];
                var formData = new FormData(form);
                var findForm = $("#form-pindah-tugas");
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
                        let ajaxPost = ajaxRequest(url, 'POST', formData).done(function(res) {
                            console.log('res')
                            swal({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.replace(
                                    "{{ route('permohonan.index') }}");
                            });

                            show_toastr('error', xhr.responseJSON?.message);

                        })
                        ajaxPost.fail(function(e) {
                            console.log('e', e);
                            swal({
                                icon: 'warning',
                                title: e.responseJSON.message,
                                showConfirmButton: false,
                            });
                            if (parseInt(e.status) == 422) {
                                $.each(e.responseJSON.errors, function(elem, messages) {
                                    findForm.find('#' + elem).after(
                                        '<p class="text-danger text-sm">' +
                                        messages.join('') + '</p>');
                                    //ADD HAS FEEDBACK CLASS
                                    findForm.find('#' + elem).closest(
                                        '.form-group').addClass(
                                        "has-error has-feedback");

                                });
                            }
                        })
                    }
                })

            })
        });

        $(document).on('click', '.btn_print', function(e) {
            let id = $(this).data('id');
            // Ensure the modal is shown first
            $('#commonModal').modal('show');

            // Only initialize Select2 once when the modal is fully shown
            $('#commonModal').on('shown.bs.modal', function() {
                // Initialize Select2
                $('#print-option').on('change', function() {
                    var selectedValue = $(this).val();

                    // Check if a value is selected
                    if (selectedValue) {
                        // Replace spaces with %20
                        var formattedValue = selectedValue.replace(/ /g, '%20');
                        var urlPrint = "{{ route('permohonan.print', ':id') }}".replace(':id', id);
                        // Redirect
                        window.open(urlPrint + '/?type=' + formattedValue, '_blank');
                        // Reset Vall
                        $(this).val('');
                    }
                });
            });



            $(document).on('click', '#btn-alihkan-tugas', function(e) {
                e.preventDefault();

                var url = "{{ route('permohonan.pindah_tugas', ':id') }}";
                url = url.replace(':id', id);
                console.log('url', url);
                var form = $('#form-pindah-tugas')[0];
                var formData = new FormData(form);
                var findForm = $("#form-pindah-tugas");
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
                        let ajaxPost = ajaxRequest(url, 'POST', formData).done(function(res) {
                            console.log('res')
                            swal({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.replace(
                                    "{{ route('permohonan.index') }}");
                            });

                            show_toastr('error', xhr.responseJSON?.message);

                        })
                        ajaxPost.fail(function(e) {
                            console.log('e', e);
                            swal({
                                icon: 'warning',
                                title: e.responseJSON.message,
                                showConfirmButton: false,
                            });
                            if (parseInt(e.status) == 422) {
                                $.each(e.responseJSON.errors, function(elem, messages) {
                                    findForm.find('#' + elem).after(
                                        '<p class="text-danger text-sm">' +
                                        messages.join('') + '</p>');
                                    //ADD HAS FEEDBACK CLASS
                                    findForm.find('#' + elem).closest(
                                        '.form-group').addClass(
                                        "has-error has-feedback");

                                });
                            }
                        })
                    }
                })

            })
        });
    </script>
@endpush

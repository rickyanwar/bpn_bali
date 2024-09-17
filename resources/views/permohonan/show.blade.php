@extends('layouts.admin')
@section('page-title')
    {{ __('Pengukuran') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Pengukuran ') }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
@endpush
@section('content')
    <div class="row">
        <form id="form-data">
            <div class="col-12">
                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Detail</h5>
                            <p class="m-0 text-sm" style="padding-left:20px">
                                {{ \App\Models\Utility::formatRelativeTime($data->created_at) }}
                            </p>

                            @if ($data->perlu_diteruskan)
                                <p class="m-0 text-danger text-sm font-extrabold" style="padding-left:20px">Perlu Di Tindak
                                    Lanjut
                                </p>
                            @endif
                        </div>
                        <div>



                            {{--  Tampilkan jika permohonan baru pertama kali di buat  --}}
                            @if (empty($data->diteruskan_ke))
                                <a href="{{ route('permohonan.print', $data->id) }}?type=pemberitahuan"
                                    class="btn btn-outline-primary" style="border-radius: 20px">Print Surat Pemberitahuan
                                    <i class="fas fa-print"></i></a>
                            @endif

                            @if (auth()->user()->hasRole('Petugas Cetak') && !empty($data->diteruskan_ke))
                                <div class="form-group">
                                    <select class="form-control" id="print-option"
                                        style="padding-right: 2rem; border-radius:20px">
                                        <option value="">Cetak Surat</option>
                                        <option value="tugas pengukuran">Surat Tugas Petugas Ukur</option>
                                        <option value="lampiran tugas pengukuran">Surat Tugas Pembantu Ukur</option>
                                        <option value="perintah kerja">Surat Perintah Kerja</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-10 mb-2">
                                <span class="status_badge badge p-2 px-3 rounded bg-success">{{ $data->status }}</span>
                            </div>
                            <div class="col-5">
                                <h6>No Berkas</h6>
                                <p class="text-secondary">{{ $data->no_berkas }}</p>
                            </div>
                            <div class="col-5">
                                <h6>Kecamatan</h6>
                                <p class="text-secondary">{{ $data->kecamatan }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>DI 305</h6>
                                    <p class="text-secondary">{{ $data->di_305 }}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>DI 305</h6>
                                    <p class="text-secondary">{{ $data->desa }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>DI 305</h6>
                                    <p class="text-secondary">{{ $data->di_302 }}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>Luas (m2)</h6>
                                    <p class="text-secondary">{{ $data->luas }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <h6>DI 305</h6>
                                <p class="text-secondary">{{ $data->tanggal_pengukuran }}</p>
                            </div>
                            <div class="col-5">
                                <h6>No Surat</h6>
                                <p class="text-secondary">{{ $data->no_surat }}</p>
                            </div>

                        </div>
                        <div class="row justify-content-center">

                            <div class="col-10">
                                <div class="form-group">
                                    <h6>Nama Pemohon</h6>
                                    <p class="text-secondary">{{ $data->nama_pemohon }}</p>
                                </div>
                            </div>


                            @if ($data->status == 'ditolak')
                                <div class="col-10 mt-2" id="user-selection">
                                    <h6 class="text-danger">Alasan Penolakan/ Revisi</h6>
                                    <p>{{ $data->alasan_penolakan }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="row justify-content-center mb-5">

                            <div class="col-10 ">
                                <!-- outer repeater -->
                                <div class="container mt-5 repeater" data-value='{!! json_encode($data->petugasUkur) !!}'>
                                    <!--outer repeater-->
                                    <div data-repeater-list="petugas_ukur">
                                        <!-- innner repeater -->

                                        <div data-repeater-list="inner-list">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Petugas Ukur
                                                            </label>
                                                            <select class="form-control form-control petugas_ukur"
                                                                name="petugas_ukur" style="width: 100%">
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Pendamping
                                                            </label>
                                                            <select class="form-control form-control pendamping"
                                                                name="pendamping" style="width: 100%">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 mt-4">

                                                        <button data-repeater-delete style="border-radius: 20px"
                                                            class="btn btn-outline-secondary btn-sm">
                                                            <i class="fas fa-minus"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                    <button data-repeater-create type="button" class="btn btn-outline-primary">Tambah
                                        Petugas Ukur</button>
                                </div>


                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="form-label">Teruskan Ke
                                    </label>
                                    <select class="form-control form-control teruskan_ke_role" name="teruskan_ke_role"
                                        id="teruskan_ke_role" style="width: 100%">
                                        <option value="">Pilih</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-10 mt-2" id="user-selection">
                                <div class="form-group">
                                    <h6>Pilih Petugas</h6>
                                    <select class="form-control" id="user" name="user">

                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="card-footer d-flex justify-content-end">


                        @if ($data->status !== 'draft' && $data->status !== 'selesai' && $data->status !== 'ditolak')
                            <button type="button" id="btn-reject" data-url="{{ $urlTolak }}"
                                style="margin-left: 5px" class="btn btn-danger">Tolak</button>
                        @endif

                        @if (Auth::user()->id == $data->diteruskan_ke || empty($data->diteruskan_ke))
                            <button type="button" style="margin-left: 5px" class="btn btn-primary"
                                id="btn-submit">Kirim</button>
                            <button type="button" style="margin-left: 5px" class="btn btn-primary"
                                id="btn-selesai">Selesai</button>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script-page')
    @include('permohonan.script')
    <script>
        let data = {!! json_encode($data) !!};
        let urlPrint = "{{ route('permohonan.print', $data->id) }}";
        $('#print-option').on('change', function() {
            var selectedValue = $(this).val();

            // Check if a value is selected
            if (selectedValue) {
                // Replace spaces with %20
                var formattedValue = selectedValue.replace(/ /g, '%20');
                var urlPrint = "{{ route('permohonan.print', $data->id) }}";
                // Redirect
                window.open(urlPrint + '/?type=' + formattedValue, '_blank');
                // Reset Vall
                $(this).val('');
            }
        });

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
                            console.log('Params:', params); // Debug: Log the search term
                            return {
                                term: params.term,
                                role: selectedRole // Pass the selected option as role
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
                    placeholder: 'Pilih Pengguna',
                    allowClear: true
                });
            } else {
                // Hide the user-selection section if no option is selected
                $('#user-selection').hide();
            }
        });

        $(document).ready(function() {
            // If there's existing data, populate the form with it
            // If there's existing data, populate the form with it
            if (data?.petugas_ukur?.length > 0) {
                // populateForm(data?.petugas_ukur);
            }


            // Iterate over each checkbox
            $('#dokument_terlampir .form-check-input').each(function() {
                var checkbox = $(this);
                if (selectedDocuments.includes(checkbox.val())) {
                    checkbox.prop('checked', true); // Check the checkbox
                    checkbox.prop('disabled', true); // Disable the checkbox
                }
            });

            // Optional: Log the selected value to the console
            $('#diteruskan_ke_role').on('change', function() {
                const selectedOption = $(this).val();
                console.log('selectedOption', selectedOption);
                if (selectedOption) {
                    // Show the user-selection section
                    $('#user-selection').show();

                    // Initialize Select2 with role based on selected option
                    $('#user').select2({
                        ajax: {
                            url: "{{ route('user.search') }}",
                            dataType: 'json',
                            delay: 250,
                            data: function(params) {
                                return {
                                    term: params.term,
                                    role: selectedOption
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
                        allowClear: true
                    });
                } else {
                    // Hide the user-selection section if no option is selected
                    $('#user-selection').hide();
                }
            });

            // Initially hide the user-selection section
            $('#user-selection').hide();

            $(document).on('click', '#btn-submit', function(e) {
                e.preventDefault();
                $('.text-danger').remove();
                $(".form-group").removeClass('has-error has-feedback');

                var url = "{{ $urlTeruskan }}";
                var form = $('#form-data')[0];
                var formData = new FormData(form);
                var findForm = $("#form-data");

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
                            console.log('res', res);
                            swal({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.replace(
                                    "{{ route('permohonan.index') }}");
                            });
                        }).fail(function(xhr) {
                            console.log('xhr', xhr);
                            swal({
                                icon: 'warning',
                                title: xhr.responseJSON?.message,
                                showConfirmButton: false,
                            });
                            if (xhr.status === 422) {
                                $.each(xhr.responseJSON.errors, function(elem, messages) {
                                    findForm.find('#' + elem).after(
                                        '<p class="text-danger text-sm">' +
                                        messages.join('') + '</p>');
                                    findForm.find('#' + elem).closest('.form-group')
                                        .addClass("has-error has-feedback");
                                });
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#btn-reject', function(e) {
                let url = $(this).data('url');
                console.log('url', url);
                const wrapper = document.createElement('div');
                let swalContent = `
            <div class="form-group">
                <textarea id="alasan_penolakan" class="form-control"></textarea>
            </div>`;

                wrapper.innerHTML = swalContent;

                swal({
                    title: 'Alasan Penolakan',
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
        });
    </script>
@endpush

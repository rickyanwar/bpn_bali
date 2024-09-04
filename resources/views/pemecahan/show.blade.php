@extends('layouts.admin')
@section('page-title')
    {{ __('Penggabungan') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('penggabungan.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Penggabungan ') }}</li>
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
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Detail</h5>
                        <p class="m-0 text-sm" style="padding-left:20px">
                            {{ \App\Models\Utility::formatRelativeTime($data->created_at) }}</p>
                        <p class="m-0 text-danger text-sm" style="padding-left:20px">Perlu Di Tindak Lanjut</p>
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
                            <div class="col-10 my-5">
                                <h6>Petugas Ukur</h6>
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama/NIP</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{ $data->petugas_ukur }}
                                        @foreach ($data->petugasUkur as $index => $petugas)
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $petugas->user->name }}
                                            </td>
                                            <td>
                                                @foreach ($petugas->user->roles as $role)
                                                    {{ $role->name }}
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-5 mt-2">
                                <div class="form-group">
                                    <h6>Di Teruskan Ke</h6>
                                    <select class="form-control" id="diteruskan_ke" name="diteruskan_ke">
                                        <option value="">Pilih Tujuan</option>
                                        <option value="Petugas Cetak Surat Tugas">Petugas Cetak Surat Tugas</option>
                                        <option value="Petugas Ukur">Petugas Ukur</option>
                                        <option value="Admin Pengukuran">Admin Pengukuran</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Petugas Gambar">Petugas Gambar</option>
                                        <option value="Koordinator Wilayah">Koordinator Wilayah</option>
                                        <option value="Kepala Seksi">Kepala Seksi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-5 mt-2">
                                <div class="form-group">
                                    <h6>Options</h6>
                                    <select class="form-control" id="options_select" name="options_select">
                                        <option value="">Pilih Opsi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-10 mt-2" id="user-selection">
                                <div class="form-group">
                                    <h6>Pilih Pengguna</h6>
                                    <select class="form-control" id="user" name="user">

                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('penggabungan.print', [Crypt::encrypt($data->id)]) }}" class="btn btn-info "
                            style="margin-left: 5px">Print</a>
                        <button type="button" style="margin-left: 5px" class="btn btn-danger " id="btn-reject"
                            data-url="{{ $urlTolak }}">Tolak</button>
                        <button type="button" style="margin-left: 5px" class="btn btn-primary "
                            id="btn-submit">Teruskan</button>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script-page')
    @include('penggabungan.script')
    <script>
        $(document).ready(function() {

            const optionsMap = {
                "Petugas Cetak Surat Tugas": [
                    "Surat Tugas Petugas Ukur",
                    "Surat Tugas Pembantu Ukur",
                    "Surat Perintah Kerja"
                ],
                "Petugas Ukur": [
                    "Admin Pengukuran"
                ],
                "Admin Pengukuran": [
                    "Koordinator Pengukuran"
                ],
                "Admin": [
                    "Petugas Gambar",
                    "Koordinator Wilayah",
                    "Kasi SP"
                ],
                "Petugas Gambar": [
                    "Koordinator Wilayah",
                    "Petugas Ukur",
                    "Admin Pengukuran"
                ],
                "Koordinator Wilayah": [
                    "Petugas Gambar",
                    "Petugas Ukur",
                    "Koordinator Pengukuran",
                    "Admin 1",
                    "Admin 2",
                    "Admin 3"
                ],
                "Kepala Seksi": [
                    "Koordinator Wilayah",
                    "Koordinator Pengukuran",
                    "Admin"
                ]
            };

            $('#diteruskan_ke').on('change', function() {
                const selectedRole = $(this).val();
                const options = optionsMap[selectedRole] || [];

                // Clear the previous options
                $('#options_select').empty();

                // Add the default option
                $('#options_select').append('<option value="">Pilih Opsi</option>');

                // Populate the options based on the selected role
                options.forEach(function(option) {
                    $('#options_select').append(`<option value="${option}">${option}</option>`);
                });

                // Trigger change on options_select to update user-selection
                $('#options_select').trigger('change');
            });

            $('#options_select').on('change', function() {
                const selectedOption = $(this).val();

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
                                console.log('Params:', params); // Debug: Log the search term
                                return {
                                    term: params.term,
                                    role: selectedOption // Pass the selected option as role
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
                            console.log('res')
                            swal({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.replace(
                                    "{{ route('penggabungan.index') }}");
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

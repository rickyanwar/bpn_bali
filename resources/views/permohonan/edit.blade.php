@php
    $currentUserId = auth()->id();
    $diteruskanKe = $data->diteruskan_ke;
    $createdBy = $data->created_by;
    $status = $data->status;
@endphp
@extends('layouts.admin')
@section('page-title')
    {{ __('Pengukuran') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit ') }}</li>
@endsection
@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
@endpush
@section('content')
    <div class="row">
        <form id="form-data">
            <input type="hidden" name="_method" value="put">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">

                            <h5 class="mb-0">No Berkas #{{ $data->no_berkas }}</h5>

                            <p class="m-0 text-sm" style="padding-left:20px">
                                {{ \App\Models\Utility::formatRelativeTime($data->created_at) }}
                            </p>

                            @if ($data->perlu_diteruskan)
                                <p class="m-0 text-danger text-sm font-extrabold" style="padding-left:20px">Perlu Di Tindak
                                    Lanjut
                                </p>
                            @endif
                            @php
                                switch ($data->status) {
                                    case 'draft':
                                        $statusClass = 'bg-danger';
                                        break;
                                    case 'revisi':
                                        $statusClass = 'bg-danger';
                                        break;
                                    case 'proses':
                                        $statusClass = 'bg-warning';
                                        break;
                                    case 'selesai':
                                        $statusClass = 'bg-success';
                                        break;
                                    default:
                                        $statusClass = 'bg-secondary';
                                        break;
                                }
                            @endphp
                            <span style="margin-left: 10px"
                                class="status_badge  badge p-2 px-3 rounded {{ $statusClass }} text-capitalize">{{ $data->status }}</span>
                        </div>
                        <div>

                            {{--  Tampilkan jika permohonan baru pertama kali di buat  --}}
                            @if (auth()->user()->hasRole('Petugas Jadwal'))
                                <a href="{{ route('permohonan.print', $data->id) }}?type=pemberitahuan"
                                    class="btn btn-outline-primary" style="border-radius: 20px">Print Surat Pemberitahuan
                                    <i class="fas fa-print"></i></a>
                            @endif

                            @if (auth()->user()->hasRole('Petugas Cetak Surat Tugas') && !empty($data->diteruskan_ke))
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
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">No Berkas</label>
                                    <input class="form-control" type="text" id="no_berkas" name="no_berkas"
                                        placeholder="Masukkan no berkas">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">No Surat</label>
                                    <input class="form-control" type="text" id="no_surat" name="no_surat"
                                        placeholder="Masukkan No Berkas">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Kecamatan</label>
                                    <select class="form-control form-control select2" id="kecamatan" name="kecamatan"
                                        style="width: 100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Desa</label>
                                    <select class="form-control form-control select2" id="desa" name="desa"
                                        style="width: 100%">
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">DI 305</label>
                                    <input class="form-control" type="text" name="di_305" id="di_305"
                                        placeholder="Masukkan DI 305">
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">DI 302</label>
                                    <input class="form-control" type="text" name="di_302" id="di_302"
                                        placeholder="Masukkan DI 302">
                                </div>
                            </div>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Mulai Pengukuran</label>
                                            <input class="form-control " type="date" name="tanggal_mulai_pengukuran"
                                                id="tanggal_mulai_pengukuran">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Selesai Pengukuran</label>
                                            <input class="form-control " type="date" name="tanggal_berakhir_pengukuran"
                                                id="tanggal_berakhir_pengukuran">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Luas (m2)</label>
                                    <input class="form-control" type="number" name="luas" id="luas"
                                        placeholder="Masukkan Luas">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon</label>
                                    <input class="form-control" type="text" name="nama_pemohon" id="nama_pemohon"
                                        placeholder="Masukkan nama pemohon">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Jenis Permohonan</label>
                                    <select class="form-control form-control" name="jenis_kegiatan" id="jenis_kegiatan"
                                        style="width: 100%">
                                        <option value="">Pilih</option>
                                        <option value="Penggabungan">Penggabungan</option>
                                        <option value="Pemecahan">Pemecahan</option>
                                        <option value="Pengukuran">Pengukuran dan Pemetaan Kadastral
                                        </option>
                                        <option value="Penataan Batas">Penataan Batas</option>
                                        <option value="Pengembalian Batas">Pengembalian Batas</option>
                                        <option value="Permohonan SK">Permohonan SK</option>
                                        <option value="Konversi">Konversi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-10">
                                <!-- outer repeater -->
                                <div class="mt-2 repeater" data-value='{!! json_encode($data->petugasUkur) !!}'>
                                    @if (auth()->user()->hasRole('Petugas Jadwal') && ($status == 'draft' && $createdBy === $currentUserId))
                                        <div data-repeater-list="petugas_ukur">
                                            <div data-repeater-item>
                                                <!-- innner repeater -->
                                                <div data-repeater-list="inner-list">
                                                    <div data-repeater-item>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Petugas Ukur
                                                                    </label>
                                                                    <select class="form-control form-control petugas_ukur"
                                                                        name="petugas_ukur" style="width: 100%">
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pembantu ukur
                                                                    </label>
                                                                    <input class="form-control form-control pembantu_ukur"
                                                                        name="pembantu_ukur" readonly>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif (auth()->user()->hasRole('Petugas Cetak Surat Tugas') && $data->diteruskan_ke == auth()->user()->id)
                                        {{--  if petugas cetak show delete and minus button  --}}
                                        <div data-repeater-list="petugas_ukur">
                                            <div data-repeater-item>
                                                <!-- innner repeater -->
                                                <div data-repeater-list="inner-list">
                                                    <div data-repeater-item>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label class="form-label">Petugas Ukur
                                                                    </label>
                                                                    <select class="form-control form-control petugas_ukur"
                                                                        name="petugas_ukur" style="width: 100%">
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label class="form-label">Pembantu ukur
                                                                    </label>
                                                                    <input class="form-control form-control pembantu_ukur"
                                                                        name="pembantu_ukur" readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-2 mt-4">
                                                                <button type="button" data-repeater-delete
                                                                    style="border-radius: 20px"
                                                                    class="btn btn-outline-secondary btn-sm">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button data-repeater-create type="button" class="btn btn-outline-primary">Tambah
                                            Petugas Ukur</button>
                                    @else
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Petugas Ukur</th>
                                                    <th scope="col">Pembantu Ukur</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->petugasUkur as $petugas)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}.

                                                            <input type="hidden"
                                                                name="petugas_ukur[{{ $loop->index }}][petugas_ukur]"
                                                                value="{{ $petugas->petugas->id }}">
                                                            <input type="hidden"
                                                                name="petugas_ukur[{{ $loop->index }}][pembantu_ukur]"
                                                                value="{{ $petugas->pembantu_ukur }}">
                                                        </td>
                                                        <td>{{ $petugas->petugas->name }}</td>
                                                        <td>{{ $petugas->pembantu_ukur }}</td>


                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            @if (
                                ($diteruskanKe === null && $status === 'draft' && $createdBy === $currentUserId) ||
                                    auth()->user()->can('edit permohonan'))
                                <button type="button" class="btn btn-secondary mx-2">Cancel</button>
                                @if (
                                    $data->status !== 'draft' &&
                                        $data->status !== 'selesai' &&
                                        $data->status !== 'revisi' &&
                                        $data->diteruskan_ke == auth()->user()->id)
                                    <button type="button" id="btn-reject" data-url="{{ $urlTolak }}"
                                        class="btn btn-danger  mx-2">Tolak/Revisi</button>
                                @endif
                                <button type="button" class="btn btn-primary " id="btn-submit">Simpan Perubahan</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if (
            $data->diteruskan_ke == auth()->user()->id ||
                ($diteruskanKe === null && $status == 'draft' && $createdBy === $currentUserId))
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">Teruskan Permohonan</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-teruskan">
                            <div class="row justify-content-center">
                                <div class="col-10">
                                    <div class="form-group">
                                        <label class="form-label">Teruskan Ke
                                        </label>
                                        <select class="form-control form-control teruskan_ke_role" name="teruskan_ke_role"
                                            id="teruskan_ke_role" style="width: 100%">
                                            <option value="">Pilih</option>
                                            @foreach ($allowedRoles as $role)
                                                <option value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </form>
                        <div class="col-10 mt-2" id="user-selection">
                            <div class="form-group">
                                <h6>Pilih Petugas</h6>
                                <select class="form-control" id="user" name="user">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">

                        @if (
                            ($diteruskanKe === null && $status === 'draft' && $createdBy === $currentUserId) ||
                                $diteruskanKe == $currentUserId ||
                                auth()->user()->can('edit permohonan'))
                            <button type="button" class="btn btn-secondary mx-2">Cancel</button>
                            <button type="button" class="btn btn-primary " id="btn-teruskan-permohoanan">Teruskan
                                Permohoan</button>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    @endif

    </div>
@endsection
@push('script-page')
    @include('permohonan.script')
    <script>
        let urlPrint = "{{ route('permohonan.print', $data->id) }}";

        @if (!auth()->user()->hasRole('Petugas Cetak Surat Tugas') && !empty($data->diteruskan_ke))
            $('.pendamping').prop('disabled', true);
            $('.petugas_ukur').prop('disabled', true);
        @endif

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


        let data = {!! json_encode($data) !!};
        let url = `{!! !empty($url) ? $url : '' !!}`;
        $('#no_berkas').val(data?.no_berkas);
        $('#di_305').val(data?.di_305);
        $('#di_302').val(data?.di_302);
        $('#tanggal_mulai_pengukuran').val(data?.tanggal_mulai_pengukuran);
        $('#tanggal_berakhir_pengukuran').val(data?.tanggal_berakhir_pengukuran);
        $('#luas').val(data?.luas);
        $('#no_surat').val(data?.no_surat);
        $('#nama_pemohon').val(data?.nama_pemohon);
        $('#jenis_kegiatan').val(data?.jenis_kegiatan).trigger('change')


        @if (
            !($diteruskanKe === null && $status == 'draft' && $createdBy === $currentUserId) ||
                ($diteruskanKe !== $currentUserId && !auth()->user()->can('edit permohonan')))

            $('input[type="date"], input[type="number"], input[type="text"], select:not(#teruskan_ke_role, #user)')
                .not('select[name^="petugas_ukur"]')
                .not('#print-option')
                .prop('disabled', true);
        @endif


        $(document).ready(function() {

            if ((data.kecamatan)) {
                loadKecamatan("51.01", data.kecamatan).then(function() {
                        let kodeKecamatan = $('#kecamatan option:selected').attr('data-id');
                        return loadDesa(kodeKecamatan, data.desa);
                    })
                    .catch(function(error) {
                        alert('gagal melakukan set data wilayah')
                    });
            } else {
                loadKecamatan()
            }

            $('#user-selection').hide();
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

            $(document).on('click', '#btn-submit', function(e) {
                e.preventDefault();
                $('.text-danger').remove();
                $(".form-group").removeClass('has-error has-feedback');
                var url = "{{ $url }}";
                var form = $('#form-data')[0];
                var formData = new FormData(form);
                var findForm = $("#form-data");

                // Format tanggal_lahir to d-m-Y using jQuery and Moment.js
                var tanggalLahirInput = $('input[name="tanggal_lahir"]');
                var tanggalLahirValue = tanggalLahirInput.val();
                if (tanggalLahirValue) {
                    var formattedDate = moment(tanggalLahirValue).format('DD-MM-YYYY');
                    formData.set('tanggal_lahir', formattedDate);
                }

                // Append values of disabled inputs to formData
                $('input:disabled, select:disabled').each(function() {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if (name) {
                        formData.append(name, value);
                    }
                });

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


            $(document).on('click', '#btn-teruskan-permohoanan', function(e) {
                e.preventDefault();
                $('.text-danger').remove();
                $(".form-group").removeClass('has-error has-feedback');
                var url = "{{ $urlTeruskan }}";
                var form = $('#form-teruskan')[0];
                var formData = new FormData(form);
                var findForm = $("#form-teruskan");

                // Append values of disabled inputs to formData
                $('input:disabled, select:disabled').each(function() {
                    var name = $(this).attr('name');
                    var value = $(this).val();
                    if (name) {
                        formData.append(name, value);
                    }
                });

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

            $(document).on('click', '#btn-reject', function(e) {
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

        });
    </script>
@endpush

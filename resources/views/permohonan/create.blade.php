@extends('layouts.admin')
@section('page-title')
    {{ __('Pengukuran') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create ') }}</li>
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
                        <div class="row justify-content-center mb-5">

                            <div class="col-10">
                                <!-- outer repeater -->
                                <div class="mt-2 repeater">
                                    <!--outer repeater-->
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
                                                        {{--  <div class"col-2 mt-4">
                                                            @role('Petugas Cetak Surat Tugas')
                                                                <button type="button" data-repeater-delete
                                                                    style="border-radius: 20px"
                                                                    class="btn btn-outline-secondary btn-sm">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            @endrole
                                                        </div>  --}}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    {{--  <button data-repeater-create type="button" class="btn btn-outline-primary">Tambah
                                        Petugas Ukur</button>  --}}
                                </div>


                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary mx-2">Cancel</button>
                            <button type="button" class="btn btn-primary " id="btn-submit">Simpan Permohonan</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
@push('script-page')
    @include('permohonan.script')
    <script>
        $(document).ready(function() {
            loadKecamatan();
            // Initialize Select2 for the first repeater row on page load
            initializeSelect2($('.petugas_ukur'));
            initializeSelect2($('.pendamping'), null, false);
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


            // Assuming this code is triggered on some event or after elements are created

            $('.petugas_ukur').on('change', function() {
                const $this = $(this);
                const selectedPetugas = $this.select2('data')[0]; // Get selected data


                // Find the nearest pendamping select element
                const $pembantuUkur = $this.closest('[data-repeater-item]').find('.pembantu_ukur');
                if (selectedPetugas) {
                    // Assuming you want to set the pendamping to the selected petugas

                    $pembantuUkur.empty(); // Clear previous options
                    if (selectedPetugas?.data?.pembantu_ukur) {
                        $pembantuUkur.val(selectedPetugas?.data?.pembantu_ukur);
                    }

                } else {
                    $pendampingSelect.empty().trigger('change'); // Clear if no selection
                }
            });



        });
    </script>
@endpush

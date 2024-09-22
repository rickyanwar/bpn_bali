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
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">No Berkas</label>
                                    <input class="form-control" type="text" name="no_berkas" id="no_berkas"
                                        placeholder="Masukkan no berkas">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Kecamatan</label>
                                    <select class="form-control form-control select2" id="kecamatan" name="kecamatan"
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
                                    <label class="form-label">DI 302</label>
                                    <input class="form-control" type="text" name="di_302" id="di_302"
                                        placeholder="Masukkan DI 302">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Luas (m2)</label>
                                    <input class="form-control" type="number" name="luas" id="luas"
                                        placeholder="Masukkan Luas">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Pengukuran</label>
                                    <input class="form-control" type="date" name="tanggal_pengukuran"
                                        id="tanggal_pengukuran">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="form-label">No Surat</label>
                                    <input class="form-control" type="text" name="no_surat" id="no_surat"
                                        placeholder="Masukkan no surat">
                                </div>
                            </div>

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
                                    <button data-repeater-create type="button" class="btn btn-outline-primary">Tambah
                                        Petugas Ukur</button>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mx-2">Cancel</button>
                        <button type="button" class="btn btn-primary " id="btn-submit">Simpan Perubahan</button>
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
        let url = `{!! !empty($url) ? $url : '' !!}`;

        $('#no_berkas').val(data?.no_berkas);
        $('#di_305').val(data?.di_305);
        $('#di_302').val(data?.di_302);
        $('#tanggal_pengukuran').val(data?.tanggal_pengukuran);
        $('#luas').val(data?.luas);
        $('#no_surat').val(data?.no_surat);
        $('#nama_pemohon').val(data?.nama_pemohon);



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



            $(document).on('click', '#btn-submit', function(e) {

                console.log('btn submit')
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

        });
    </script>
@endpush

@extends('layouts.admin')
@section('page-title')
    {{ __('Penataan Batas') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('penataan_batas.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Penataan Batas ') }}</li>
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
                        <div class="row justify-content-center">

                            <div class="col-10">
                                <div class="form-group">
                                    <label class="form-label">Nama Pemohon</label>
                                    <input class="form-control" type="text" name="nama_pemohon" id="nama_pemohon"
                                        placeholder="Masukkan nama pemohon">
                                </div>
                            </div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="form-label">Petugas Ukur</label>
                                    <select class="form-control " id="petugas_ukur" name="petugas_ukur[]"
                                        multiple="multiple" style="width: 100%">
                                    </select>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary mx-2">Cancel</button>
                        <button type="button" class="btn btn-primary " id="btn-submit">Kirim Permohonan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script-page')
    @include('penataan_batas.script')
    <script>
        $(document).ready(function() {

            loadKecamatan();

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
                                    "{{ route('penataan_batas.index') }}");
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

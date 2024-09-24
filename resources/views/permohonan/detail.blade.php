@extends('layouts.admin')
@section('page-title')
    {{ __('Permohonan') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">{{ __('Permohonan') }}</a></li>
    <li class="breadcrumb-item">{{ __('Detail ') }}</li>
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
                            <h5 class="mb-0">Detail #{{ $data->no_surat }}</h5>
                            <p class="m-0 text-sm" style="padding-left:20px">
                                {{ \App\Models\Utility::formatRelativeTime($data->created_at) }}
                            </p>

                            @if ($data->perlu_diteruskan)
                                <p class="m-0 text-danger text-sm font-extrabold" style="padding-left:20px">Perlu Di Tindak
                                    Lanjut
                                </p>
                            @endif
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-10 mb-2">
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

                                <span
                                    class="status_badge badge p-2 px-3 rounded {{ $statusClass }} text-capitalize">{{ $data->status }}</span>
                            </div>
                            <div class="col-5">
                                <h6>No Berkas</h6>
                                <p class="text-secondary">{{ $data->no_berkas }}</p>
                            </div>
                            <div class="col-5">
                                <h6>No Surat</h6>
                                <p class="text-secondary">{{ $data->no_surat }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>Kecamatan</h6>
                                    <p class="text-secondary">{{ $data->kecamatan }}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>Desa</h6>
                                    <p class="text-secondary">{{ $data->desa }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>Tanggal Pengukuran </h6>
                                    <p class="text-secondary">{{ $data->tanggal_mulai_pengukuran }} -
                                        {{ $data->tanggal_berakhir_pengukuran }}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <h6>Luas</h6>
                                    <p class="text-secondary">{{ $data->luas }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <h6>DI 305</h6>
                                <p class="text-secondary">{{ $data->di_305 }}</p>
                            </div>
                            <div class="col-5">
                                <h6>DI 302</h6>
                                <p class="text-secondary">{{ $data->di_302 }}</p>
                            </div>
                            @if ($data->status == 'revisi')
                                <div class="col-10 mt-2">
                                    <h6>Alasan Penolakan/ Revisi</h6>
                                    <p class="text-danger">{{ $data->alasan_penolakan }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <h6>Nama Pemohon</h6>
                                <p class="text-secondary">{{ $data->nama_pemohon }}</p>
                            </div>
                            <div class="col-5">
                                <h6>Jenis Permohonan</h6>
                                <p class="text-secondary">{{ $data->jenis_kegiatan }}</p>
                            </div>
                            @if ($data->status == 'revisi')
                                <div class="col-10 mt-2">
                                    <h6>Alasan Penolakan/ Revisi</h6>
                                    <p class="text-danger">{{ $data->alasan_penolakan }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-5">
                                <h6>Di Teruskan Ke Petugas</h6>
                                <p class="text-secondary">{{ $data->diteruskan_ke_role }}</p>
                            </div>
                            <div class="col-5">
                                <h6>Nama Petugas</h6>
                                <p class="text-secondary">{{ $data->diteruskan->name }}</p>
                            </div>

                        </div>

                        <div class="row justify-content-center mb-2">
                            <div class="col-10">
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
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $petugas->petugas->name }}</td>
                                                <td>{{ $petugas->pembantu_ukur }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Riwayat Penerusan Permohonan
            </div>
            <div class="card-body mx-3">
                <div class="table-responsive">
                    <table class="table table-sm" id="riwayat-penerusan-table">
                        <thead>
                            <tr>
                                <th> {{ __('Petugas') }}</th>
                                <th> {{ __('Nama Petugas') }}</th>
                                {{--  <th>{{ __('No Berkas') }}</th>  --}}
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Tanggal') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Audit Trail
            </div>
            <div class="card-body mx-3">
                <div class="table-responsive">
                    <table class="table table-sm" id="audit-trails-table">
                        <thead>
                            <tr>
                                <th> {{ __('Aksi') }}</th>
                                <th> {{ __('Deskripsi') }}</th>
                                <th>{{ __('Created On') }}</th>
                                <th>{{ __('Tanggal') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    <script>
        $(document).ready(function() {
            $('#riwayat-penerusan-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                paging: false,
                searching: false,
                ajax: {
                    url: "{{ route('permohonan.riwayat-penerusan', $data->id) }}",
                },
                columns: [{
                        data: "diteruskan_ke_role",
                        name: "diteruskan_ke_role",
                    },

                    {
                        data: 'diteruskan',
                        name: 'diteruskan',
                        render: function(data) {
                            return data?.name ?? '-';
                        }
                    },
                    {
                        data: "status_badge",
                        name: "status_badge",
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                    },


                ]
            });


            $('#audit-trails-table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: true,
                paging: false,
                searching: false,
                ajax: {
                    url: "{{ route('permohonan.audit-trails', $data->id) }}",
                },
                columns: [{
                        data: "action",
                        name: "action",
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


                ]
            });


        });
    </script>
@endpush

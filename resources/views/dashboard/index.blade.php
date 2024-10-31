@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('breadcrumb')
    {{--  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>  --}}
    <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Chart ') }}</li>
@endsection
@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex align-items-center ">

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    <label class="form-label">Tanggal </label>
                                    <input class="form-control month-btn" type="date" name="tanggal"
                                        id="pc-daterangepicker-1"
                                        value="{{ request('tanggal') ?? \Carbon\Carbon::today()->subMonth()->toDateString() }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600" id="totalPermohonan"></h1>
                    <h5 style="font-weight: 100">Total Permohonan</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600" id="totalDiproses"></h1>
                    <h5 style="font-weight: 100">Diproses</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600" id="totalDitolak"></h1>
                    <h5 style="font-weight: 100">Di Tolak</h5>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card text-center">
                <div class="card-body">
                    <h1 class="display-6" style="font-weight: 600" id="totalSelesai"></h1>
                    <h5 style="font-weight: 100">Selesai</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <canvas id="doughnutChart" width="400" height="400"></canvas>
                        </div>
                        <div class="col-6">
                            <canvas id="barChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table table-sm" id="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>Desa</th>
                                    <th>Kecamatan</th>
                                    <th>No Berkas</th>
                                    <th>DI 302</th>
                                    <th>Tahun</th>
                                    <th>Luas</th>
                                    <th>Jenis</th>
                                    <th>Petugas Ukur</th>
                                    <th>Tanggal Jadwal</th>
                                    <th>Tanggal Setor</th>
                                    <th>Koordinator</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-page')
    @push('script-page')
        <script>
            $(document).ready(function() {
                // Set default date range to one month from today
                const today = new Date();
                const lastMonth = new Date();
                lastMonth.setMonth(today.getMonth() - 1);

                // Initialize Flatpickr
                $('#pc-daterangepicker-1').flatpickr({
                    mode: "range",
                    defaultDate: [lastMonth, today], // Set the default date range
                    dateFormat: "Y-m-d", // Set the desired date format
                    onChange: function(selectedDates) {
                        // You can trigger your table refresh here if needed
                        table.ajax.reload();
                    }
                });

                // Function to update charts and cards
                function updateDashboardData(date) {
                    $.get("{{ route('dashboard.index') }}", {
                        tanggal: date
                    }, function(data) {
                        $('#totalPermohonan').html(data.totalPermohonan ?? 0);
                        $('#totalDiproses').html(data.totalDiproses ?? 0);
                        $('#totalDitolak').html(data.totalDitolak ?? 0);
                        $('#totalSelesai').html(data.totalSelesai ?? 0);

                        // Update chart data
                        const labels = data.totalByStatus.map(item => item.status);
                        const totals = data.totalByStatus.map(item => item.total);
                        labels.push('Total All');
                        totals.push(data.totalAll);

                        doughnutChart.data.labels = labels;
                        doughnutChart.data.datasets[0].data = totals;
                        doughnutChart.update();

                        barChart.data.labels = labels;
                        barChart.data.datasets[0].data = totals;
                        barChart.update();
                    });
                }

                // Date input change handler to reload data
                $('#pc-daterangepicker-1').on('change', function() {
                    const selectedDate = $(this).val();
                    updateDashboardData(selectedDate);
                    table.ajax.reload(); // Reload table data with new date
                });

                // Initialize dashboard data on page load
                updateDashboardData($('#pc-daterangepicker-1').val());

                // Initialize charts
                const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
                const doughnutChart = new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Total by Status',
                            data: [],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Total by Status'
                            }
                        }
                    }
                });

                const ctxBar = document.getElementById('barChart').getContext('2d');
                const barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Total by Status',
                            data: [],
                            backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Total by Status'
                            }
                        }
                    }
                });

                // Initialize DataTable with date filter
                let table = $('#data-table').DataTable({
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All']
                    ],
                    dom: 'Blfrtip',
                    buttons: [{
                        extend: 'copy',
                        title: () => 'Filtered Report ' + $('#pc-daterangepicker-1').val()
                    }, {
                        extend: 'excel',
                        title: () => 'Filtered Report ' + $('#pc-daterangepicker-1').val()
                    }],
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('dashboard.table') }}",
                        data: d => {
                            d.tanggal = $('#pc-daterangepicker-1').val();
                        } // Pass date as a parameter
                    },
                    columns: [{
                            data: "nama_pemohon",
                            name: "nama_pemohon"
                        },
                        {
                            data: "desa",
                            name: "desa"
                        },
                        {
                            data: "kecamatan",
                            name: "kecamatan"
                        },
                        {
                            data: "no_berkas",
                            name: "no_berkas"
                        },
                        {
                            data: "di_302",
                            name: "di_302"
                        },
                        {
                            data: "tahun",
                            name: "tahun",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: "luas",
                            name: "luas"
                        },
                        {
                            data: "jenis_kegiatan",
                            name: "jenis_kegiatan"
                        },
                        {
                            data: "petugas_ukur_utama",
                            name: "petugas_ukur_utama"
                        },
                        {
                            data: "tanggal_mulai_pengukuran",
                            name: "tanggal_mulai_pengukuran"
                        },
                        {
                            data: 'created_by',
                            name: 'created_by',
                            render: data => data?.name ?? '-'
                        }
                    ],
                });
            });
        </script>
    @endpush

@endpush

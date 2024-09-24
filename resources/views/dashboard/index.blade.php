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
    </div>
@endsection
@push('script-page')
    <script>
        $(document).ready(function() {
            $.get("{{ route('dashboard.index') }}", function(data) {
                // Prepare data for Doughnut Chart
                let labels = [];
                let totals = [];

                data.totalByStatus.forEach(item => {
                    labels.push(item.status); // Assuming status is a string
                    totals.push(item.total);
                });

                // Add total all to the labels and totals for Doughnut Chart
                labels.push('Total All'); // Add total all label
                totals.push(data.totalAll); // Add total all count

                // Doughnut Chart
                const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
                const doughnutChart = new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total by Status',
                            data: totals,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)' // Add another color for total all
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)' // Add another color for total all
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Total by Status'
                            }
                        }
                    }
                });

                // Bar Chart
                const ctxBar = document.getElementById('barChart').getContext('2d');
                const barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total by Status',
                            data: totals,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)', // Red
                                'rgba(54, 162, 235, 0.2)', // Blue
                                'rgba(255, 206, 86, 0.2)', // Yellow
                                'rgba(75, 192, 192, 0.2)', // Green
                                'rgba(153, 102, 255, 0.2)', // Purple
                                'rgba(255, 159, 64, 0.2)', // Orange
                                // Add more colors if needed based on the number of bars
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)', // Red
                                'rgba(54, 162, 235, 1)', // Blue
                                'rgba(255, 206, 86, 1)', // Yellow
                                'rgba(75, 192, 192, 1)', // Green
                                'rgba(153, 102, 255, 1)', // Purple
                                'rgba(255, 159, 64, 1)', // Orange
                                // Add matching border colors for each bar
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
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Total by Status'
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush

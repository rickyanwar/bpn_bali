@extends('layouts.kiosk')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo:wght@700&display=swap');

        .btn-blue {
            color: #fff;
            background-color: #0065D0;
            border-color: #0065D0;
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 21px;
        }

        .btn-yellow-dark {
            color: #fff;
            background-color: #A05E03;
            border-color: #A05E03;
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 21px;
        }


        .btn-success-dark {
            color: #fff;
            background-color: #198155;
            border-color: #198155;
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 21px;
        }

        .btn-block {
            display: block;
            width: 100%;
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 21px;
            color: #fff;
            border-radius: 10px;
        }

        .font-number {
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 40px;
        }

        .card-body .font-number {
            font-size: 41px;
        }

        .bg-blue-light {
            background-color: #C9F0FF;
        }

        .bg-yellow-light {
            background-color: #FFC462;
        }

        .bg-yellow {
            background-color: #FFDE15;
        }

        .bg-green-light {
            background-color: #7DDE86;
        }


        .card-body h4 {
            font-size: 21px;
        }

        .pemohon-today-marquee {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pemohon-today-item {
            display: inline-block;
            padding: 0 30px;
            font-weight: bold;
            font-size: 18px;
            color: #0065D0;
            animation: pemohon-marquee 15s linear infinite;
        }

        @keyframes pemohon-marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
    <div class="row">
        <!-- Kolom 1 (dibagi menjadi 2) -->
        <div class="col-md-4">
            <div class="row">
                <div class="col-12">
                    <div class="card text-center bg-yellow-light" style="border-radius: 15px;">
                        <div class="card-body ">
                            <div class="btn-yellow-dark btn-block p-2">BERKAS MASUK</div>
                            <h1 class="font-number p-3 m-0">34</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card text-center bg-green-light " style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="btn-block btn-success-dark p-2">BERKAS SELESAI</div>
                            <h1 class="font-number p-3 m-0">23</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card bg-yellow full-height" style="height: 100%; border-radius:15px">
                <div class="card-body">
                    <div class="btn-yellow-dark btn-block p-2">PEMOHON HARI INI</div>
                    <div class="marquee-container" id="pemohon-today-marquee">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dynamic-rows-container"></div>
@endsection
@push('extra-script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function fetchPendingJobsByRole() {
            $.ajax({
                url: "{{ route('dashboard.get.list') }}",
                type: "GET",
                success: function(roles) {
                    let container = $('#dynamic-rows-container');
                    container.empty(); // Clear the existing rows

                    // Iterate over each role and generate a separate row for each role
                    roles.forEach(role => {
                        if (role.users.length > 0) { // Ensure the role has users
                            // Create a row for this role
                            let roleRow = `
                                <div class="row mt-2 ">
                                    <div class="col-md-12">
                                        <div class="card text-center">
                                            <div class="btn-blue btn-block p-2">${role.name}</div>
                                            <div class="card-body p-0">
                                                <div class="row marquee-container" id="role-${role.id}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            // Append the row to the container (this will be one row per role)
                            container.append(roleRow);

                            // For each user in the role, append their card in the same row
                            role.users.forEach(user => {
                                let userCard = `
                                    <div class="col-md-3 marquee-content p-1 ">
                                        <div class="card bg-blue-light mb-0" style="border-radius: 15px;">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <h4 class="font-number mb-2">${user.total_pekerjaan}</h4>
                                                     <div class="btn-blue btn-block p-2">${user.name}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                // Append each user card to the current role's row
                                $(`#role-${role.id}`).append(userCard);
                            });
                        }
                    });
                },
                error: function() {
                    console.error("An error occurred while fetching pending jobs by role.");
                }
            });
        }


        function fetchPemohonToday() {
            $.ajax({
                url: "{{ route('dashboard.pemohon_today') }}",
                type: "GET",
                success: function(data) {
                    console.log('data', data);
                    let container = $('.pemohon-today-marquee');
                    container.empty();

                    data.forEach(nama_pemohon => {
                        let nameItem = `
                    <div class="pemohon-today-item">
                        <span>${nama_pemohon}</span>
                        <span style="font-size: 14px; color: #888; margin-left: 5px;">(Today)</span>
                    </div>
                `;
                        container.append(nameItem);
                    });
                },
                error: function() {
                    console.error("An error occurred while fetching 'Pemohon Today'.");
                }
            });
        }

        // every 3 minutes
        setInterval(fetchPemohonToday, 200000);
        fetchPemohonToday();


        setInterval(fetchPendingJobsByRole, 180000);
        // Initial fetch
        fetchPendingJobsByRole();
    </script>
@endpush

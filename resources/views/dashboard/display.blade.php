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

        .panggilan-dinas-container {
            font-family: 'Exo', sans-serif;
            font-weight: bold;
            font-size: 25px;
            color: #A05E03;
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

        .marquee-content .btn-block {
            border-radius: 0px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;

        }

        .font-number {
            font-family: 'Exo', sans-serif;
            font-size: 0px;
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


        .panggilan-dinas-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            /* Space between items */
            transition: opacity 0.5s ease;
            /* Smooth fade transition */
        }

        .panggilan-item {
            display: inline-block;
            margin-right: 10px;
            opacity: 1;
        }

        .fade-container {
            position: absolute;
            width: 100%;
            top: 0;
        }

        .nama-pemohon {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 100%;
            margin: 0;
            line-height: 0.8;
            /* Remove any default margins */
            padding: 0;
            /* Ensures it will fit within the column */
        }

        .pemohon-detail {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            margin: 0;
            line-height: 0.9;
            /* Remove any default margins */
            padding: 0 max-width: 100%;
            font-size: 17px;
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


        #logo h1 {

            font-size: 65px;
            color: #f0e8e8;
            font-family: 'Exo', sans-serif;
            text-transform: uppercase
        }



        .marquee-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 20px;
            /* Add spacing between items */
            white-space: nowrap;

            /* Prevents wrapping */
            {{--  animation: marquee 50s linear infinite;  --}}
            /* Adjust speed here */
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
                /* Start from the far right */
            }

            100% {
                transform: translateX(-100%);
                /* Move to the far left */
            }
        }

        .marquee-item {
            flex: 0 0 auto;
            /* Prevents items from shrinking */
            min-width: 200px;
            /* Adjust this as needed to fit items */
            /* Additional item-specific styling */
        }




        .user-card {
            margin: 20px;
            /* Adds margin around the user card */
            padding: 15px;

        }
    </style>
    <div class="row">
        <!-- Kolom 1 (dibagi menjadi 2) -->
        <div class="col-md-4">
            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('assets/images/smart-logo-with-tag.png') }}" alt="{{ env('APP_NAME') }}"
                        class="logo logo-lg" style="max-width: 55%; max-height:100%" />
                </div>
                <div class="col-12">
                    <div class="card text-center bg-yellow-light" style="border-radius: 15px;">
                        <div class="card-body ">
                            <div class="btn-yellow-dark btn-block p-2">BERKAS MASUK</div>
                            <h1 class="font-number p-3 m-0" id="berkas-masuk"></h1>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card text-center bg-green-light " style="border-radius: 15px;">
                        <div class="card-body">
                            <div class="btn-block btn-success-dark p-2">BERKAS SELESAI</div>
                            <h1 class="font-number p-3 m-0 " id="berkas-selesai"></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 ">
            <div class="card bg-yellow full-height" style="height: 100%; border-radius:15px">
                <div class="card-body">
                    @php
                        use Carbon\Carbon;
                        Carbon::setLocale('id');
                        $formattedDate = Carbon::now()->translatedFormat('l, d F Y');
                    @endphp

                    <div class="btn-yellow-dark btn-block p-2">PANGGILAN DINAS HARI INI | {{ $formattedDate }}</div>
                    <div class="row panggilan-dinas-container ml-2"></div>
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
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card text-center">
                                    <div class="btn-blue btn-block p-2 text-uppercase">BERKAS DI ${role.name}</div>
                                    <div class="card-body p-0">
                                        <marquee>
                                             <div class="marquee-container" id="role-${role.id}">
                                        </div>
                                        </marquee>
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
                            <div class="col-md-2 marquee-content p-1">
                                <div class="card bg-blue-light mb-0" style="border-radius: 15px;">
                                    <div class="card-body p-0">
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


        //update every 10 minutes
        setInterval(fetchPendingJobsByRole, 600000);
        // Initial fetch
        fetchPendingJobsByRole();


        $(document).ready(function() {
            const $container = $('.panggilan-dinas-container');
            const batchSize = 6; // Show 6 items at a time
            let currentIndex = 0;
            let data = [];

            function fetchDataPanggilanDinas() {
                // Simulate AJAX call with a timeout
                $.ajax({
                    url: "{{ route('dashboard.panggilan_dinas_today') }}", // Your API endpoint
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Assuming response is an array of objects
                        data = response;
                        // Reset the index to start from the beginning
                        currentIndex = 0;
                        // Update the display with new data
                        updateMarqueePanggilanDinas();
                    },
                    error: function() {
                        console.error('Failed to fetch data');
                    }
                });
            }

            function updateMarqueePanggilanDinas() {
                // Clear the container
                $container.empty();

                // Check if there's data available
                if (data.length === 0) {
                    $container.append('<div class="col-6"><p>Tidak Ada Panggilan</p></div>');
                    return;
                }

                // Create a single col-6 div to hold the items
                let colHtml = '<div class="col-6">';

                // Determine how many items to display based on data length
                const itemsToShow = Math.min(batchSize, data.length);

                for (let i = 0; i < itemsToShow; i++) {
                    const itemIndex = (currentIndex + i) % data.length;
                    const item = data[itemIndex];

                    // Create new HTML structure for each item with numbering
                    colHtml += `
                <div class="panggilan-item">
                    <div class="nama-pemohon">${(currentIndex + i + 1)}. ${item?.nama_pemohon}</div>
                    <div class="pemohon-detail">${item?.no_berkas} | ${item?.desa} | ${item?.kecamatan} </div>
                </div>
            `;
                }

                colHtml += '</div>'; // Close the col-6 div

                // Append the column to the container
                $container.append(colHtml);

                // Update currentIndex to the start of the next batch
                currentIndex = (currentIndex + batchSize) % data.length;
            }

            // Initial data fetch
            fetchDataPanggilanDinas();

            // Fetch new data every 5 minutes (300000 milliseconds)
            setInterval(fetchDataPanggilanDinas, 300000);

            // Update the marquee every 10 seconds
            setInterval(updateMarqueePanggilanDinas, 10000);




            function updateBerkasCounts() {
                // Replace this URL with your actual API endpoint
                $.ajax({
                    url: "{{ route('dashboard.berkas_count') }}", // Your API endpoint for fetching counts
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Assuming the response has berkas_masuk and berkas_selesai properties
                        $('#berkas-masuk').text(response.berkas_masuk);
                        $('#berkas-selesai').text(response.berkas_selesai);
                    },
                    error: function() {
                        console.error('Failed to fetch data');
                    }
                });
            }

            // Initial data fetch
            updateBerkasCounts();

            // Fetch new data every 10 minutes (600000 milliseconds)
            setInterval(updateBerkasCounts, 600000);
        });
    </script>
@endpush

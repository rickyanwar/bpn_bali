@extends('layouts.kiosk')

@section('content')
    <div class="row" id="pending-jobs-by-role">

    </div>
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
                    let container = $('#pending-jobs-by-role');
                    container.empty(); // Clear the existing list

                    roles.forEach(role => {
                        if (role.users.length > 0) { // Check if the role has any users
                            // Create a marquee container for all users in this role
                            container.append(
                                `<h2>${role.name}</h2>
                         <div class="marquee-container">
                             <div class="marquee-content" id="role-${role.id}"></div>
                         </div>`
                            );

                            // Add users within the marquee content
                            role.users.forEach(user => {
                                $(`#role-${role.id}`).append(
                                    `<div class="col-md-4 d-inline-block user-card">
                                <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 4px 24px 0 rgb(0 0 0 / 10%);">
                                    <div class="card-body">
                                        <div class="row mx-auto text-center mx-3">
                                            <div class="col-12">
                                                <div class="numbers">
                                                    <h4 class="title-onqueues mb-2">${user.total_pekerjaan}</h4>
                                                    <h4 class="title-onqueues mb-2">${user.name}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                                );
                            });
                        }
                    });
                },
                error: function() {
                    console.error("An error occurred while fetching pending jobs by role.");
                }
            });
        }


        // Fetch pending jobs by role every 2 seconds
        setInterval(fetchPendingJobsByRole, 180000);

        // Initial fetch
        fetchPendingJobsByRole();
    </script>
@endpush

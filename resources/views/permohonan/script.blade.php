<script>
    var selector = "body";

    // Function to initialize Select2 with AJAX
    function initializeSelect2($element, selectedValue = null) {
        $element.select2({
            ajax: {
                url: "{{ route('user.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response.data.data.map(function(user) {
                            return {
                                id: user.id,
                                text: user.name
                            };
                        })
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Pengguna',
            allowClear: true
        });

        // If we have a selected value, set it as the default selected option
        if (selectedValue) {
            const option = new Option(selectedValue.text, selectedValue.id, true, true);
            $element.append(option).trigger('change'); // Append and trigger change to display the selected option
        }
    }



    // Initialize repeater
    var $repeater = $(".repeater").repeater({
        show: function() {
            $(this).slideDown();
            initializeSelect2($(this).find('.petugas_ukur'));
            initializeSelect2($(this).find('.pendamping'));
        },
        hide: function(deleteElement) {
            if (confirm("Are you sure you want to delete this element?")) {
                $(this).slideUp(deleteElement);
            }
        }
    });

    // Retrieve the value from the data attribute and parse it
    var value = $(".repeater").attr('data-value');

    if (value && value.length) {
        value = JSON.parse(value); // Parse the JSON string

        // Populate repeater with the existing data
        $repeater.setList(value);

        // Loop through each repeater item and set the selected values for Select2
        value.forEach(function(item, index) {
            console.log('item', item);
            console.log('index', index)
            var $repeaterItem = $('[data-repeater-item]').eq(index);

            // Initialize Select2 for petugas_ukur and pendamping
            var petugasUkurSelect = $repeaterItem.find('.petugas_ukur');
            var pendampingSelect = $repeaterItem.find('.pendamping');

            // Set the selected option for petugas_ukur
            initializeSelect2(petugasUkurSelect, {
                id: item.petugas.id,
                text: item.petugas.name
            });

            // Set the selected option for pendamping_ukur
            initializeSelect2(pendampingSelect, {
                id: item.petugas_pendamping.id,
                text: item.petugas_pendamping.name
            });
        });
    }




    $(document).ready(function() {


        // Event handler for province select change
        $('#provinsi').on('change', function() {
            var kodeProvinsi = $('#provinsi option:selected').attr('data-id')
            if (kodeProvinsi) {
                loadKabupaten(kodeProvinsi);
            } else {
                // Clear the city and district select options
                $('#kabupaten').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });

        // Event handler for city select change
        $('#kabupaten').on('change', function() {
            var kabupatenId = $('#kabupaten option:selected').attr('data-id');
            if (kabupatenId) {
                loadKecamatan(kabupatenId);
            } else {
                // Clear the district select options
                $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });

        // Event handler for city select change
        $('#kecamatan').on('change', function() {
            var kodeKecamatan = $('#kecamatan option:selected').attr('data-id');

            if (kodeKecamatan) {
                loadDesa(kodeKecamatan);
            } else {
                // Clear the district select options
                $('#desa').empty().append('<option value="">Pilih Desa</option>');
            }
        });
    });




    // Function to load cities based on the selected province
    function loadKabupaten(kodeProvinsi, selectedKabupaten) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: "{{ route('regional.kota') }}",
                type: 'GET',
                data: {
                    provinsi: kodeProvinsi
                },
                success: function(data) {
                    // Clear the city select options
                    $('#kabupaten').empty().append(
                        '<option value="">Select Kabupaten</option>');

                    // Add new city options
                    $.each(data.data.items, function(index, data) {
                        $('#kabupaten').append(
                            `<option data-id="${data.kode}" value="${data.nama}">${data.nama}</option>`
                        );
                    });

                    // Trigger the change event on the city select to load districts
                    $('#kabupaten').trigger('change');
                    if (selectedKabupaten) {
                        $('#kabupaten').val(selectedKabupaten).trigger('change');
                    }

                    resolve();

                }
            });

        });
    }

    // Function to load districts based on the selected city
    function loadKecamatan(kabupatenId, selectedKecamatan) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '{{ route('regional.kecamatan') }}',
                type: 'GET',
                data: {
                    kabupaten: "51.02"
                },
                success: function(data) {
                    // Clear the district select options
                    $('#kecamatan').empty().append(
                        '<option value="">Pilih Kecamatan</option>');
                    $('#desa').empty().append(
                        '<option value="">Pilih Desa</option>');
                    // Add new district options
                    $.each(data.data.items, function(index, data) {
                        $('#kecamatan').append(
                            `<option data-id="${data.kode}" value="${data.nama}">${data.nama}</option>`
                        );
                    });
                    if (selectedKecamatan) {
                        $('#kecamatan').val(selectedKecamatan).trigger('change');
                    }
                    resolve();
                }
            });

        });
    }

    function loadDesa(kodeKecamatan, selectedDesa) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '{{ route('regional.desa') }}',
                type: 'GET',
                data: {
                    kecamatan: kodeKecamatan
                },
                success: function(data) {
                    // Clear the district select options
                    $('#desa').empty().append(
                        '<option value="">Pilih Desa</option>');

                    // Add new district options
                    $.each(data.data.items, function(index, data) {
                        $('#desa').append(
                            `<option data-id="${data.kode}" value="${data.nama}">${data.nama}</option>`
                        );
                    });
                    if (selectedDesa) {
                        $('#desa').val(selectedDesa).trigger('change');
                    }
                    resolve();
                }
            });

        });
    }


    $('#petugas_ukur').select2({
        ajax: {
            url: "{{ route('user.search') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                console.log('Params:', params); // Debug: Log the search term
                return {
                    term: params.term,
                    //role: 'company'
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
        placeholder: 'Select a user',
        allowClear: true
    });
</script>

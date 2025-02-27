<script>
    var selector = "body";


    // Function to initialize Select2 with or without AJAX
    function initializeSelect2($element, selectedValue = null, useAjax = true) {
        $element.select2({
            ajax: {
                url: "{{ route('user.search') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term,
                        role: "Petugas Ukur"
                    };
                },
                processResults: function(response) {
                    return {
                        results: response.data.data.map(function(user) {
                            return {
                                id: user.id,
                                text: user.name,
                                data: user
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
            // option.dataset.user = JSON.stringify(selectedValue.user); // Assuming user data is available
            $element.append(option).trigger('change'); // Append and trigger change to display the selected option
        }
    }

    // Initialize repeater
    var $repeater = $(".repeater").repeater({
        show: function() {
            // Check the current number of repeater items
            var currentRepeaterCount = $("[data-repeater-item]").length;
            if (currentRepeaterCount >= 5) {
                alert("Petugas Ukur Maximal 4.");
                return; // Prevent adding new element
            }

            $(this).slideDown();

            const $petugasUkurSelect = $(this).find('.petugas_ukur');
            initializeSelect2($petugasUkurSelect); // Initialize petugas_ukur with AJAX search

            $petugasUkurSelect.on('change', function() {
                const $this = $(this);
                const selectedPetugas = $this.select2('data')[0]; // Get selected data
                // Find the nearest pendamping select element
                const $pembantuUkur = $this.closest('[data-repeater-item]').find('.pembantu_ukur');
                if (selectedPetugas) {
                    // Assuming you want to set the pendamping to the selected petugas
                    $pembantuUkur.empty(); // Clear previous options
                    $pembantuUkur.val('');
                    if (selectedPetugas?.data?.pembantu_ukur) {
                        $pembantuUkur.val(selectedPetugas?.data?.pembantu_ukur ?? $pembantuUkur.val(
                            ''));
                    }
                } else {
                    $pembantuUkur.empty().trigger('change'); // Clear if no selection
                }
            });
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

        // Loop through each repeater item and set the selected values for Select2
        value?.forEach(function(item, index) {
            var $repeaterItem = $('[data-repeater-item]').eq(index);
            // Initialize Select2 for petugas_ukur and pendamping
            var petugasUkurSelect = $repeaterItem.find('.petugas_ukur');
            var pembantuUkur = $repeaterItem.find('.pembantu_ukur');

            // Set the selected option for petugas_ukur
            initializeSelect2(petugasUkurSelect, {
                id: item.petugas.id,
                text: item.petugas.name,
                data: item
            });

            pembantuUkur.val(item.petugas.pembantu_ukur)
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
                        $('#kecamatan').val(selectedKecamatan.nama).trigger('change');
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
                        $('#desa').val(selectedDesa.nama).trigger('change');
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

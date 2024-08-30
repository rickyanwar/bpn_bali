<script>
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
</script>

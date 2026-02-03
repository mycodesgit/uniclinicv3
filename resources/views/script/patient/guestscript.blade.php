<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Hide button by default on page load
        document.getElementById('btn-guestpatient').classList.add('d-none');

        // If outsiders tab is active on load, show it
        const activeTab = document.querySelector('a[data-bs-toggle="tab"].active');
        if (activeTab && activeTab.getAttribute('href') === '#outsiders') {
            document.getElementById('btn-guestpatient').classList.remove('d-none');
        }
    });

    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {

            // Always hide first
            document.getElementById('btn-guestpatient').classList.add('d-none');

            // Show ONLY for outsiders tab
            if (e.target.getAttribute('href') === '#outsiders') {
                document.getElementById('btn-guestpatient').classList.remove('d-none');
            }
        });
    });
</script>


<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };
    $(document).ready(function() {
        $('#guestpatientform').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{route('patients.create') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('guestAdded');
                        $('#guestpatientform')[0].reset();
                        $('#new_patient_outsider').offcanvas('hide');
                    } else {
                        toastr.error(response.message);
                        console.log(response);
                    }
                },
                error: function(xhr, status, error, message) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        var dataTable = $('#guesttabletab').DataTable({
            "ajax": {
                "url": "{{ route('patients.showguest') }}",
                "type": "GET",
            },
            "bFilter": true,
			"sDom": 'fBtlpi',  
			"ordering": true,
			"language": {
				search: ' ',
				sLengthMenu: '_MENU_',
				searchPlaceholder: "Search",
				sLengthMenu: 'Row Per Page _MENU_ Entries',
				info: "_START_ - _END_ of _TOTAL_ items",
				paginate: {
					next: '<i class="ti ti-arrow-right"></i>',
					previous: '<i class="ti ti-arrow-left text-body"></i> '
				},
			},
			"scrollX": false,         // Enable horizontal scrolling
			"scrollCollapse": true,  // Adjust table size when the scroll is used
			"responsive": false,
			"autoWidth": false,
            "info": true,
            "columns": [
                {data: 'patientID'},
                { 
                    data: null,
                    render: function(data, type, row) {
                        var firstname = data.fname;
                        var middleInitial = data.mname ? data.mname.substr(0, 1) + '.' : '';
                        // Only display ext if it's not null, not 'N/A', and not empty
                        var ext = (data.ext && data.ext !== 'N/A') ? ' ' + data.ext : '';
                        var lastNameWithExt = data.lname + ext;
                        return firstname + ' ' + middleInitial + ' ' + lastNameWithExt;
                    }
                },
                {data: 'gender'},
                {data: 'civil_status'},
                {data: 'address'},
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="btn-group" role="group">' +
                                '<button type="button" class="btn btn-teal btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>' +
                                '<ul class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-mededit" data-id="' + row.id + '" data-category="' + row.category + '" data-medicine="' + row.medicine + '" data-qty="' + row.qty + '" data-measure="' + row.measure + '" data-lotno="' + row.lotno + '" data-expirydate="' + row.expirydate + '" data-refnoid="' + row.refnoid + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item med-delete">' +
                                '<i class="fas fa-trash"></i> Delete' +
                                '</button>' +
                                '</ul>' +
                                '</div>';
                            return dropdown;
                        } else {
                            return data;
                        }
                    },
                },
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('guestAdded', function() {
            dataTable.ajax.reload();
        });
    });
</script>

<script>
    var provincesRoute = "{{ route('getPortalProvinces', '') }}";
    var citiesRoute = "{{ route('getPortalCities', '') }}";
    var barangaysRoute = "{{ route('getPortalBarangays', '') }}";

    function updateAddress() {
        let hnum = $('#viewdatastudHnum').val(); // house number input
        let barangay = $('#barangay').find(':selected').data('name');
        let city = $('#city').find(':selected').data('name');
        let province = $('#province').find(':selected').data('name');
        let region = $('#region').find(':selected').data('name');
        let zipcode = $('#zipcode').val(); // hidden or text input for zip

        // Filter out undefined or empty values, then join with comma
        let fullAddress = [hnum, barangay, city, province, region, zipcode].filter(Boolean).join(', ');

        $('#viewdatastudAddress').val(fullAddress).trigger('change');
        $('#viewdatastudHnum').on('input', updateAddress);
    }

    
    $(document).ready(function () {
        $('#viewdatastudHnum').on('input', updateAddress);
    });

    $(document).ready(function () {
        $('#region').on('change', function () {
            var regionId = $(this).val();
            var regionName = $(this).find(':selected').data('name');
            $('#region_name').val(regionName).trigger('change');
            updateAddress(); // Update address

            $('#province').empty().append('<option disabled selected>Loading...</option>');
            $.get(provincesRoute + '/' + regionId, function (data) {
                $('#province').html('<option disabled selected>Select Province</option>');
                data.forEach(p => $('#province').append(`<option value="${p.province_id}" data-name="${p.name}">${p.name}</option>`));
            });
        });

        $('#province').on('change', function () {
            var provinceId = $(this).val();
            var provinceName = $(this).find(':selected').data('name');
            $('#province_name').val(provinceName).trigger('change');
            updateAddress(); // Update address

            $('#city').empty().append('<option disabled selected>Loading...</option>');
            $.get(citiesRoute + '/' + provinceId, function (data) {
                $('#city').html('<option disabled selected>Select City</option>');
                data.forEach(c => $('#city').append(`<option value="${c.city_id}" data-name="${c.name}" data-zip="${c.zip_code}">${c.name}</option>`));
            });
        });

        $('#city').on('change', function () {
            var cityName = $(this).find(':selected').data('name');
            var zip = $(this).find(':selected').data('zip') || '';

            $('#city_name').val(cityName).trigger('change');
            $('#zipcode').val(zip).trigger('change');
            updateAddress(); // Update address

            var cityId = $(this).val();
            $('#barangay').empty().append('<option disabled selected>Loading...</option>');
            $.get(barangaysRoute + '/' + cityId, function (data) {
                $('#barangay').html('<option disabled selected>Select Barangay</option>');
                data.forEach(b => $('#barangay').append(`<option value="${b.id}" data-name="${b.name}" style="text-transform: uppercase;">${b.name}</option>`));
            });
        });

        $('#barangay').on('change', function () {
            var brgyName = $(this).find(':selected').data('name');
            $('#brgy_name').val(brgyName).trigger('change');
            updateAddress(); // Update address
        });
    });
    
</script>


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

        $('#viewdatastudAddress').val(fullAddress);
        $('#viewdatastudHnum').on('input', updateAddress);
    }

    $(document).ready(function () {
        $('#region').on('change', function () {
            var regionId = $(this).val();
            var regionName = $(this).find(':selected').data('name');
            $('#region_name').val(regionName);
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
            $('#province_name').val(provinceName);
            updateAddress(); // Update address

            $('#city').empty().append('<option disabled selected>Loading...</option>');
            $.get(citiesRoute + '/' + provinceId, function (data) {
                $('#city').html('<option disabled selected>Select City</option>');
                data.forEach(c => $('#city').append(`<option value="${c.city_id}" data-name="${c.name}" data-zip="${c.zip_code}">${c.name}</option>`));
            });
        });

        $('#city').on('change', function () {
            var cityName = $(this).find(':selected').data('name');
            var zip = $(this).find(':selected').data('zip');

            $('#city_name').val(cityName);
            $('#zipcode').val(zip || '');
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
            $('#brgy_name').val(brgyName);
            updateAddress(); // Update address
        });
    });
    
</script>

<script>
    var provincesRoute = "{{ route('getPortalProvinces', '') }}";
    var citiesRoute = "{{ route('getPortalCities', '') }}";
    var barangaysRoute = "{{ route('getPortalBarangays', '') }}";

    function updategAddress() {
        let ghnum = $('#gviewdatastudHnum').val(); // house number input
        let gbarangay = $('#gbarangay').find(':selected').data('name');
        let gcity = $('#gcity').find(':selected').data('name');
        let gprovince = $('#gprovince').find(':selected').data('name');
        let gregion = $('#gregion').find(':selected').data('name');
        let gzipcode = $('#gzipcode').val(); // hidden or text input for zip

        // Filter out undefined or empty values, then join with comma
        let fullAddress1 = [ghnum, gbarangay, gcity, gprovince, gregion, gzipcode].filter(Boolean).join(', ');

        $('#gviewdatastudAddress').val(fullAddress1);
        $('#gviewdatastudHnum').on('input', updategAddress);
    }

    $(document).ready(function () {
        $('#gregion').on('change', function () {
            var regionId = $(this).val();
            var regionName = $(this).find(':selected').data('name');
            $('#gregion_name').val(regionName);
            updategAddress(); // Update address

            $('#gprovince').empty().append('<option disabled selected>Loading...</option>');
            $.get(provincesRoute + '/' + regionId, function (data) {
                $('#gprovince').html('<option disabled selected>Select Province</option>');
                data.forEach(p => $('#gprovince').append(`<option value="${p.province_id}" data-name="${p.name}">${p.name}</option>`));
            });
        });

        $('#gprovince').on('change', function () {
            var provinceId = $(this).val();
            var provinceName = $(this).find(':selected').data('name');
            $('#gprovince_name').val(provinceName);
            updategAddress(); // Update address

            $('#gcity').empty().append('<option disabled selected>Loading...</option>');
            $.get(citiesRoute + '/' + provinceId, function (data) {
                $('#gcity').html('<option disabled selected>Select City</option>');
                data.forEach(c => $('#gcity').append(`<option value="${c.city_id}" data-name="${c.name}" data-zip="${c.zip_code}">${c.name}</option>`));
            });
        });

        $('#gcity').on('change', function () {
            var cityName = $(this).find(':selected').data('name');
            var zip = $(this).find(':selected').data('zip');

            $('#gcity_name').val(cityName);
            $('#gzipcode').val(zip || '');
            updategAddress(); // Update address

            var cityId = $(this).val();
            $('#gbarangay').empty().append('<option disabled selected>Loading...</option>');
            $.get(barangaysRoute + '/' + cityId, function (data) {
                $('#gbarangay').html('<option disabled selected>Select Barangay</option>');
                data.forEach(b => $('#gbarangay').append(`<option value="${b.id}" data-name="${b.name}" style="text-transform: uppercase;">${b.name}</option>`));
            });
        });

        $('#gbarangay').on('change', function () {
            var brgyName = $(this).find(':selected').data('name');
            $('#gbrgy_name').val(brgyName);
            updategAddress(); // Update address
        });
    });
    
</script>
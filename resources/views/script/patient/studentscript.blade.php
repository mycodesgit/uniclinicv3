<script>
    $(document).ready(function() {
        $('.update-field').on('change', function() {
            var elementType = $(this).prop('tagName').toLowerCase();
            if (elementType === 'input' || elementType === 'textarea') {
                columnid = $(this).data('column-id');
                columnname = $(this).data('column-name');
            } else if (elementType === 'select') {
                columnid = $(this).find('option:selected').data('column-id');
                columnname = $(this).find('option:selected').data('column-name');
            }

            var value = $(this).val();

            $.ajax({
                url: '{{ route("patients.update") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: columnid,
                    column: columnname,
                    value: value
                },
                success: function(response) {
                    
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        console.error('Validation errors:', errors);
                    } else {
                        console.error('Error:', error);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $('.update-field1').on('change', function() {
            var columnId = $(this).data('column-id');
            var columnName = $(this).data('column-name');
            var value = $(this).val();
            var dataArray = $(this).data('array'); // Add this line

            $.ajax({
                url: "{{ route('patients.studentsHistory') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: columnId,
                    column: columnName,
                    value: value,
                    data_array: dataArray // Add this line
                },
                success: function(response) {
                    
                }
            });
        });
    });
</script>

<script>
    // Function to get BMI category based on BMI value
    function getBMICategory(bmi) {
        if (bmi < 16.0) {
            document.getElementById('bmi_cat').value = "Severely Underweight";    
        } else if (bmi >= 16.0 && bmi <= 18.4) {
            document.getElementById('bmi_cat').value = "Underweight";
        } else if (bmi >= 18.5 && bmi <= 24.9) {
            document.getElementById('bmi_cat').value = "Normal";
        } else if (bmi >= 25.0 && bmi <= 29.9) {
            document.getElementById('bmi_cat').value = "Overweight";
        } else if (bmi >= 30.0 && bmi <= 34.9) {
            document.getElementById('bmi_cat').value = "Moderately Obese";
        } else if (bmi >= 35.0 && bmi <= 39.9) {
            document.getElementById('bmi_cat').value = "Severely Obese";
        } else if (bmi >= 40.0) {
            document.getElementById('bmi_cat').value = "Morbidly Obese";
        } else {
            document.getElementById('bmi_cat').value = ''; 
        }
    }

    $(document).ready(function() {
        setInterval(function() {
            const bmiValue = parseFloat(document.getElementById('bmi').value); 
            getBMICategory(bmiValue);
        }, 100); 
    });
</script>

<script>
    // Function to calculate BMI
    function calculateBMI(weightKg, heightM) {
        if (weightKg && heightM) {
            var bmi = weightKg / (heightM * heightM);
            return bmi.toFixed(1); // Round BMI to one decimal point
        } else {
            return ""; 
        }
    }
    
    // Convert height from centimeters to feet and inches
    function convertHeight() {
        var cm = parseFloat(document.getElementById('height_cm').value);
        if (!isNaN(cm)) {
            var totalInches = cm / 2.54;
            var feet = Math.floor(totalInches / 12);
            var inches = Math.round(totalInches % 12); // Round inches to nearest whole number
            var formattedHeight = feet + "'" + inches + '"';
            document.getElementById('height_ft').value = formattedHeight;

            // Calculate BMI
            var weightKg = parseFloat(document.getElementById('weight_kg').value);
            var heightM = cm / 100; // Convert cm to meters for BMI calculation
            var bmi = calculateBMI(weightKg, heightM);
            document.getElementById('bmi').value = bmi; // Display BMI
        } else {
            document.getElementById('height_ft').value = '';
            document.getElementById('bmi').value = ''; // Clear BMI if height is N/A
        }
    }

    // Convert height from feet and inches to centimeters
    function convertHeightToFtIn() {
        var heightFt = document.getElementById('height_ft').value;
        if (heightFt) {
            var feet = parseFloat(heightFt.split("'")[0]);
            var inches = parseFloat(heightFt.split("'")[1].replace('"', ''));
            var totalInches = feet * 12 + inches;
            var cm = totalInches * 2.54;
            document.getElementById('height_cm').value = Math.round(cm); // Round cm to nearest whole number

            // Calculate BMI
            var weightKg = parseFloat(document.getElementById('weight_kg').value);
            var heightM = cm / 100; // Convert cm to meters for BMI calculation
            var bmi = calculateBMI(weightKg, heightM);
            document.getElementById('bmi').value = bmi; // Display BMI
        } else {
            document.getElementById('height_cm').value = '';
            document.getElementById('bmi').value = ''; // Clear BMI if height is N/A
        }
    }

    // Event listener for height in centimeters
    document.getElementById('height_cm').addEventListener('input', function() {
        convertHeight();
    });

    // Event listener for height in feet and inches
    document.getElementById('height_ft').addEventListener('input', function() {
        convertHeightToFtIn();
    });

    // Event listener for weight in kilograms
    document.getElementById('weight_kg').addEventListener('input', function() {
        var weightKg = parseFloat(this.value);
        if (!isNaN(weightKg)) {
            var weightLb = weightKg * 2.20462;
            document.getElementById('weight_lb').value = Math.round(weightLb); // Round weight in pounds
        } else {
            document.getElementById('weight_lb').value = '';
        }

        // Calculate BMI
        var heightCm = parseFloat(document.getElementById('height_cm').value);
        var bmi = calculateBMI(weightKg, heightCm / 100); // Convert cm to meters for BMI calculation
        document.getElementById('bmi').value = bmi; // Display BMI
    });

    // Event listener for weight in pounds
    document.getElementById('weight_lb').addEventListener('input', function() {
        var weightLb = parseFloat(this.value);
        if (!isNaN(weightLb)) {
            var weightKg = weightLb / 2.20462;
            document.getElementById('weight_kg').value = Math.round(weightKg); // Round weight in kilograms
        } else {
            document.getElementById('weight_kg').value = '';
        }

        // Calculate BMI
        var heightCm = parseFloat(document.getElementById('height_cm').value);
        var bmi = calculateBMI(weightKg, heightCm / 100); // Convert cm to meters for BMI calculation
        document.getElementById('bmi').value = bmi; // Display BMI
    });

    // Initial conversion on page load
    convertHeight();
</script>

<script>
    $(document).ready(function() {
        const walkinId = {{ request()->route('adid') }};

        var dataTable = $('#consultationTable').DataTable({
            "ajax": {
                "url": "{{ route('getwalkinconsult.walkin', ['adid' => '__ID__']) }}".replace('__ID__', walkinId),
                "type": "GET",
            },
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
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
                { data: 'date',
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return moment(data).format('MMMM D, YYYY');
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'time' },
                { data: 'complaintname' },
                { data: 'treatment' },
                { data: 'medicinename' },
                { data: 'qty' },
                // { 
                //     data: 'id',
                //     render: function(data, type, row) {
                //         if (type === 'display') {
                //             var editLink = '<a href="#" class="btn btn-outline-primary btn-sm btn-studdataview"  data-id="' + row.id + '" data-studid="' + row.stud_id + '" data-fname="' + row.fname + '" data-mname="' + row.mname + '" data-lname="' + row.lname + '" data-ext="' + row.ext + '" data-gender="' + row.gender + '" data-bday="' + row.bday + '" data-pbirth="' + row.pbirth + '" data-contact="' + row.contact + '" data-email="' + row.email + '" data-religion="' + row.religion + '" data-address="' + row.address + '" data-civil="' + row.civil_status + '" data-hnum="' + row.hnum + '" data-brgy="' + row.brgy + '" data-city="' + row.city + '" data-province="' + row.province + '" data-region="' + row.region + '" data-zcode="' + row.zcode + '" data-father="' + row.stud_father + '" data-mother="' + row.stud_mother + '" data-guardian="' + row.stud_guardian + '" data-income="' + row.monthly_income + '" data-pcontact="' + row.guardian_contact + '" data-lstschattended="' + row.lstsch_attended + '" data-lstschattendedyear="' + row.lst_sch_attended_year + '" data-suclstattended="' + row.suc_lst_attended + '" data-dateadmission="' + row.date_admission + '">' +
                //                 '<i class="ti ti-eye"></i>' +
                //                 '</a>';
                //             return editLink;
                //         } else {
                //             return data;
                //         }
                //     },
                // },
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('pvisitAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).ready(function() {
        const walkinId = {{ request()->route('adid') }};
        
        var dataTable = $('#referlisttab').DataTable({
            "ajax": {
                "url": "{{ route('getwalkinreferral.walkin', ['adid' => '__ID__']) }}".replace('__ID__', walkinId),
                "type": "GET",
            },
            // "bFilter": true,
			// "sDom": 'fBtlpi',  
			// "ordering": true,
			// "language": {
			// 	search: ' ',
			// 	sLengthMenu: '_MENU_',
			// 	searchPlaceholder: "Search",
			// 	sLengthMenu: 'Row Per Page _MENU_ Entries',
			// 	info: "_START_ - _END_ of _TOTAL_ items",
			// 	paginate: {
			// 		next: '<i class="ti ti-arrow-right"></i>',
			// 		previous: '<i class="ti ti-arrow-left text-body"></i> '
			// 	},
			// },
			// "scrollX": false,        
			// "scrollCollapse": true, 
			// "responsive": true,
			// "autoWidth": false,
            // "info": true,
            // "searching": false,
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
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
                {
                    data: 'date',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            var dateObj = new Date(data);
                            var options = { year: 'numeric', month: 'long', day: '2-digit' };
                            return dateObj.toLocaleDateString('en-US', options);
                        }
                        return data;
                    }
                },
                {data: 'time'},
                {data: 'preferfrom'},
                {data: 'preferto'},
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('referralAdded', function() {
            dataTable.ajax.reload();
        });
    });
</script>
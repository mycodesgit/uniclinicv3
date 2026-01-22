<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    };
    $(document).ready(function() {
        $('#adPVisit').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('appointment.walkinconsult.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        //console.log(response);
                        $(document).trigger('pvisitAdded');
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

        const walkinId = {{ $id }};

        var dataTable = $('#consultationTable').DataTable({
            "ajax": {
                "url": "{{ route('getwalkinconsult.walkin', ['id' => '__ID__']) }}".replace('__ID__', walkinId),
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
			"scrollX": true,         // Enable horizontal scrolling
			"scrollCollapse": true,  // Adjust table size when the scroll is used
			"responsive": true,
			"autoWidth": false,
            "info": true,
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
                { 
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var editLink = '<a href="#" class="btn btn-outline-primary btn-sm btn-studdataview"  data-id="' + row.id + '" data-studid="' + row.stud_id + '" data-fname="' + row.fname + '" data-mname="' + row.mname + '" data-lname="' + row.lname + '" data-ext="' + row.ext + '" data-gender="' + row.gender + '" data-bday="' + row.bday + '" data-pbirth="' + row.pbirth + '" data-contact="' + row.contact + '" data-email="' + row.email + '" data-religion="' + row.religion + '" data-address="' + row.address + '" data-civil="' + row.civil_status + '" data-hnum="' + row.hnum + '" data-brgy="' + row.brgy + '" data-city="' + row.city + '" data-province="' + row.province + '" data-region="' + row.region + '" data-zcode="' + row.zcode + '" data-father="' + row.stud_father + '" data-mother="' + row.stud_mother + '" data-guardian="' + row.stud_guardian + '" data-income="' + row.monthly_income + '" data-pcontact="' + row.guardian_contact + '" data-lstschattended="' + row.lstsch_attended + '" data-lstschattendedyear="' + row.lst_sch_attended_year + '" data-suclstattended="' + row.suc_lst_attended + '" data-dateadmission="' + row.date_admission + '">' +
                                '<i class="ti ti-eye"></i>' +
                                '</a>';
                            return editLink;
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
        $(document).on('pvisitAdded', function() {
            dataTable.ajax.reload();
        });
    });
</script>
<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };
    $(document).ready(function() {

        const walkinId = @json($emp_ID);

        var dataTable = $('#consultationTable').DataTable({
            "ajax": {
                "url": "{{ route('getwalkinempconsult.walkin', ['emp_ID' => '__ID__']) }}".replace('__ID__', walkinId),
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
                        var suffix = (data.suffix && data.suffix !== 'N/A') ? ' ' + data.suffix : '';
                        var lastNameWithExt = data.lname + suffix;
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
                {
                    data: 'time',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return moment(data, 'HH:mm').format('hh:mm A');
                        }
                        return data;
                    }
                },
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

    document.addEventListener('DOMContentLoaded', () => {
        const dynamicFieldsContainer = document.getElementById('dynamic-fields');
        const template = document.getElementById('medicine-row-template');
        const removeBtn = document.getElementById('myremove');
        const addBtn = document.querySelector('.add-button');

        if (!dynamicFieldsContainer || !template || !removeBtn || !addBtn) {
            return;
        }

        function toggleRemoveButton() {
            const rows = dynamicFieldsContainer.querySelectorAll('.row');
            removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }

        addBtn.addEventListener('click', () => {
            const fragment = template.content.cloneNode(true);
            dynamicFieldsContainer.appendChild(fragment);

            const selects = dynamicFieldsContainer.querySelectorAll('select.select2');
            $(selects[selects.length - 1]).select2({ width: '100%' });

            toggleRemoveButton();
        });

        removeBtn.addEventListener('click', () => {
            const rows = dynamicFieldsContainer.querySelectorAll('.row');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
            }
            toggleRemoveButton();
        });

        toggleRemoveButton();
    });

    window.addEventListener('DOMContentLoaded', () => {
        // Hide all buttons
        document.getElementById('btn-consult').classList.add('d-none');
        document.getElementById('btn-referral').classList.add('d-none');
        document.getElementById('btn-extraction').classList.add('d-none');

        // Show Consultation button by default
        document.getElementById('btn-consult').classList.remove('d-none');
    });

    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {

            // Hide all buttons
            document.getElementById('btn-consult').classList.add('d-none');
            document.getElementById('btn-referral').classList.add('d-none');
            document.getElementById('btn-extraction').classList.add('d-none');

            // Show button based on active tab
            const target = e.target.getAttribute('href');

            if (target === '#consult') {
                document.getElementById('btn-consult').classList.remove('d-none');
            } else if (target === '#referral') {
                document.getElementById('btn-referral').classList.remove('d-none');
            } else if (target === '#toothextraction') {
                document.getElementById('btn-extraction').classList.remove('d-none');
            }
        });
    });

</script>
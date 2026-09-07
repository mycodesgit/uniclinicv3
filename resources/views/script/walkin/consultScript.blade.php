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
                        $('#centermodalwalkinconsult').modal('hide');
                        $('#adPVisit')[0].reset();
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

        const walkinId = @json($adid);

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
                { data: 'code' },
                { data: 'qty' },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {

                            var buttons = `
                                <button type="button"
                                    class="btn btn-sm btn-success btn-walkineditconsult mr-1 text-light"
                                    data-id="${row.id}"
                                    data-date="${row.date}"
                                    data-time="${row.time}"
                                    data-chief_complaint="${row.chief_complaint}"
                                    data-bp="${row.bp}"
                                    data-pr="${row.pr}"
                                    data-rr="${row.rr}"
                                    data-spo="${row.spo}"
                                    data-btemp="${row.btemp}"
                                    data-lmp="${row.lmp}"
                                    data-pheight="${row.pheight}"
                                    data-pweight="${row.pweight}"
                                    data-treatment="${row.treatment}"
                                    data-medicine="${row.medicine}"
                                    data-qty="${row.qty}"
                                    data-certificate="${row.certificate}"
                                    title="View Forms">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-sm btn-danger btn-deletewalkin mr-1"
                                    value="${data}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            `;

                            return buttons;
                        }

                        return data;
                    }
                }
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

        // ------------------------------------
        // 1. OPEN MODAL & POPULATE DATA
        // ------------------------------------
        $(document).on('click', '.btn-walkineditconsult', function() {
            var id = $(this).data('id');
            var date = $(this).data('date');
            var time = $(this).data('time');
            let chiefComplaint = $(this).attr('data-chief_complaint');
            var bp = $(this).data('bp');
            var pr = $(this).data('pr');
            var rr = $(this).data('rr');
            var spo = $(this).data('spo');
            var btemp = $(this).data('btemp');
            var lmp = $(this).data('lmp');
            var pheight = $(this).data('pheight');
            var pweight = $(this).data('pweight');
            let treatment = $(this).attr('data-treatment');
            var certificate = $(this).data('certificate');
            
            // Parse CSV values into arrays
            var medicines = ($(this).attr('data-medicine') || '').split(',').filter(Boolean);
            var qtys = ($(this).attr('data-qty') || '').split(',').filter(Boolean);

            // Parse Chief Complaint (Handles array vs string properly for Select2)
            var selectedComplaints = [];
            if (chiefComplaint) {
                selectedComplaints = chiefComplaint.toString().split(',').map(item => item.trim());
            }

            // Fill standard form inputs
            $('#editWalkinConsultId').val(id);
            $('#editWalkinConsultDate').val(date);
            $('#editWalkinConsultTime').val(time);
            
            // Populate Select2 Chief Complaint
            $('#editWalkinConsultChiefComplaint').val(null).trigger('change');
            $('#editWalkinConsultChiefComplaint').val(selectedComplaints).trigger('change');

            $('#editWalkinConsultBP').val(bp);
            $('#editWalkinConsultPR').val(pr);
            $('#editWalkinConsultRR').val(rr);
            $('#editWalkinConsultSPO2').val(spo);
            $('#editWalkinConsultBTemp').val(btemp);
            $('#editWalkinConsultLMP').val(lmp);
            $('#editWalkinConsultPHeight').val(pheight);
            $('#editWalkinConsultPWeight').val(pweight);
            $('#editWalkinConsultTreatment').val(treatment);
            $('#editWalkinConsultCertificate1').prop('checked', certificate === 1);
            $('#editWalkinConsultCertificate2').prop('checked', certificate === 0);

            // Clear existing dynamic dynamic fields
            $('#dynamic-fieldsedit').empty();

            // Build dynamic rows using the HTML Template
            if (medicines.length > 0) {
                for (let i = 0; i < medicines.length; i++) {
                    addMedicineRow(medicines[i], qtys[i] || '');
                }
            } else {
                // If no medicines exist yet, add one empty row by default
                addMedicineRow('', '');
            }

            $('#editcentermodalwalkinconsult').modal('show');
        });


        // ------------------------------------
        // 2. HELPER FUNCTION TO ADD A ROW
        // ------------------------------------
        function addMedicineRow(selectedMedId = '', selectedQty = '') {
            var templateHtml = $('#medicine-row-templateedit').html();
            var $row = $(templateHtml);

            // Set the pre-selected values
            if (selectedMedId) {
                $row.find('select[name="medicine[]"]').val(selectedMedId);
            }
            if (selectedQty) {
                $row.find('input[name="qty[]"]').val(selectedQty);
            }

            // Append to the dynamic fields container
            $('#dynamic-fieldsedit').append($row);
        }


        // ------------------------------------
        // 3. ADD BUTTON CLICK
        // ------------------------------------
        $(document).on('click', '#editAddMedicine', function() {
            addMedicineRow('', '');
        });


        // ------------------------------------
        // 4. REMOVE BUTTON CLICK
        // ------------------------------------
        $(document).on('click', '#editRemoveMedicine', function() {
            var $rows = $('#dynamic-fieldsedit .row');
            
            // Remove the last row only if there is more than 1 row remaining
            if ($rows.length > 1) {
                $rows.last().remove();
            } else {
                // Optional: reset fields if it's the last row
                $rows.find('select').val('');
                $rows.find('input').val('');
            }
        });

    });

    $('#editPVisit').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: walkinconsultUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editcentermodalwalkinconsult').modal('hide');
                    $(document).trigger('pvisitAdded');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error, message) {
                var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                toastr.error(errorMessage);
            }
        });
    });

    $(document).on('click', '.btn-deletewalkin', function(e) {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: walkinconsultDeleteRoute.replace(':id', id),
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        if ($.fn.DataTable.isDataTable('#consultationTable')) {
                            $('#consultationTable').DataTable().ajax.reload(null, false);
                        } else {
                            $("#tr-" + id).fadeOut();
                        }
                        if(response.success) {
                            toastr.success(response.message);
                            console.log(response);
                        }
                    }
                });
            }
        })
    });

    document.addEventListener('DOMContentLoaded', () => {
        const dynamicFieldsContainer = document.getElementById('dynamic-fields');
        const template = document.getElementById('medicine-row-template');
        const removeBtn = document.getElementById('myremove');

        function toggleRemoveButton() {
            const rows = dynamicFieldsContainer.querySelectorAll('.row');
            removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }

        // ADD button
        document.querySelector('.add-button').addEventListener('click', () => {
            const fragment = template.content.cloneNode(true);
            dynamicFieldsContainer.appendChild(fragment);

            // Initialize select2 ONLY for the newly added select
            const selects = dynamicFieldsContainer.querySelectorAll('select.select2');
            $(selects[selects.length - 1]).select2({ width: '100%' });

            toggleRemoveButton();
        });

        // REMOVE button
        removeBtn.addEventListener('click', () => {
            const rows = dynamicFieldsContainer.querySelectorAll('.row');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
            }
            toggleRemoveButton();
        });

        // Hide remove button initially
        toggleRemoveButton();
    });

    window.addEventListener('DOMContentLoaded', () => {
        // hide all first
        document.getElementById('btn-consult').classList.add('d-none');
        document.getElementById('btn-referral').classList.add('d-none');
        document.getElementById('btn-extraction').classList.add('d-none');

        // show default (active tab)
        document.getElementById('btn-consult').classList.remove('d-none');
    });

    // listen to BUTTON tabs
    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {

            // hide all buttons
            document.getElementById('btn-consult').classList.add('d-none');
            document.getElementById('btn-referral').classList.add('d-none');
            document.getElementById('btn-extraction').classList.add('d-none');

            // get target correctly
            const target = e.target.getAttribute('data-bs-target');

            if (target === '#pills-one') {
                document.getElementById('btn-consult').classList.remove('d-none');
            } else if (target === '#pills-two') {
                document.getElementById('btn-referral').classList.remove('d-none');
            } else if (target === '#pills-three') {
                document.getElementById('btn-extraction').classList.remove('d-none');
            }
        });
    });


    $(document).ready(function() {
        $('#adPReferral').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{route('appointment.walkinreferral.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('referralAdded');
                        $('#centermodalwalkinreferral').modal('hide');
                        $('textarea[name="reasonrefer"]').val('');
                        $('textarea[name="tentdiagnose"]').val('');
                        $('textarea[name="treatmentmedgiven"]').val('');
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

        const walkinId = @json($adid);
        
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
			// "scrollX": false,         // Enable horizontal scrolling
			// "scrollCollapse": true,  // Adjust table size when the scroll is used
			// "responsive": true,
			// "autoWidth": false,
            // "info": true,
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
                {
                    data: 'time',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return moment(data, 'HH:mm').format('hh:mm A');
                        }
                        return data;
                    }
                },
                {data: 'preferfrom'},
                {data: 'preferto'},
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {

                            var buttons = `
                                <button type="button"
                                    class="btn btn-sm btn-success btn-walkineditreferral mr-1 text-light"
                                    data-id="${row.id}"
                                    data-refdate="${row.date}"
                                    data-reftime="${row.time}"
                                    data-refbp="${row.bp}"
                                    data-refpr="${row.pr}"
                                    data-refrr="${row.rr}"
                                    data-refspo="${row.spo}"
                                    data-refbtemp="${row.btemp}"
                                    data-reflmp="${row.lmp}"
                                    data-refpheight="${row.pheight}"
                                    data-refpweight="${row.pweight}"
                                    data-refpreferfrom="${row.preferfrom}"
                                    data-refpreferto="${row.preferto}"
                                    data-refreasonrefer="${row.reasonrefer}"
                                    data-reftentdiagnose="${row.tentdiagnose}"
                                    data-reftreatmentmedgiven="${row.treatmentmedgiven}"
                                    title="View Forms">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-sm btn-danger btn-deletereferral mr-1"
                                    value="${data}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            `;

                            return buttons;
                        }

                        return data;
                    }
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('referralAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-walkineditreferral', function() {
        var id = $(this).data('id');
        var referraldate = $(this).data('refdate');
        var referraltime = $(this).data('reftime');
        var referralbp = $(this).data('refbp');
        var referralpr = $(this).data('refpr');
        var referralrr = $(this).data('refrr');
        var referralspo = $(this).data('refspo');
        var referralbtemp = $(this).data('refbtemp');
        var referrallmp = $(this).data('reflmp');
        var referralpheight = $(this).data('refpheight');
        var referralpweight = $(this).data('refpweight');
        var referralpreferfrom = $(this).data('refpreferfrom');
        var referralpreferto = $(this).data('refpreferto');
        var reasonrefer = $(this).data('refreasonrefer');
        var tentdiagnose = $(this).data('reftentdiagnose');
        var treatmentmedgiven = $(this).data('reftreatmentmedgiven');

        $('#editWalkinReferralId').val(id);
        $('#editWalkinReferralDate').val(referraldate);
        $('#editWalkinReferralTime').val(referraltime);
        $('#editWalkinReferralBP').val(referralbp);
        $('#editWalkinReferralPR').val(referralpr);
        $('#editWalkinReferralRR').val(referralrr);
        $('#editWalkinReferralSPO2').val(referralspo);
        $('#editWalkinReferralBodyTemp').val(referralbtemp);
        $('#editWalkinReferralLMP').val(referrallmp);
        $('#editWalkinReferralHeight').val(referralpheight);
        $('#editWalkinReferralWeight').val(referralpweight);
        $('#editWalkinReferralFrom').val(referralpreferfrom);
        $('#editWalkinReferralTo').val(referralpreferto);
        $('#editWalkinReferralReason').val(reasonrefer);
        $('#editWalkinReferralTentativeDiagnosis').val(tentdiagnose);
        $('#editWalkinReferralTreatment').val(treatmentmedgiven);                                       

        $('#editcentermodalwalkinreferral').modal('show');
    });

    $('#editPReferral').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: walkinreferralUpdateRoute,
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editcentermodalwalkinreferral').modal('hide');
                    $(document).trigger('referralAdded');
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr, status, error, message) {
                var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                toastr.error(errorMessage);
            }
        });
    });

    $(document).on('click', '.btn-deletereferral', function(e) {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: walkinreferralDeleteRoute.replace(':id', id),
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        if ($.fn.DataTable.isDataTable('#referlisttab')) {
                            $('#referlisttab').DataTable().ajax.reload(null, false);
                        } else {
                            $("#tr-" + id).fadeOut();
                        }
                        if(response.success) {
                            toastr.success(response.message);
                            console.log(response);
                        }
                    }
                });
            }
        })
    });
</script>
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
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var buttons = '<button type="button" class="btn btn-sm btn-success btn-formsview mr-1 text-light" data-id="' + row.id + '"  data-toggle="tooltip" data-placement="top" title="View Forms"><i class="fas fa-eye"></i></button>'+'&nbsp;';
                                buttons += '<button type="button" class="btn btn-sm btn-danger btn-docsview mr-1" data-id="' + row.id + '"  data-toggle="tooltip" data-placement="top" title="View Clearances & Documents"><i class="ti ti-trash"></i></button>'+'&nbsp;';
                            return buttons;
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
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('referralAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.fund-delete', function(e) {
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
                    url: fundDeleteRoute.replace(':id', id),
                    success: function(response) {
                        $("#tr-" + id).delay(1000).fadeOut();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Successfully Deleted!',
                            icon: 'warning',
                            showConfirmButton: false,
                            timer: 1500
                        });
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
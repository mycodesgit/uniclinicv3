<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };
    $(document).ready(function() {
        $('#chiefComplaintForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                
                url: "{{route('complaint.create') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('complaintAdded');
                        $('#centercomplaintAddModal').modal('hide');
                        $('#chiefComplaintForm')[0].reset();
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

        var dataTable = $('#chiefcomplaintlistab').DataTable({
            "ajax": {
                "url": "{{ route('complaint.show') }}",
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
			// "responsive": false,
			// "autoWidth": false,
            // "info": true,
            destroy: true,
            info: true,
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {data: 'categoryname'},
                {data: 'complaintname'},
                {data: 'specificcondition'},
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="btn-group" role="group">' +
                                '<button type="button" class="btn btn-success btn-sm text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>' +
                                '<ul class="dropdown-menu">' +
                                '<a href="#" class="dropdown-item btn-complaintedit" data-id="' + row.id + '" data-categoryname="' + row.categoryname + '" data-complaintname="' + row.complaintname + '" data-specificcondition="' + row.specificcondition + '">' +
                                '<i class="fas fa-pen"></i> Edit' +
                                '</a>' +
                                '<button type="button" value="' + data + '" class="dropdown-item complaint-delete">' +
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
        $(document).on('complaintAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-complaintedit', function() {
        var id = $(this).data('id');
        var compCategory = $(this).data('categoryname');
        var compName = $(this).data('complaintname');
        var compSpecific = $(this).data('specificcondition');
        var medUnit = $(this).data('measure');
        var medLot = $(this).data('lotno');
        var expiryDate = $(this).data('expirydate');
        var referenceNo = $(this).data('refnoid');

        $('#editChiefComplaintId').val(id);
        $('#editCategoryname').val(compCategory);
        $('#editComplaint').val(compName);
        $('#editSpecific').val(compSpecific);

        $('#editChiefComplaintModal').modal('show');
    });

    $('#editChiefComplaintForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('complaint.update') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editChiefComplaintModal').modal('hide');
                    $(document).trigger('complaintAdded');
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

    $(document).on('click', '.complaint-delete', function(e) {
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
                    type: "POST",
                    url: "{{ route('complaint.delete', '__id__') }}".replace('__id__', id),
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


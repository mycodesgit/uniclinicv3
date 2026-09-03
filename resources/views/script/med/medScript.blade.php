<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };
    $(document).ready(function() {
        $('#medicineForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                
                url: "{{route('medicineCreate') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $(document).trigger('medicineAdded');
                        $('#centermodalmedadd').modal('hide');
                        $('input[name="medicine"]').val('');
                        $('input[name="qty"]').val('');
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

        var dataTable = $('#medlistab').DataTable({
            "ajax": {
                "url": "{{ route('getmedicineRead') }}",
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
                {data: 'category'},
                {data: 'medicine'},
                {data: 'qty'},
                {data: 'dispensed_qty'},
                { 
                    title: 'Total Overall', 
                    data: null, // No direct backend key needed
                    render: function (data, type, row) {
                        const qty = parseInt(row.qty) || 0;
                        const dispensed = parseInt(row.dispensed_qty) || 0;
                        return qty + dispensed;
                    }
                },
                {data: 'measure'},
                {data: 'lotno'},
                {data: 'expirydate',
                        render: function (data, type, row) {
                        if (type === 'display') {
                            return moment(data).format('MMMM D, YYYY');
                        } else {
                            return data;
                        }
                    }
                },
                {data: 'refnoid'},
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="btn-group" role="group">' +
                                '<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>' +
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
        $(document).on('medicineAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-mededit', function() {
        var id = $(this).data('id');
        var medCat = $(this).data('category');
        var medName = $(this).data('medicine');
        var qtyCount = $(this).data('qty');
        var medUnit = $(this).data('measure');
        var medLot = $(this).data('lotno');
        var expiryDate = $(this).data('expirydate');
        var referenceNo = $(this).data('refnoid');

        $('#editMedicineId').val(id);
        $('#editMedicineCategory').val(medCat);
        $('#editMedicineName').val(medName);
        $('#editMedicineQty').val(qtyCount);
        $('#editMedicineUnit').val(medUnit);
        $('#editMedicineLotNo').val(medLot);
        $('#editMedicineExpiry').val(expiryDate);
        $('#editMedicineReference').val(referenceNo);
        $('#editMedicineModal').modal('show');
    });

    $('#editMedicineForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('medicineUpdate') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#editMedicineModal').modal('hide');
                    $(document).trigger('medicineAdded');
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

    $(document).on('click', '.med-delete', function(e) {
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
                    url: "{{ route('medicineDelete', '__id__') }}".replace('__id__', id),
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


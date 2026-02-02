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
                {data: 'category'},
                {data: 'medicine'},
                {data: 'qty'},
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
        $(document).on('medicineAdded', function() {
            dataTable.ajax.reload();
        });
    });
</script>


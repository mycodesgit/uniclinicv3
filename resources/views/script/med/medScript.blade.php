<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };

    $(document).ready(function() {

        let currentBatchesData = [];
        let activeMedicineName = '';

        // 1. Primary DataTable Initialization
        var dataTable = $('#medlistab').DataTable({
            "ajax": {
                "url": "{{ route('getmedicineRead') }}",
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
                    data: 'code',
                    render: function (data) {
                        return data ? `<span class="badge bg-light text-dark border">${data}</span>` : '<span class="text-muted">N/A</span>';
                    }
                },
                { data: 'name' },
                { 
                    data: 'generic_name',
                    render: function (data) {
                        return data ? data : '<span class="text-muted">—</span>';
                    }
                },
                { 
                    data: 'dosage',
                    render: function (data) {
                        return data ? data : '<span class="text-muted">—</span>';
                    }
                },
                { data: 'unit' },
                { 
                    data: 'lotbatch_number',
                    render: function(data) {
                        return data ? data : '<span class="text-muted">No Batches</span>';
                    }
                },
                { 
                    data: 'quantity_remaining',
                    render: function (data, type, row) {
                        const qty = parseInt(data) || 0;
                        if (qty <= 0) {
                            return '<span class="badge bg-danger">Out of Stock</span>';
                        } else if (qty <= (row.reorder_level || 10)) {
                            return '<span class="badge bg-warning text-dark">' + qty + ' (Low)</span>';
                        }
                        return '<span class="badge bg-success">' + qty + '</span>';
                    }
                },
                { 
                    data: 'expiration_date',
                    render: function (data, type) {
                        if (!data) return '<span class="text-muted">—</span>';
                        if (type === 'display') {
                            return moment(data).format('MMMM D, YYYY');
                        }
                        return data;
                    }
                },
                { 
                    data: 'refnoid',
                    render: function (data) {
                        return data ? data : '<span class="text-muted">—</span>';
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return `
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="#" class="dropdown-item btn-view-batches" 
                                                data-id="${row.id}" 
                                                data-name="${row.name}">
                                                <i class="ti ti-server me-2 text-info"></i> View Batches
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item btn-add-batch" 
                                                data-id="${row.id}" 
                                                data-name="${row.name}">
                                                <i class="ti ti-plus me-2 text-success"></i> Add Stock Batch
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item btn-mededit" 
                                                data-id="${row.id}" 
                                                data-code="${row.code || ''}" 
                                                data-name="${row.name}" 
                                                data-generic_name="${row.generic_name || ''}" 
                                                data-dosage="${row.dosage || ''}" 
                                                data-unit="${row.unit}" 
                                                data-reorder_level="${row.reorder_level || 10}">
                                                <i class="ti ti-edit me-2 text-primary"></i> Edit Info
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" value="${data}" class="dropdown-item text-danger med-delete">
                                                <i class="ti ti-trash me-2"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            `;
                        }
                        return data;
                    }
                }
            ],
            "createdRow": function (row, data) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });

        $(document).on('medicineAdded', function() {
            dataTable.ajax.reload();
        });

        $(document).on('click', '.btn-add-batch', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name');

            $('#batchMedicineId').val(id);
            $('#batchMedicineLabel').text('Item: ' + name);
            $('#addBatchModal').modal('show');
        });

        // 2. Fetch and Display Batches Modal
        $(document).on('click', '.btn-view-batches', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            activeMedicineName = $(this).data('name');

            $('#viewBatchesTitle').html(`<i class="fas fa-boxes me-1"></i> Medicine: <strong>${activeMedicineName}</strong>`);
            
            loadMedicineBatches(id);
        });

        function loadMedicineBatches(medicineId) {
            $.ajax({
                url: "{{ route('medicineBatchesRead', '__id__') }}".replace('__id__', medicineId),
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        currentBatchesData = response.data;
                        renderBatchTableView(currentBatchesData);
                        renderBatchCardView(currentBatchesData);
                        $('#viewBatchesModal').modal('show');
                    }
                },
                error: function() {
                    toastr.error('Failed to load batch items.');
                }
            });
        }

        // Render Table View for Batches
        function renderBatchTableView(batches) {
            var tbody = $('#batchesListTable tbody');
            tbody.empty();

            if (batches.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center text-muted">No stock batches found.</td></tr>');
                return;
            }

            batches.forEach(function(batch) {
                let statusBadge = batch.quantity_remaining > 0 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-secondary">Exhausted</span>';

                let row = `
                    <tr>
                        <td><strong>${batch.lotbatch_number}</strong></td>
                        <td>${batch.quantity_received}</td>
                        <td><span class="fw-bold">${batch.quantity_remaining}</span></td>
                        <td>${moment(batch.expiration_date).format('MMMM D, YYYY')}</td>
                        <td>${batch.refnoid || '—'}</td>
                        <td>${statusBadge}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-edit-batch" 
                                data-batch='${JSON.stringify(batch)}'>
                                <i class="ti ti-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Render Card View for Batches
        function renderBatchCardView(batches) {
            var container = $('#batchCardView');
            container.empty();

            if (batches.length === 0) {
                container.append('<div class="col-12 text-center text-muted">No stock batches found.</div>');
                return;
            }

            batches.forEach(function(batch) {
                let statusBadge = batch.quantity_remaining > 0 
                    ? '<span class="badge bg-success">Active</span>' 
                    : '<span class="badge bg-secondary">Exhausted</span>';

                let card = `
                    <div class="col-md-4">
                        <div class="card h-100 border shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="card-title fw-bold mb-0 text-info">${batch.lotbatch_number}</h6>
                                    ${statusBadge}
                                </div>
                                <hr class="my-2">
                                <p class="card-text fs-14 mb-1"><strong>Remaining:</strong> ${batch.quantity_remaining} / ${batch.quantity_received}</p>
                                <p class="card-text fs-14 mb-1"><strong>Expiry:</strong> ${moment(batch.expiration_date).format('MMM D, YYYY')}</p>
                                <p class="card-text fs-14 mb-0"><strong>Ref / Invoice:</strong> ${batch.refnoid || '—'}</p>
                            </div>
                            <div class="card-footer bg-light d-flex justify-content-end p-2">
                                <button type="button" class="btn btn-sm btn-outline-success btn-edit-batch" 
                                    data-batch='${JSON.stringify(batch)}'>
                                    <i class="fas fa-edit me-1"></i> Edit Batch
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        // Toggle Table vs Card View
        $('#btnViewTable').click(function() {
            $(this).addClass('active');
            $('#btnViewCard').removeClass('active');
            $('#batchTableView').removeClass('d-none');
            $('#batchCardView').addClass('d-none');
        });

        $('#btnViewCard').click(function() {
            $(this).addClass('active');
            $('#btnViewTable').removeClass('active');
            $('#batchCardView').removeClass('d-none');
            $('#batchTableView').addClass('d-none');
        });

        // 3. Open Edit Batch Modal
        $(document).on('click', '.btn-edit-batch', function() {
            var batch = $(this).data('batch');

            $('#editBatchId').val(batch.id);
            $('#editBatchLotNumber').val(batch.lotbatch_number);
            $('#editBatchQtyRemaining').val(batch.quantity_remaining);
            $('#editBatchExpiration').val(batch.expiration_date);
            $('#editBatchRefNo').val(batch.refnoid || '');

            $('#editBatchModal').modal('show');
        });

        // Submit Edit Batch Form
        $('#editBatchForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('medicineBatchUpdate') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $('#editBatchModal').modal('hide');
                        $(document).trigger('medicineAdded');
                        
                        // Reload currently opened modal list if visible
                        if ($('#viewBatchesModal').is(':visible')) {
                            loadMedicineBatches(response.medicine_id);
                        }
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        // 4. Submit New Medicine Form
        $('#medicineForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('medicineCreate') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $(document).trigger('medicineAdded');
                        $('#centermodalmedadd').modal('hide');
                        $('#medicineForm')[0].reset();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        // 5. Submit Add Batch Form
        $('#addBatchForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('medicineBatchCreate') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $(document).trigger('medicineAdded');
                        $('#addBatchModal').modal('hide');
                        $('#addBatchForm')[0].reset();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        // 6. Edit Medicine Details Form
        $(document).on('click', '.btn-mededit', function(e) {
            e.preventDefault();
            $('#editMedicineId').val($(this).data('id'));
            $('#editMedicineCode').val($(this).data('code'));
            $('#editMedicineName').val($(this).data('name'));
            $('#editMedicineGenericName').val($(this).data('generic_name'));
            $('#editMedicineDosage').val($(this).data('dosage'));
            $('#editMedicineUnit').val($(this).data('unit'));
            $('#editMedicineReorderLevel').val($(this).data('reorder_level'));

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
                error: function(xhr) {
                    var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                    toastr.error(errorMessage);
                }
            });
        });

        // 7. Delete Medicine
        $(document).on('click', '.med-delete', function(e) {
            var id = $(this).val();
            Swal.fire({
                title: 'Are you sure?',
                text: "This will remove the medicine item and associated batch history!",
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
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $("#tr-" + id).delay(500).fadeOut();
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Successfully Deleted!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            if(response.success) {
                                toastr.success(response.message);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
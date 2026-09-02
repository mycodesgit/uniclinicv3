<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center"
    };
    $(document).ready(function() {
        $('#userForm').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: "{{ route('user.create') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        console.log(response);
                        $('#centermodaluseradd').modal('hide');
                        $(document).trigger('userAdded');
                        $('#userForm')[0].reset();
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

        var dataTable = $('#userlistab').DataTable({
            "ajax": {
                "url": "{{ route('user.show') }}",
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
                { 
                    data: null,
                    render: function(data, type, row) {
                        var firstname = data.fname;
                        var middleInitial = data.mname ? data.mname.substr(0, 1) + '.' : '';
                        var lastNameWithExt = data.lname + (data.ext && data.ext !== 'null' ? ' ' + data.ext : '');
                        return firstname + ' ' + middleInitial + ' ' + lastNameWithExt;
                    }
                },
                { data: 'email' },
                {
                    data: null,
                    render: function (data, type, row) {
                        let roleBadge = '';

                        if (data.role == "Administrator") {
                            roleBadge = '<span class="badge bg-info">Administrator</span>';
                        } else if (data.role == "Nurse") {
                            roleBadge = '<span class="badge bg-secondary">Nurse</span>';
                        } else if (data.role == "Nurse Staff") {
                            roleBadge = '<span class="badge bg-light">Nurse Staff</span>';
                        } else {
                            roleBadge = '<span class="badge bg-dark">Unknown Role</span>';
                        }
                        return roleBadge;
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        let statususer = '';

                        if (data.status == 1) {
                            statususer = '<span class="badge bg-success">Enabled</span>';
                        } else {
                            statususer = '<span class="badge bg-danger">Disabled</span>';
                        } 
                        return statususer;
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            var dropdown = '<div class="d-flex align-items-center gap-1">' +
                                '<a href="#" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1 bg-teal btn-useredit" data-id="' + row.id + '" data-fname="' + row.fname + '" data-mname="' + row.mname + '" data-lname="' + row.lname + '" data-ext="' + row.ext + '" data-email="' + row.email + '" data-campus="' + row.campus + '" data-gender="' + row.gender + '" data-role="' + row.role + '" title="View Details"><i class="ti ti-eye"></i></a>' +
                                '<a href="javascript:void(0);" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
                                '<ul class="dropdown-menu p-2">' +
                                '<li><a href="#" class="dropdown-item d-flex align-items-center btn-userpass" data-id="' + row.id + '" data-password="' + row.password + '"><i class="fas fa-key" style="color: green"></i>&nbsp;Edit Password</a></li>' +
                                '<li><a href="#" class="dropdown-item d-flex align-items-center btn-userdeact" data-id="' + row.id + '" data-fullname="' + row.fname + ' ' + row.mname + ' ' + row.lname + (row.ext && row.ext !== 'null' ? ' ' + row.ext : '') + '" data-statuser="' + row.status + '"><i class="fas fa-toggle-off" style="color: orange"></i>&nbsp;Disabled Account</a></li>' +
                                '<li><button type="button" value="' + data + '" class="dropdown-item d-flex align-items-center btn-userdelete"><i class="fas fa-trash" style="color: red"></i>&nbsp;Delete</button></li>' +
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

        $(document).on('userAdded', function() {
            dataTable.ajax.reload();
        });
    });

    $(document).on('click', '.btn-useredit', function() {
        var id = $(this).data('id');
        var fname = $(this).data('fname');
        var mname = $(this).data('mname');
        var lname = $(this).data('lname');
        var ext = $(this).data('ext');
        var email = $(this).data('email');
        var campus = $(this).data('campus');
        var gender = $(this).data('gender');
        var role = $(this).data('role');

        $('#edituserId').val(id);
        $('#edituserfname').val(fname);
        $('#editusermname').val(mname);
        $('#edituserlname').val(lname);
        $('#edituserext').val(ext);
        $('#edituseremail').val(email);
        $('#editusercampus').val(campus);
        $('#editusergender').val(gender);
        $('#edituserrole').val(role);

        $('#edituserModal').modal('show');
    });

    $('#editUserForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('user.update') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#edituserModal').modal('hide');
                    $(document).trigger('userAdded');
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

    $(document).on('click', '.btn-userpass', function() {
        var id = $(this).data('id');

        $('#edituserPassId').val(id);
        $('#edituserpass').val('');

        $('#edituserPassModal').modal('show');
    });

    $('#edituserPassForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('userPassUpdate') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#edituserPassModal').modal('hide');
                    $(document).trigger('userAdded');
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

    $(document).on('click', '.btn-userdeact', function() {
        var id = $(this).data('id');
        var fullname = $(this).data('fullname');
        var statuser = $(this).data('statuser');

        $('#edituserDeactId').val(id);
        $('#edituserDeactfullname').val(fullname);
        $('#edituserDeactStat').val(statuser);

        $('#edituserDeactModal').modal('show');
    });

    $('#edituserDeactForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('userStatusUpdate') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#edituserDeactModal').modal('hide');
                    $(document).trigger('userAdded');
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
</script>
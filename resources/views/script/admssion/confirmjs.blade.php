<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    };

    $(document).ready(function() {
        var urlParams = new URLSearchParams(window.location.search);
        var year = urlParams.get('year') || ''; 
        var campus = urlParams.get('campus') || ''; 
        var strand = urlParams.get('strand') || ''; 

        var dataTable = $('#exresultlistTable').DataTable({
            "ajax": {
                "url": allresultRoute,
                "type": "GET",
                "data": { 
                    "year": year,
                    "campus": campus,
                    "strand": strand
                }
            },
            responsive: true,
            lengthChange: true,
            searching: true,
            paging: true,
            "columns": [
                {data: 'admission_id'},
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
                    data: null,
                    render: function(data, type, row) {
                        if (data.type == 1) {
                            return 'New';
                        } else if (data.type == 2) {
                            return 'Returnee';
                        } else if (data.type == 3) {
                            return 'Transferee';
                        } else {
                            return '';
                        }
                    }
                },
                {data: 'percentile'},
                {
                    data: null,
                    render: function(data, type, row) {
                        if (type === 'display') {
                            // Parse the date and time strings and format them using moment.js
                            var dateTimeString = row.d_admission + ' ' + row.time;
                            var formattedDateTime = moment(dateTimeString, 'YYYY-MM-DD HH:mm:ss').format('MMM DD, YYYY h:mm A');
                            return formattedDateTime;
                        } else {
                            return data; // Return the original data for other types
                        }
                    }
                },
                {data: 'campus'},
                {data: 'appstrand'},
                {data: null, orderable: false, searchable: false},
                {
                    data: 'adid',
                    className: "action-column",
                    render: function(data, type, row) {
                        if (type === 'display' && isCampus === requestedCampus) {
                            var dropdown = '<div class="d-inline-block">' +
                                '<a class="btn btn-success btn-sm dropdown-toggle dropdown-icon text-light" data-bs-toggle="dropdown"></a>' +
                                '<div class="dropdown-menu">';

                            if (isCampus) {
                                dropdown += '<a href="#" class="dropdown-item btn-viewappdata" data-id="' + row.adid + '" data-admissionid="' + row.admission_id + '" data-type="' + row.type + '" data-campus="' + row.campus + '" data-fname="' + row.fname + '" data-mname="' + row.mname + '" data-lname="' + row.lname + '" data-ext="' + row.ext + '" data-hnum="' + row.hnum + '" data-brgy="' + row.brgy + '" data-city="' + row.city + '" data-province="' + row.province + '" data-region="' + row.region + '" data-zcode="' + row.zcode + '" data-gender="' + row.gender + '" data-bday="' + row.bday + '" data-civilstat="' + row.civil_status + '" data-contact="' + row.contact + '" data-email="' + row.email + '" data-address="' + row.address + '" data-lsa="' + row.lstsch_attended + '" data-strand="' + row.strand + '" data-cula="' + row.suc_lst_attended + '" data-culac="' + row.course + '" data-cp1="' + row.preference_1 + '" data-cp2="' + row.preference_2 + '">' +
                                    '<i class="fas fa-eye"></i> View Data' +
                                    '</a>' +
                                    '<a href="srchexamineeResultList/view/' + row.adid + '" class="dropdown-item btn-edit" target="_blank">' +
                                    '<i class="fas fa-file-pdf"></i> Generate Pre-Enrollment' +
                                    '</a>' +
                                    '<a href="#" class="dropdown-item btn-updateresultexam" data-id="' + row.adid + '" data-rawscore="' + row.raw_score + '" data-percentile="' + row.percentile + '" data-qualifier="' + row.qualifier + '">' +
                                    '<i class="fas fa-file-lines"></i> Update Test Result' +
                                    '</a>';

                                    if (row.percentile == 'Qualified' || row.percentile == 'Passed' || row.qualifier == 2) {
                                        dropdown += '<a href="#" class="dropdown-item btn-pushtocnfrm" data-id="' + row.adid + '">' +
                                            '<i class="fas fa-check"></i> Push Examinee' +
                                            '</a>';
                                    } else {
                                        dropdown += '<span class="dropdown-item disabled"><i class="fas fa-check"></i> Push Examinee</span>';
                                    }
                            } else {
                                dropdown += '<span class="dropdown-item disabled"><i class="fas fa-eye"></i> View</span>' +
                                    '<span class="dropdown-item disabled"><i class="fas fa-trash"></i> Delete</span>';
                            }
                            
                            dropdown += '</div>' +
                                '</div>';
                            return dropdown;
                        } else {
                            return '';
                        }
                    },
                }
            ],
            "createdRow": function (row, data, index) {
                $(row).attr('id', 'tr-' + data.id); 
            }
        });
        $(document).on('rslttable', function() {
            dataTable.ajax.reload();
        });
    });
</script>
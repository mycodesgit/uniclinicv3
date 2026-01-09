<script>
    $(document).ready(function() {

        $('#studentdata').DataTable({
            "ajax": {
                "url": studentsReadRoute,
            },
            // responsive: true,
            // lengthChange: true,
            // searching: true,
            // paging: true,

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
            "columns": [
                {
                    data: null,
                    render: function(data, type, row) {
                        var firstname = data.fname;
                        var middleInitial = data.mname ? data.mname.substr(0, 1) + '.' : '';
                        var lastName = data.lname;
                        var ext = data.ext && data.ext !== 'N/A' ? ' ' + data.ext : ' ';
                        
                        return lastName + ', ' + firstname + ' ' + middleInitial + ext;
                    }
                },
                { data: 'stud_id' },   
                { data: 'gender' },   
                { data: 'civil_status' },   
                {
                    data: 'id',
                    
                }
            ],
            "createdRow": function (row, data, dataIndex) {
                $(row).attr('id', 'tr-' + data.id);
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const patientDetailsRoute = "{{ route('patients.details', ['id' => ':id']) }}";
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchInput');
        const tableBody = document.getElementById('studentsTable');
        const pagination = document.getElementById('paginationLinks');
        const searchRoute = "{{ route('patients.show') }}";

        function loadStudents(page = 1) {
            const search = input.value.trim();

            fetch(`${searchRoute}?search=${encodeURIComponent(search)}&page=${page}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(res => {

                tableBody.innerHTML = '';
                pagination.innerHTML = '';

                if (res.data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center">No records found</td>
                        </tr>
                    `;
                    return;
                }

                res.data.forEach(student => {
                    const detailsUrl = patientDetailsRoute.replace(':id', student.id);
                    tableBody.innerHTML += `
                        <tr>
                            <td>${student.lname}, ${student.fname}</td>
                            <td>${student.stud_id}</td>
                            <td>${student.gender}</td>
                            <td>${
                                student.campus === 'MC'   ? 'Main' :
                                student.campus === 'VC'   ? 'Victorias' :
                                student.campus === 'SCC'  ? 'San Carlos' :
                                student.campus === 'HC'   ? 'Hinigaran' :
                                student.campus === 'MP'   ? 'Moises Padilla' :
                                student.campus === 'IC'   ? 'Ilog' :
                                student.campus === 'CA'   ? 'Candoni' :
                                student.campus === 'CC'   ? 'Cauayan' :
                                student.campus === 'SC'   ? 'Sipalay' :
                                student.campus === 'HinC' ? 'Hinobaan' :
                                student.campus
                            }</td>
                            <td>${student.civil_status}</td>
                            <td>${student.enhiscourse}</td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="${detailsUrl}" class="btn btn-success btn-sm border" title="View Details">
                                        <i class="ti ti-eye" style="color: #fff"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                for (let i = 1; i <= res.last_page; i++) {
                    pagination.innerHTML += `
                        <li class="page-item ${i === res.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        loadStudents(this.dataset.page);
                    });
                });
            });
        }

        // jQuery Validation
        $('#searchForm').validate({
            rules: {
                searchstud: { required: true },
            },
            messages: {
                searchstud: { required: "Please Enter Search Student Last Name or Student ID" },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-4').append(error);        
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                // Only called if the form is valid
                loadStudents(1);
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const patientDetailsRoute = "{{ route('patients.employee.empdetails', ['id' => ':id']) }}";
    const form = document.getElementById('searchEmpForm');
    const input = document.getElementById('searchEmpInput');
    const tableBody = document.getElementById('employeesTable');
    const pagination = document.getElementById('paginationLinks');
    const searchRoute = "{{ route('patients.employee.search') }}";

    function loadEmployees(page = 1) {
        const search = input.value.trim();

        fetch(`${searchRoute}?search=${encodeURIComponent(search)}&page=${page}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(res => {

            tableBody.innerHTML = '';
            pagination.innerHTML = '';

            if (res.data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">No records found</td>
                    </tr>
                `;
                return;
            }

            // Populate table
            res.data.forEach(emp => {
                const detailsUrl = patientDetailsRoute.replace(':id', emp.id);
                tableBody.innerHTML += `
                    <tr>
                        <td>${emp.lname}, ${emp.fname}</td>
                        <td>${emp.emp_ID}</td>
                        <td>${emp.sex}</td>
                        <td>${
                            emp.camp_id === 1  ? 'Main' :
                            emp.camp_id === 9  ? 'Victorias' :
                            emp.camp_id === 7  ? 'San Carlos' :
                            emp.camp_id === 4  ? 'Hinigaran' :
                            emp.camp_id === 12 ? 'Moises Padilla' :
                            emp.camp_id === 6  ? 'Ilog' :
                            emp.camp_id === 2  ? 'Candoni' :
                            emp.camp_id === 3  ? 'Cauayan' :
                            emp.camp_id === 8  ? 'Sipalay' :
                            emp.camp_id === 5  ? 'Hinobaan' :
                            emp.camp_id
                        }</td>
                        <td>${emp.civil_status}</td>
                        <td>
                            <div class="d-flex align-items-center gap-1">
                                <a href="${detailsUrl}" class="btn btn-success btn-sm text-light" title="View Details">
                                    <i class="ti ti-eye" style="color: #fff"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            // Pagination links
            for (let i = 1; i <= res.last_page; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === res.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            // Pagination click events
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    loadEmployees(this.dataset.page);
                });
            });
        });
    }

    // jQuery Validation for Employee Search
    $('#searchEmpForm').validate({
        rules: {
            searchemp: { required: true },
        },
        messages: {
            searchemp: { required: "Please Enter Employee Last Name or Employee ID" },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-4').append(error);        
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            // Only called if the form is valid
            loadEmployees(1);
        }
    });

});
</script>
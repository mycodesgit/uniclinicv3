@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Walk-In Consultation</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                {{-- <a href="javascript:void(0);" class="btn btn-outline-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_consult_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a>
                <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a> --}}
            </div>
        </div>
        <!-- End Page Header -->

        <!-- tab start -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#students" data-bs-toggle="tab" aria-expanded="false" class="nav-link active bg-transparent">
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#employees" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Employees</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#outsiders" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Guest</span>
                </a>
            </li>
        </ul>
        <!-- tab end -->

        <!-- row start -->
        <div class="row">
            <div class="tab-content">
                <div class="tab-pane show active" id="students">
                    <div class="card">
                        <div class="card-body">
                            <form id="searchForm">
                                <div class="d-flex align-items-center gap-4">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search Patient Last Name or ID">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap" id="">
                            <thead class="">
                                <tr>
                                    <th>Name</th>
                                    <th>StudID</th>
                                    <th>Gender</th>
                                    <th>Campus</th>
                                    <th>Civil Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable">
                                <tr>
                                    <td colspan="5" class="text-center">Search to load data</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <nav>
                            <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                        </nav>
                    </div>
                </div>

                <div class="tab-pane" id="employees">
                    <div class="card">
                        <div class="card-body">
                            <form id="searchEmpForm">
                                <div class="d-flex align-items-center gap-4">
                                    <input type="text" id="searchEmpInput" class="form-control" placeholder="Search Patient Last Name or Employee ID">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap" id="">
                            <thead class="">
                                <tr>
                                    <th>Name</th>
                                    <th>EmpID</th>
                                    <th>Gender</th>
                                    <th>Campus</th>
                                    <th>Civil Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="employeesTable">
                                <tr>
                                    <td colspan="6" class="text-center">Search to load data</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <nav>
                            <ul class="pagination justify-content-center" id="paginationEmpLinks"></ul>
                        </nav>
                    </div>
                </div>

                <div class="tab-pane" id="outsiders">
                    <div class="table-responsive">
                        <table id="guesttabletab" class="table datatable table-nowrap" style="width: 100%">
                            <thead class="">
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Civil Status</th>
                                    <th>Date Added</th>
                                    <th class="text-center" width="7%">Action</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10pt;">
                                
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>  
        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const patientDetailsRoute = "{{ route('appointment.walkin.details', ['id' => ':id']) }}";
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

                    // Populate table
                    res.data.forEach(student => {
                        const detailsUrl = patientDetailsRoute.replace(':id', student.id);
                        tableBody.innerHTML += `
                            <tr>
                                <td>${student.lname}, ${student.fname}</td>
                                <td>${student.stud_id}</td>
                                <td>${student.gender}</td>
                                <td>
                                    ${
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
                                    }
                                </td>
                                <td>${student.civil_status}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="${detailsUrl}" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1 bg-teal" title="View Details">
                                            <i class="ti ti-eye" style="color: #fff"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu p-2">
                                            <li>
                                                <a href="edit-patient.html" class="dropdown-item d-flex align-items-center">Edit</a>
                                            </li>
                                            <li>
                                                <a href="patient-details.html" class="dropdown-item d-flex align-items-center">View</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal">Delete</a>
                                            </li>
                                        </ul>
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
                            loadStudents(this.dataset.page);
                        });
                    });
                });
            }

            // Button search
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                loadStudents(1);
            });

        });
    </script>
@endsection
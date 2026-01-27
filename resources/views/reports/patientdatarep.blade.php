@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Patient Data Report</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
            </div>
        </div>
        <!-- End Page Header -->

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
            </div>  
        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const patientDetailsRoute = "{{ route('reports.patientdatarep.details', ['id' => ':id']) }}";
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
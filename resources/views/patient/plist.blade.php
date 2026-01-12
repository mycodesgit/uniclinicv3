@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Patients</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="javascript:void(0);" class="btn btn-teal d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_patient_outsider">
                    <i class="ti ti-plus me-1"></i>New Guest Patient
                </a>
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
    var studentsReadRoute = "{{ route('patients.show') }}";
</script>

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

<div class="offcanvas offcanvas-offset offcanvas-end" tabindex="-1" id="new_patient_outsider">
    <div class="offcanvas-header d-block pb-0 px-0">
        <div class="border-bottom d-flex align-items-center justify-content-between pb-3 px-3">
            <h5 class="offcanvas-title fs-18 fw-bold">New Guest Patient</h5>
            <button type="button" class="btn-close custom-btn-close opacity-100" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body pt-3">
        <form action="#">
            <!-- start row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient ID <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded bg-light" value="AP234354">
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Lastname<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded">
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Firstname<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded">
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Middlename<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded">
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Appointment Type <span class="text-danger">*</span></label>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle form-control rounded d-flex align-items-center justify-content-between border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                Select
                            </a>
                            <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                                <div class="mb-3">
                                    <div class="input-icon-start position-relative">
                                        <span class="input-icon-addon fs-12">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-sm" placeholder="Select">
                                    </div>
                                </div>
                                <ul class="mb-3 list-style-none">
                                    <li>
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            In Person
                                        </label>
                                    </li>
                                    <li class="list-none">
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            Online
                                        </label>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium"> Date of Appointment <span class="text-danger">*</span></label>
                        <div class="input-icon-end position-relative">  
                            <input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                            <span class="input-icon-addon">
                                <i class="ti ti-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium"> Time <span class="text-danger">*</span></label>
                        <div class="input-icon-end position-relative">  
                            <input type="text" class="form-control timepicker" placeholder="-- : --">
                            <span class="input-icon-addon">
                                <i class="ti ti-clock"></i>
                            </span>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <div>
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Appointment Reason</label>
                            <textarea rows="4" class="form-control rounded"> </textarea>
                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Status<span class="text-danger">*</span></label>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle form-control rounded d-flex align-items-center justify-content-between border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                Select
                            </a>
                            <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                                <div class="mb-3">
                                    <div class="input-icon-start position-relative">
                                        <span class="input-icon-addon fs-12">
                                            <i class="ti ti-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-sm" placeholder="Select">
                                    </div>
                                </div>
                                <ul class="mb-3 list-style-none">
                                    <li>
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            Checked Out
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                            Checked In
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            Cancelled
                                        </label>
                                    </li>
                                    <li>
                                        <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                            <input class="form-check-input m-0 me-2" type="checkbox">
                                            Scheduled
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->
            </div>
            <!-- end row-->
        </form>
    </div>
    <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
        <div class=" d-flex justify-content-end gap-2">
            <a href="javascript:void(0);" class="btn btn-light btm-md">Cancel</a>
            <button data-bs-dismiss="offcanvas" class="btn btn-primary btm-md" id="filter-submit">Save Data</button>
        </div>
    </div>
</div>


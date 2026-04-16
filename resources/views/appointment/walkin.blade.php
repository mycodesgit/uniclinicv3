@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Walkin Consultations</h1>
                <hr>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <ul class="nav nav-pills bg-light p-2 rounded-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-one-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-one" type="button" role="tab"
                                    aria-controls="pills-one" aria-selected="true"> <i class="ti ti-user-bolt"></i>
                                    Students
                                </button>
                            </li>
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-two-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-two" type="button" role="tab"
                                    aria-controls="pills-two" aria-selected="false" tabindex="-1"> <i class="ti ti-user-code"></i>
                                    Employees
                                </button>
                            </li>
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-three-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-three" type="button" role="tab"
                                    aria-controls="pills-three" aria-selected="false" tabindex="-1"> <i class="ti ti-users"></i>
                                    Guest
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content mt-1" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                        <form id="searchForm">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <input type="text" id="searchInput" name="searchstud" class="form-control form-control-md" placeholder="Search Patient Last Name or First Name or Student ID">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success btn-md text-light">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="">
                                                <thead class="">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>StudID</th>
                                                        <th>Gender</th>
                                                        <th>Campus</th>
                                                        <th>Civil Status</th>
                                                        <th>Course</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="studentsTable">
                                                    <tr>
                                                        <td colspan="7" class="text-center">Search to load data</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <br>
                                            <nav>
                                                <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                        <form id="searchEmpForm">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <input type="text" id="searchEmpInput" name="searchemp" class="form-control form-control-md" placeholder="Search Patient Last Name or First Name or Employee ID">
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="submit" class="btn btn-success btn-md text-light">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="">
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
                                    <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab" tabindex="0">
                                        <div class="table-responsive mt-2 p-2">
                                            <button id="btn-guestpatient" type="button" class="btn btn-success btn-md text-light" data-bs-toggle="offcanvas" data-bs-target="#new_patient_outsider">
                                                <i class="ti ti-plus me-1"></i> New Guest Patient
                                            </button>
                                            <table id="guesttabletab" class="table table-striped" style="width: 100%">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var studentsReadRoute = "{{ route('patients.show') }}";
    </script>
@endsection

@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Patients</h1>
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
                        <div class="tab-content mt-1" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                <div class="card">
                                    <div class="card-body">
                                        <form id="searchForm">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <input type="text" id="searchInput" name="searchstud" class="form-control form-control-md" placeholder="Search Patient Last Name or First Name or Student ID">
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
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                <div class="card">
                                    <div class="card-body">
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
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab" tabindex="0">
                                <div class="card">
                                    <div class="card-header pt-3 d-flex justify-content-between align-items-center">
                                        <h6 class="card-title">
                                            <i class="ti ti-users"></i> List of Guest/Visitor Patients
                                        </h6>
                                        <button type="button" class="btn btn-success btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#centermodalAddNewGuestPatient">
                                            <i class="ti ti-plus me-1"></i> New Guest Patient
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive mt-2 p-2">
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

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalAddNewGuestPatient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Add New Guest/Visitor Patient</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="guestpatientform" method="POST">
                        @csrf

                        <!-- SECTION: Personal Information -->
                        <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Personal Information</h6>
                        
                        <div class="row g-3">
                            <!-- Last Name -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="lname" required>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="fname" required>
                                </div>
                            </div>

                            <!-- Middle Name -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Middle Name</label>
                                    <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="mname">
                                </div>
                            </div>

                            <!-- Extension Name -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Extension Name</label>
                                    <select name="ext" id="extension_name" class="form-control form-control-sm rounded">
                                        <option value="">Select Extension</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-control form-control-sm rounded" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Civil Status -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Civil Status <span class="text-danger">*</span></label>
                                    <select name="civil_status" id="civil_status" class="form-control form-control-sm rounded" required>
                                        <option value="">Select Civil Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION: Address Details -->
                        <h6 class="text-primary fw-bold mt-4 mb-3 border-bottom pb-2">Address Details</h6>

                        <div class="row g-3">
                            <!-- Full Address Display (Computed) -->
                            <div class="col-12">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Full Address Preview <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control form-control-sm readonlytext" id="viewdatastudAddress" placeholder="Generated full address..." readonly required>
                                </div>
                            </div>

                            <!-- Region -->
                            <div class="col-md-6">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Region <span class="text-danger">*</span></label>
                                    <select id="region" class="form-control form-control-sm select2bs4" required>
                                        <option value="">Select Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->region_id }}" data-name="{{ $region->name }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="region_name" name="region">
                                </div>
                            </div>

                            <!-- Province -->
                            <div class="col-md-6">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Province <span class="text-danger">*</span></label>
                                    <select id="province" class="form-control form-control-sm select2bs4" required>
                                        <option value="">Select Province</option>
                                    </select>
                                    <input type="hidden" id="province_name" class="update-field" name="province">
                                </div>
                            </div>

                            <!-- City/Municipality -->
                            <div class="col-md-6">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">City/Municipality <span class="text-danger">*</span></label>
                                    <select id="city" class="form-control form-control-sm select2bs4" required>
                                        <option value="">Select City</option>
                                    </select>
                                    <input type="hidden" id="city_name" class="update-field" name="city">
                                </div>
                            </div>

                            <!-- Barangay -->
                            <div class="col-md-6">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Barangay <span class="text-danger">*</span></label>
                                    <select id="barangay" class="form-control form-control-sm select2bs4" required>
                                        <option value="">Select Barangay</option>
                                    </select>
                                    <input type="hidden" id="brgy_name" class="update-field" name="brgy">
                                </div>
                            </div>

                            <!-- Street / House No. -->
                            <div class="col-md-8">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">House No. / Block / Purok <span class="text-danger">*</span></label>
                                    <input type="text" name="hnum" id="viewdatastudHnum" class="form-control form-control-sm update-field text-uppercase" placeholder="e.g., House No., Street, Subdivision" required>
                                </div>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-md-4">
                                <div class="mb-0">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Zip Code <span class="text-danger">*</span></label>
                                    <input type="text" name="zcode" id="zipcode" class="form-control form-control-sm readonlytext update-field" placeholder="Zip Code" readonly required>
                                </div>
                            </div>
                        </div>

                        <!-- Form Controls -->
                        <div class="offcanvas-footer mb-1 mt-4 p-3 border-top d-flex justify-content-between gap-2">
                            <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success btn-md">Save Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var studentsReadRoute = "{{ route('patients.show') }}";
    </script>
@endsection

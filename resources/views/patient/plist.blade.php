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
                <button id="btn-guestpatient" type="button" class="btn btn-teal d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_patient_outsider">
                    <i class="ti ti-plus me-1"></i>New Guest Patient
                </button>
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
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="searchInput" name="searchstud" class="form-control" placeholder="Search Patient Last Name or Student ID">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary mt-1">Search</button>
                                    </div>
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
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="searchEmpInput" name="searchemp" class="form-control" placeholder="Search Patient Last Name or Employee ID">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary mt-1">Search</button>
                                    </div>
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
        var studentsReadRoute = "{{ route('patients.show') }}";
    </script>

    <div class="offcanvas offcanvas-offset offcanvas-end" tabindex="-1" id="new_patient_outsider">
        <div class="offcanvas-header d-block pb-0 px-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3 px-3">
                <h5 class="offcanvas-title fs-18 fw-bold">New Guest Patient</h5>
                <button type="button" class="btn-close custom-btn-close opacity-100" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body pt-3">
            <form id="guestpatientform" method="POST">
                @csrf

                <!-- start row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Lastname<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="lname" required>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Firstname<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="fname" required>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Middlename<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm rounded" oninput="this.value = this.value.toUpperCase()" name="mname">
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Extension Name<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="ext" id="extension_name" class="form-control form-control-sm rounded">
                                    <option value="">Select Extension Name</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="III">III</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Gender<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="gender" id="gender" class="form-control form-control-sm rounded" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Civil Status<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select name="civil_status" id="civil_status" class="form-control form-control-sm rounded" required>
                                    <option value="">Select Civil Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient Address<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="address" class="form-control form-control-sm readonlytext" id="viewdatastudAddress" readonly>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-medium">Region<span class="text-danger ms-1">*</span></label>
                            <select id="region" class="form-control form-control-sm select2bs4">
                                <option value="">Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->region_id }}" data-name="{{ $region->name }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="region_name" name="region">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-medium">Province<span class="text-danger ms-1">*</span></label>
                            <select id="province" class="form-control form-control-sm select2bs4">
                                <option value="">Select Province</option>
                            </select>
                            <input type="hidden" id="province_name" class="update-field" name="province">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-medium">City/Municipality<span class="text-danger ms-1">*</span></label>
                            <select id="city" class="form-control form-control-sm select2bs4">
                                <option value="">Select City</option>
                            </select>
                            <input type="hidden" id="city_name" class="update-field" name="city">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-meduim">Barangay<span class="text-danger ms-1">*</span></label>
                            <select id="barangay" class="form-control form-control-sm select2bs4">
                                <option value="">Select Barangay</option>
                            </select>
                            <input type="hidden" id="brgy_name" class="update-field" name="brgy">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-meduim">House No. / Block / Purok<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="hnum" id="viewdatastudHnum" class="form-control form-control-sm update-field" placeholder="House No. / Block / Purok" style="text-transform: uppercase;">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 fw-meduim">Zipcode<span class="text-danger ms-1">*</span></label>
                            <input type="text" name="zcode" id="zipcode" class="form-control form-control-sm readonlytext update-field" readonly >
                        </div>
                    </div>

                </div>
                <!-- end row-->
                <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
                    <div class=" d-flex justify-content-end gap-2">
                        <a href="javascript:void(0);" class="btn btn-light btm-md">Cancel</a>
                        <button type="submit" class="btn btn-primary btm-md">Save Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection




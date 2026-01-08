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
                    <i class="ti ti-plus me-1"></i>New Outsider Patient
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">
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
                        <span>Outsiders</span>
                    </a>
                </li>
            </ul>
            <!-- tab end -->

            <div class="tab-content">
                <div class="tab-pane show active" id="students">
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap">
                            <thead class="">
                                <tr>
                                    <th>Patient</th>
                                    <th>StudID</th>
                                    <th>Gender</th>
                                    <th>Civil Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="patient-details.html" class="avatar avatar-md me-2">
                                                <img src="{{ asset('assets/img/users/user-08.jpg') }}" alt="product" class="rounded-circle">
                                            </a>
                                            <a href="patient-details.html" class="text-dark fw-semibold">Alberto Ripley <span class="text-body fs-13 fw-normal d-block"> 26, Male </span>  </a>
                                        </div>
                                    </td>
                                    <td>+1 41245 54132</td>                                
                                    <td>
                                        Male
                                    </td>
                                    <td>Single</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="appointments.html" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1">
                                                <i class="ti ti-calendar-cog"></i>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  

        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->
@endsection

<div class="offcanvas offcanvas-offset offcanvas-end" tabindex="-1" id="new_patient_outsider">
    <div class="offcanvas-header d-block pb-0 px-0">
        <div class="border-bottom d-flex align-items-center justify-content-between pb-3 px-3">
            <h5 class="offcanvas-title fs-18 fw-bold">New Outsider Patient</h5>
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
            <button data-bs-dismiss="offcanvas" class="btn btn-primary btm-md" id="filter-submit">Create Create Appointment</button>
        </div>
    </div>
</div>
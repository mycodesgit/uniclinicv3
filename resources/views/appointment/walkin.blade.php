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
                <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a>
                <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">
            <!-- tab start -->
            <ul class="nav nav-tabs nav-bordered mb-3">
                <li class="nav-item">
                    <a href="#consult" data-bs-toggle="tab" aria-expanded="false" class="nav-link active bg-transparent">
                        <span>Consultation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#referral" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                        <span>Referral</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#toothextraction" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                        <span>Tooth Extraction</span>
                    </a>
                </li>
            </ul>
            <!-- tab end -->

            <div class="tab-content">
                <div class="tab-pane show active" id="consult">
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap">
                            <thead class="">
                                <tr>
                                    <th>Patient</th>
                                    <th>Phone</th>
                                    <th>Doctor</th>
                                    <th>Address</th>
                                    <th>Last Visit</th>
                                    <th>Status</th>
                                    <th></th>
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
                                        <div class="d-flex align-items-center">
                                            <a href="doctor-details.html" class="avatar me-2 flex-shrink-0">
                                                <img src="{{ asset('assets/img/doctors/doctor-01.jpg') }}" alt="img" class="rounded-circle">
                                            </a>
                                            <div>
                                            <h6 class="fs-14 mb-1"><a href="doctor-details.html" class="fw-semibold">Dr. Mick Thompson</a></h6>
                                            <p class="mb-0 fs-13">Cardiologist</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Miami, Florida</td>
                                    <td>30 Apr 2025</td>
                                    <td><span class="badge badge-soft-success rounded text-success border border-success fs-13 fw-medium">Available</span></td>
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
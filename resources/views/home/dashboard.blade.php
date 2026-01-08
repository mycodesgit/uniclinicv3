@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-0">Dashboard</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a>
                <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">

            <!-- col start -->
            <div class="col-xl-4 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Total Appointments</p>
                                <div class="d-flex align-items-center gap-1">
                                    <h3 class="fw-bold mb-0">658</h3>
                                    <span class="badge fw-medium bg-success flex-shrink-0">+95%</span>
                                </div>
                            </div>
                            <span class="avatar border border-primary text-primary rounded-2 flex-shrink-0"><i class="ti ti-calendar-heart fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div id="s-col-5" class="chart-set"></div>
                            <span class="badge fw-medium badge-soft-success flex-shrink-0 ms-2">+21% <i class="ti ti-arrow-up ms-1"></i></span>
                            <p class="ms-1 fs-13 text-truncate">in last 7 Days </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->

            <!-- col start -->
            <div class="col-xl-4 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Online Consultations</p>
                                <div class="d-flex align-items-center gap-1">
                                    <h3 class="fw-bold mb-0">125</h3>
                                    <span class="badge fw-medium bg-danger flex-shrink-0">-15%</span>
                                </div>
                            </div>
                            <span class="avatar border border-danger text-danger rounded-2 flex-shrink-0"><i class="ti ti-users fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div id="s-col-6" class="chart-set"></div>
                            <span class="badge fw-medium badge-soft-danger flex-shrink-0 ms-2">+21% <i class="ti ti-arrow-down ms-1"></i></span>
                            <p class="ms-1 fs-13 text-truncate">in last 7 Days </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->

            <!-- col start -->
            <div class="col-xl-4 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Cancelled Appointments</p>
                                <div class="d-flex align-items-center gap-1">
                                    <h3 class="fw-bold mb-0">35</h3>
                                    <span class="badge fw-medium bg-success flex-shrink-0">+45%</span>
                                </div>
                            </div>
                            <span class="avatar border border-success text-success rounded-2 flex-shrink-0"><i class="ti ti-versions fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div id="s-col-7" class="chart-set"></div>
                            <span class="badge fw-medium badge-soft-success flex-shrink-0 ms-2">+31% <i class="ti ti-arrow-up ms-1"></i></span>
                            <p class="ms-1 fs-13 text-truncate">in last 7 Days </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- col end -->

        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->
@endsection
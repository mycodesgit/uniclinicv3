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

            <div class="col-xl-3 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Patient Today</p>
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

            <div class="col-xl-3 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Patient this Month</p>
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

            <div class="col-xl-3 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Walk-In Appointments</p>
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

            <div class="col-xl-3 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Online Appointments</p>
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
            

        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->
@endsection
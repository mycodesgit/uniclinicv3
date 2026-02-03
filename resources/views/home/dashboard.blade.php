@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 mb-4">
            <div>
                <h4 class="fw-bold mb-0">Dashboard</h4>
            </div>
            {{-- <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="javascript:void(0);" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a>
                <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a>
            </div> --}}
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">

            <div class="col-xl-3 d-flex">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1">Patient Consultation Today</p>
                                <div class="d-flex align-items-center gap-1">
                                    <h1 class="fw-bold mb-0">{{ $ptodayvisits }}</h1>
                                </div>
                            </div>
                            <span class="avatar border border-primary text-primary rounded-2 flex-shrink-0"><i class="ti ti-calendar-heart fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div>
                                <img src="{{ asset('assets/img/icons/icon-4.svg') }}" width="70px" class="img-fluid">
                            </div>
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
                                    <h1 class="fw-bold mb-0">{{ $pthismonthvisits }}</h1>
                                </div>
                            </div>
                            <span class="avatar border border-primary text-primary rounded-2 flex-shrink-0"><i class="ti ti-calendar-heart fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div>
                                <img src="{{ asset('assets/img/icons/icon-3.png') }}" width="70px" class="img-fluid">
                            </div>
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
                                    <h3 class="fw-bold mb-0">0</h3>
                                </div>
                            </div>
                            <span class="avatar border border-primary text-primary rounded-2 flex-shrink-0"><i class="ti ti-calendar-heart fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div class="chart-set"></div>
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
                                    <h3 class="fw-bold mb-0">0</h3>
                                </div>
                            </div>
                            <span class="avatar border border-primary text-primary rounded-2 flex-shrink-0"><i class="ti ti-calendar-heart fs-20"></i></span>
                        </div>
                        <div class="d-flex align-items-end">
                            <div class="chart-set"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" >
                        <h3 class="card-title">Patient Visit This Month - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="currcollegevisitBarChartMonthh" style="height:250px; min-height:250px"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" >
                        <h3 class="card-title">Patient Visit Today - {{ \Carbon\Carbon::now()->format('F d, Y') }}</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="currcollegevisitBarChart" style="height:250px; min-height:250px"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header" >
                        <h3 class="card-title">Patient Visit This Month - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-truncate">Calendar</h5> 
                    </div>
                    <div class="card-body">
                        <div class="datepic mb-1"></div>
                    </div>
                </div>
            </div>
            

        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->
@endsection
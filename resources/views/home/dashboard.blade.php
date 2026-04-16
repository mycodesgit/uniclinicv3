@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Dashboard</h1>
                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="facultyCount" class="fw-bold h1">{{ $ptodayvisits }}</h3>
                                        <span>Patient Consultation Today</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-code fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="facultyCount" class="fw-bold h1">{{ $pthismonthvisits }}</h3>
                                        <span>Patient this Month</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-code fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="facultyCount" class="fw-bold h1">1</h3>
                                        <span>Walk-In Appointments</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-code fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12">
                        <div class="card card-animate">
                            <div class="card-body p-6">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>
                                        <h3 id="facultyCount" class="fw-bold h1">1</h3>
                                        <span>Online Appointments</span>
                                    </div>
                                    <div>
                                        <i class="ti ti-user-code fs-1 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-animate mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                                <h3 class="h5 mb-0">Patient Visit This Month - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="currcollegevisitBarChartMonthh" style="height:250px; min-height:250px"></canvas>
                            </div>
                        </div>

                        <div class="card card-animate">
                            <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
                                <h3 class="h5 mb-0">Patient Visit Today - {{ \Carbon\Carbon::now()->format('F d, Y') }}</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="currcollegevisitBarChart" style="height:250px; min-height:250px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

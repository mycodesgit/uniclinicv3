@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h1 class="h4 fw-bold mb-1" style="letter-spacing: -0.02em;">MDHU Dashboard Overview</h1>
                        <p class="text-muted small mb-0">System metrics, patient consultations, medical records, and daily activity logs.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <form id="yearForm" class="d-flex align-items-center gap-2" onsubmit="return false;">
                            <label for="yearSelect" class="form-label mb-0 small text-muted">Year:</label>
                            <select id="yearSelect" name="year" class="form-select form-select-sm">
                                @php $selectedYear = $selectedYear ?? request('year', date('Y')); @endphp
                                @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                                    <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <span id="yearLoading" class="spinner-border spinner-border-sm text-secondary d-none" role="status" aria-hidden="true"></span>
                        </form>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-animate p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-medium">Visits — <span id="ptodayLabel">{{ $dayLabel ?? \Carbon\Carbon::now()->format('F d, Y') }}</span></span>
                                <i class="ti ti-users text-muted fs-5"></i>
                            </div>
                            <div class="h2 fw-bold mb-1" id="ptodayCount">{{ number_format($ptodayvisits ?? 0) }}</div>
                            <small class="text-muted"><span class="text-success fw-semibold"><i class="ti ti-arrow-up-right"></i> Patient</span> consultations</small>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-animate p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-medium">Visits — <span id="pthismonthLabel">{{ $monthLabel ?? \Carbon\Carbon::now()->format('F Y') }}</span></span>
                                <i class="ti ti-file-check text-muted fs-5"></i>
                            </div>
                            <div class="h2 fw-bold mb-1" id="pthismonthCount">{{ number_format($pthismonthvisits ?? 0) }}</div>
                            <small class="text-muted"><span class="text-success fw-semibold"><i class="ti ti-check"></i> Patient</span> consultations</small>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-animate p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-medium">Total Available Medicines</span>
                                <i class="ti ti-number text-muted fs-5"></i>
                            </div>
                            <div class="h2 fw-bold mb-1">{{ number_format($medcount ?? 0) }}</div>
                            <small class="text-muted"><span class="text-success fw-semibold">Available</span> Medicines</small>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-animate p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-medium">Total Low Stock Medicines</span>
                                <i class="ti ti-alert-triangle text-muted fs-5"></i>
                            </div>
                            <div class="h2 fw-bold mb-1">{{ number_format($medoutstockcount ?? 0) }}</div>
                            <small class="text-muted"><span class="text-success fw-semibold">Low Stock</span> Medicines</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-animate mb-3">
                            <div class="card-body">
                                <div>
                                    <h6 class="fw-bold mb-0">Patient Visit This Months</h6>
                                    <small class="text-muted">Monthly breakdown of patients per colleges <span id="collegeMonthLabel">{{ $monthLabel ?? \Carbon\Carbon::now()->format('F Y') }}</span></small>
                                </div>
                                <div style="height:250px; min-height:250px">
                                    <canvas id="currcollegevisitBarChartMonthh"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="card card-animate">
                            <div class="card-body">
                                <div>
                                    <h6 class="fw-bold mb-0">Patient Visit Today</h6>
                                    <small class="text-muted">Daily breakdown of patients per colleges <span id="collegeDailyLabel">{{ $dayLabel ?? \Carbon\Carbon::now()->format('F d, Y') }}</span></small>
                                </div>
                                <div style="height:250px; min-height:250px">
                                    <canvas id="currcollegevisitBarChart" style="height:250px; min-height:250px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Widget -->
                    <div class="col-md-6">
                        <div class="card card-animate mb-3">
                            <div class="card-body">
                                <div>
                                    <h6 class="fw-bold mb-0">No. of Patient Visits</h6>
                                    <small class="text-muted">Monthly breakdown of patients for <span id="pvisitYearLabel">{{ $selectedYear ?? date('Y') }}</span></small>
                                </div>
                                <div style="height:250px; min-height:250px">
                                    <canvas id="pvisitMonthlyChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="card card-animate mb-3">
                            <div class="card-body">
                                <div>
                                    <h6 class="fw-bold mb-0">No. of Patient Visits by Category</h6>
                                    <small class="text-muted">Monthly breakdown of patients for <span id="pcatYearLabel">{{ $selectedYear ?? date('Y') }}</span></small>
                                </div>
                                <div style="height:250px; min-height:250px">
                                    <canvas id="pcatvisitMonthlyChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

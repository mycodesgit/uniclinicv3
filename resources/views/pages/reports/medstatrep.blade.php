@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Medical Statistics Report</h1>
                <hr>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="fas fa-search"></i> Search to Generate Report
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('reports.medical.statistic.store') }}" method="GET" id="medStatisticForm">
    
    <div class="row g-3">
        {{-- 1. Reporting Period Type --}}
        <div class="col-md-2">
            <label for="reporting_period" class="form-label fw-bold">Reporting Period: <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm @error('reporting_period') is-invalid @enderror" id="reporting_period" name="reporting_period" onchange="handlePeriodChange(this.value)">
                <option value="" selected disabled>Select Period Type</option>
                <option value="monthly" {{ request('reporting_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="quarterly" {{ request('reporting_period') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                <option value="yearly" {{ request('reporting_period') == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
            @error('reporting_period')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 2. Dynamic Period Value Container --}}
        <div class="col-md-2">
            <label for="period_value" class="form-label fw-bold" id="period_label">Period Value: <span class="text-danger">*</span></label>

            {{-- Default / Placeholder Input --}}
            <input type="text" class="form-control form-control-sm period-input" id="period_default" placeholder="Select type first" disabled>

            {{-- Monthly Input --}}
            <div id="wrapper_monthly" class="period-wrapper d-none">
                <select class="form-control form-control-sm period-input @error('period_value') is-invalid @enderror" name="period_value" disabled>
                    <option value="" selected disabled>Select Month</option>
                    <option value="01">01 - January</option>
                    <option value="02">02 - February</option>
                    <option value="03">03 - March</option>
                    <option value="04">04 - April</option>
                    <option value="05">05 - May</option>
                    <option value="06">06 - June</option>
                    <option value="07">07 - July</option>
                    <option value="08">08 - August</option>
                    <option value="09">09 - September</option>
                    <option value="10">10 - October</option>
                    <option value="11">11 - November</option>
                    <option value="12">12 - December</option>
                </select>
            </div>

            {{-- Quarterly Input --}}
            <div id="wrapper_quarterly" class="period-wrapper d-none">
                <select class="form-control form-control-sm period-input @error('period_value') is-invalid @enderror" name="period_value" disabled>
                    <option value="" selected disabled>Select Quarter</option>
                    <option value="01">Q1 (1st Quarter)</option>
                    <option value="02">Q2 (2nd Quarter)</option>
                    <option value="03">Q3 (3rd Quarter)</option>
                    <option value="04">Q4 (4th Quarter)</option>
                </select>
            </div>

            {{-- Yearly Option Text Output (when Yearly selected) --}}
            <div id="wrapper_yearly" class="period-wrapper d-none">
                <input type="text" class="form-control form-control-sm period-input" name="period_value" value="Full Year" readonly disabled>
            </div>

            @error('period_value')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- 3. Dedicated Year Dropdown --}}
        <div class="col-md-2" id="year_container">
            <label for="year" class="form-label fw-bold">Year: <span class="text-danger">*</span></label>
            <select class="form-control form-control-sm @error('year') is-invalid @enderror" id="year" name="year">
                @php $currentYear = date('Y'); @endphp
                @for ($y = $currentYear; $y >= $currentYear - 10; $y--)
                    <option value="{{ $y }}" {{ request('year', $currentYear) == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
            @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 4. Prepared By --}}
        <div class="col-md-2">
            <label for="prepared_by" class="form-label fw-bold">Prepared By: <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('prepared_by') is-invalid @enderror" id="prepared_by" name="prepared_by" value="{{ Auth::user()->fname ?? '' }} {{ Auth::user()->lname ?? '' }}" required readonly>
            @error('prepared_by')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 5. Position --}}
        <div class="col-md-2">
            <label for="position" class="form-label fw-bold">Position: <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-sm @error('position') is-invalid @enderror" id="position" name="position" value="{{ Auth::user()->role ?? '' }}" required readonly>
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 6. Submit Button --}}
        <div class="col-md-2">
            <label class="form-label fw-bold">&nbsp;</label>
            <button type="submit" class="btn btn-success btn-sm form-control">
                <i class="bi bi-file-earmark-pdf me-1"></i> Generate Report
            </button>
        </div>
    </div>
</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handlePeriodChange(type) {
    // Hide all wrappers and disable all inputs
    document.querySelectorAll('.period-wrapper').forEach(el => el.classList.add('d-none'));
    document.querySelectorAll('.period-input').forEach(el => el.disabled = true);

    const defaultInput = document.getElementById('period_default');

    if (type === 'monthly') {
        defaultInput.classList.add('d-none');
        const activeWrapper = document.getElementById('wrapper_monthly');
        activeWrapper.classList.remove('d-none');
        activeWrapper.querySelector('.period-input').disabled = false;
        
    } else if (type === 'quarterly') {
        defaultInput.classList.add('d-none');
        const activeWrapper = document.getElementById('wrapper_quarterly');
        activeWrapper.classList.remove('d-none');
        activeWrapper.querySelector('.period-input').disabled = false;

    } else if (type === 'yearly') {
        defaultInput.classList.add('d-none');
        const activeWrapper = document.getElementById('wrapper_yearly');
        activeWrapper.classList.remove('d-none');
        activeWrapper.querySelector('.period-input').disabled = false;

    } else {
        defaultInput.classList.remove('d-none');
    }
}

// Trigger initial setup on page load if old inputs exist
document.addEventListener('DOMContentLoaded', function() {
    const selectedType = document.getElementById('reporting_period').value;
    if (selectedType) {
        handlePeriodChange(selectedType);
    }
});
    </script>
@endsection

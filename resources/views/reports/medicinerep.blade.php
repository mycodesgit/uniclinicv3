@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Medicine Report</h1>
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
                                <form action="{{ route('reports.medicine.store') }}" method="GET">
                                    @csrf
                                    
                                    <div class="row g-3">
                                        {{-- Reporting Period --}}
                                        <div class="col-md-2">
                                            <label for="reporting_period" class="form-label fw-bold">Month: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="month" id="monthSelect">
                                                <option disabled selected> --Select-- </option>
                                                @foreach(range(1,12) as $m)
                                                    <option value="{{ sprintf('%02d', $m) }}" {{ request()->get('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('reporting_period')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Submit Button --}}
                                        <div class="col-md-2">
                                            <label class="form-label fw-bold">&nbsp;</label>
                                            <button type="submit" class="btn btn-success form-control">
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
@endsection

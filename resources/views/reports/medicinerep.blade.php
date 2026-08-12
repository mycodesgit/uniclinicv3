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
                                <form action="{{ route('reports.medicine.store') }}" method="GET" id="medForm">
                                    @csrf
                                    
                                    <div class="row g-3">
                                        {{-- Reporting Period --}}
                                        <div class="col-md-3">
                                            <label for="monthSelect" class="form-label fw-bold">Month: <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm @error('month') is-invalid @enderror" id="monthSelect" name="month">
                                                <option value="" disabled {{ old('month', request('month')) ? '' : 'selected' }}> --Select Month-- </option>
                                                @foreach(range(1,12) as $m)
                                                    @php $val = sprintf('%02d', $m); @endphp
                                                    <option value="{{ $val }}" {{ old('month', request('month')) == $val ? 'selected' : '' }}>
                                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            {{-- Error Message Output --}}
                                            @error('month')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        {{-- Submit Button --}}
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
@endsection

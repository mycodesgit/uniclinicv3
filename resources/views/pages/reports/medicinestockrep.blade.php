@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h1 class="h4 fw-bold mb-1" style="letter-spacing: -0.02em;">Medicines Stock Report</h1>
                        <p class="text-muted small mb-0">Generate Medicines Stock Report</p>
                    </div>
                </div>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card card-animate">
                            <div class="card-header pt-3">
                                <h6 class="card-title">
                                    <i class="fas fa-search"></i> Search to Generate Report
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('reports.stockmedicine.store') }}" method="GET" id="medStockForm">
                                    @csrf

                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="medicine-dropdown" class="form-label fw-bold">Medicine: <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm @error('medicine') is-invalid @enderror" id="medicine-dropdown" name="medicine">
                                                <option disabled selected> --Select-- </option>
                                            </select>

                                            {{-- Error Message Output --}}
                                            @error('medicine')
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

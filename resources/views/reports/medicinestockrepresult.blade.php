@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Medicine Stock Report</h1>
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

                                <div class="page-header mt-3" style="border-bottom: 1px solid #04401f;"></div>

                                <iframe id="pdfIframe" 
                                        src="{{ route('reports.stockmedicine.generate', request()->all()) }}"
                                        style="width: 100%; height: 580px;" 
                                        frameborder="0" 
                                        class="mt-3">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

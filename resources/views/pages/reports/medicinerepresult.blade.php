@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h1 class="h4 fw-bold mb-1" style="letter-spacing: -0.02em;">Medicines Report</h1>
                        <p class="text-muted small mb-0">Generate Medicines Report</p>
                    </div>
                </div>
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

                                <div class="page-header mt-3" style="border-bottom: 1px solid #04401f;"></div>

                                <iframe id="pdfIframe"
                                        src="{{ route('reports.medicine.generate', request()->all()) }}"
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

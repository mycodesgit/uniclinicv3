@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h1 class="h4 fw-bold mb-1" style="letter-spacing: -0.02em;"> <a href="{{ route('patients.students') }}" class="text-dark"> <i class="ti ti-chevron-left me-1"></i>Patients</a></h1>
                        <p class="text-muted small mb-0">Manage Employee Patient Records</p>
                    </div>
                </div>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card card-animate">
                            <div class="row align-items-end">
                                <div class="col-xl-9 col-lg-8">
                                    <div class="d-sm-flex align-items-center position-relative z-0 overflow-hidden p-3">
                                        {{-- <img src="{{ asset('assets/img/icons/shape-01.svg') }}" alt="img" class="z-n1 position-absolute end-0 top-0 d-none d-lg-flex"> --}}
                                        <a href="javascript:void(0);" class="avatar avatar-xxxl patient-avatar me-2 flex-shrink-0">
                                            <img src="{{ asset('assets/img/user.png') }}" alt="product" class="rounded">
                                        </a>
                                        <div>
                                            <p class="mb-0 d-inline-flex align-items-center mb-1">
                                                <i class="ti ti-id me-1 text-dark"></i>Employee ID No. : <span class="text-primary ms-1" style="font-weight: bold">{{ $patients->emp_ID }}</span>
                                            </p>
                                            <h5 class="mb-1"><span style="color: teal; font-weight: bold">{{ $patients->fname }} {{ $patients->lname }}</span></h5>
                                            <p class="mb-3">{{ $patients->address }}</p>
                                            <div class="d-flex align-items-center flex-wrap">
                                                <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-phone me-1 text-dark"></i>Phone No. : <span class="text-dark ms-1">0{{ $patients->mobile }}</span></p>
                                                <span class="mx-2 text-light">|</span>
                                                <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1 text-dark"></i>Last Visited : <span class="text-dark ms-1">30 Apr 2025</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4">
                                    <div class="p-3 text-lg-end">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav nav-pills bg-light p-2 rounded-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-one-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-one" type="button" role="tab"
                                    aria-controls="pills-one" aria-selected="true"> <i class="ti ti-user-bolt"></i>
                                    Personal Information
                                </button>
                            </li>
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-two-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-two" type="button" role="tab"
                                    aria-controls="pills-two" aria-selected="false" tabindex="-1"> <i class="ti ti-file-info"></i>
                                    Patient Data Records
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <div class="tab-content mt-1" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                <div class="card card-animate">
                                    <div class="card-header">
                                        <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: teal"><i class="ti ti-user me-1"></i> Personal Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Last Name<span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control form-control-sm readonlytext" value="{{ strtoupper($patients->lname) }}" data-column-id="{{ $patients->id }}" data-column-name="lname" placeholder="Enter Last Name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">First Name<span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control form-control-sm readonlytext" value="{{ strtoupper($patients->fname) }}" data-column-id="{{ $patients->id }}" data-column-name="fname" placeholder="Enter First Name" readonly>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Middle Name<span class="text-danger ms-1">*</span></label>
                                                    <input type="text" class="form-control form-control-sm readonlytext" value="{{ strtoupper($patients->mname) }}" data-column-id="{{ $patients->id }}" data-column-name="mname" placeholder="Enter Middle  Name" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Ext. Name<span class="text-danger ms-1">*</span></label>
                                                    <select name="ext" class="form-control form-control-sm" readonly>
                                                        <option value=""> --Select-- </option>
                                                        <option value="Jr." data-column-id="{{ $patients->id }}" data-column-name="ext" @if($patients->ext == "Jr.") selected @endif>Jr.</option>
                                                        <option value="Sr." data-column-id="{{ $patients->id }}" data-column-name="ext" @if($patients->ext == "Sr.") selected @endif>Sr.</option>
                                                        <option value="III" data-column-id="{{ $patients->id }}" data-column-name="ext" @if($patients->ext == "III") selected @endif>III</option>
                                                        <option value="IV"  data-column-id="{{ $patients->id }}" data-column-name="ext" @if($patients->ext_name == "IV") selected @endif>IV</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Date of Birth<span class="text-danger ms-1">*</span></label>
                                                    <input type="date" value="{{ $patients->bday }}" class="form-control form-control-sm" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Sex<span class="text-danger ms-1">*</span></label>
                                                    <select name="sex" id="sex" class="form-control form-control-sm" readonly>
                                                        <option value="Male" data-column-id="{{ $patients->id }}" data-column-name="sex" @if($patients->gender == "Male") selected @endif>Male</option>
                                                        <option value="Female" data-column-id="{{ $patients->id }}" data-column-name="sex" @if($patients->gender == "Female") selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Height (cm)</label>
                                                    <input type="text" name="height_cm" id="height_cm" value="{{ $patients->height_cm }}" data-column-id="{{ $patients->id }}" data-column-name="height_cm" class="form-control form-control-sm update-field" placeholder="N/A">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Height (ft)</label><br>
                                                    <input type="text" name="height_ft" id="height_ft" value="{{ $patients->height_ft }}" data-column-id="{{ $patients->id }}" data-column-name="height_ft" class="form-control form-control-sm update-field" placeholder="N/A">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Weight (kg)</label><br>
                                                    <input type="text" name="weight_kg" id="weight_kg" value="{{ $patients->weight_kg }}" data-column-id="{{ $patients->id }}" data-column-name="weight_kg" class="form-control form-control-sm update-field" placeholder="N/A">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Weight (lb)</label><br>
                                                    <input type="text" name="weight_lb" id="weight_lb" value="{{ $patients->weight_lb }}" data-column-id="{{ $patients->id }}" data-column-name="weight_lb" class="form-control form-control-sm update-field" placeholder="N/A">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">BMI:</label>
                                                    <input type="text" name="bmi" id="bmi" value="{{ $patients->bmi }}" data-column-id="{{ $patients->id }}" data-column-name="bmi" class="form-control form-control-sm" placeholder="N/A" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">BMI Category:</label>
                                                    <input type="text" name="bami_cat" id="bmi_cat" class="form-control form-control-sm" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Temp:</label>
                                                    <input type="text" name="temp" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="temp" value="{{ $patients->temp }}" placeholder="Enter Tmp.">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">PR:</label>
                                                    <input type="text" name="pr" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="pr" value="{{ $patients->pr }}" placeholder="Enter PR">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">BP:</label>
                                                    <input type="text" name="bp" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="bp" value="{{ $patients->bp }}" placeholder="Enter BP">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">RR:</label>
                                                    <input type="text" name="rr" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="rr" value="{{ $patients->rr }}" placeholder="Enter RR">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-2">
                                            <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom mt-4">
                                                <div>
                                                    <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: teal"><i class="ti ti-home me-1"></i> Home Address</h6>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label mb-1 fw-medium">Address (<span class="text-danger ms-1">Readonly</span>)</label>
                                                    <input type="text" class="form-control form-control-sm readonlytext" value="{{ $patientinfo->brgy_name }}, {{ $patientinfo->city_name }}, {{ $patientinfo->province_name }}, {{ $patientinfo->region_name }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

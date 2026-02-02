@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0 d-flex align-items-center"> <a href="#" class="text-dark"> <i class="ti ti-chevron-left me-1"></i>Patients Details</a></h4>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="card">
            <div class="row align-items-end">
                <div class="col-xl-9 col-lg-8">
                    <div class="d-sm-flex align-items-center position-relative z-0 overflow-hidden p-3">
                        {{-- <img src="{{ asset('assets/img/icons/shape-01.svg') }}" alt="img" class="z-n1 position-absolute end-0 top-0 d-none d-lg-flex"> --}}
                        <a href="javascript:void(0);" class="avatar avatar-xxxl patient-avatar me-2 flex-shrink-0">
                            <img src="{{ asset('assets/img/user.png') }}" alt="product" class="rounded">
                        </a>
                        <div>
                            <p class="mb-0 d-inline-flex align-items-center mb-1"><i class="ti ti-id me-1 text-dark"></i>Student ID No. : <span class="text-primary ms-1" style="font-weight: bold">{{ $patients->stud_id }}</span></p>
                            <h5 class="mb-1"><span style="color: teal; font-weight: bold">{{ $patients->fname }} {{ $patients->lname }}</span></h5>
                            <p class="mb-3">{{ $patients->address }}</p>
                            <div class="d-flex align-items-center flex-wrap">
                                <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-phone me-1 text-dark"></i>Phone No. : <span class="text-dark ms-1">0{{ $patients->contact }}</span></p>
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

        <!-- tab start -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#personalinfo" data-bs-toggle="tab" aria-expanded="false" class="nav-link active bg-transparent">
                    <span>Personal Information</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#medhistory" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Medical History</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#physexam" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Physical Examination</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#datarecords" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Patient Data Records</span>
                </a>
            </li>
        </ul>
        <!-- tab end -->

        <div class="row">
            <div class="tab-content">
                <div class="tab-pane show active" id="personalinfo">
                    <div class="col-md-12">
                        <div class="card shadow-sm flex-fill w-100">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0" style="color: teal"><i class="ti ti-user-star me-1"></i>Personal Information</h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
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

                                <div class="row">
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
        <!-- row end -->
                        
    </div>
    <!-- End Content -->


@endsection


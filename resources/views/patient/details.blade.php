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
                        <a href="#" class="btn btn-primary"><i class="ti ti-calendar-event me-1"></i>Pre-entrance Health Examination</a>
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
                                            <input type="text" class="form-control form-control-sm readonlytext update-field" value="{{ strtoupper($patients->lname) }}" data-column-id="{{ $patients->id }}" data-column-name="lname" placeholder="Enter Last Name" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">First Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm readonlytext update-field" value="{{ strtoupper($patients->fname) }}" data-column-id="{{ $patients->id }}" data-column-name="fname" placeholder="Enter First Name" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Middle Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm readonlytext update-field" value="{{ strtoupper($patients->mname) }}" data-column-id="{{ $patients->id }}" data-column-name="mname" placeholder="Enter Middle  Name" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Ext. Name<span class="text-danger ms-1">*</span></label>
                                            <select name="ext" class="form-control form-control-sm update-field">
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
                                            <input type="date" value="{{ $patients->bday }}" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Sex<span class="text-danger ms-1">*</span></label>
                                            <select name="sex" id="sex" class="form-control form-control-sm">
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
                                            <input type="text" name="address" class="form-control form-control-sm readonlytext update-field" id="viewdatastudAddress" data-column-id="{{ $patients->id }}" data-column-name="address" value="{{ $patients->address }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Region<span class="text-danger ms-1">*</span></label>
                                            <select id="region" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Region</option>
                                                @foreach($regions as $region)
                                                    <option value="{{ $region->region_id }}" data-name="{{ $region->name }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="region_name" class="update-field" name="region" data-column-id="{{ $patients->id }}" data-column-name="region" value="{{ $patients->region }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Province<span class="text-danger ms-1">*</span></label>
                                            <select id="province" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Province</option>
                                            </select>
                                            <input type="hidden" id="province_name" class="update-field" name="province" data-column-id="{{ $patients->id }}" data-column-name="province" value="{{ $patients->province }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">City/Municipality<span class="text-danger ms-1">*</span></label>
                                            <select id="city" class="form-control form-control-sm select2bs4">
                                                <option value="">Select City</option>
                                            </select>
                                            <input type="hidden" id="city_name" class="update-field" name="city" data-column-id="{{ $patients->id }}" data-column-name="city" value="{{ $patients->city }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Barangay<span class="text-danger ms-1">*</span></label>
                                            <select id="barangay" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Barangay</option>
                                            </select>
                                            <input type="hidden" id="brgy_name" class="update-field" name="brgy" data-column-id="{{ $patients->id }}" data-column-name="brgy">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">House No. / Block / Purok<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="hnum" id="viewdatastudHnum" class="form-control form-control-sm update-field" placeholder="House No. / Block / Purok" style="text-transform: uppercase;" data-column-id="{{ $patients->id }}" data-column-name="hnum" value="{{ $patients->hnum }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Zipcode<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="zcode" id="zipcode" class="form-control form-control-sm readonlytext update-field" data-column-id="{{ $patients->id }}" data-column-name="zcode" readonly >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom mt-4">
                                        <div>
                                            <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: teal"><i class="ti ti-user me-1"></i> Guardian Details</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Select Father & Mother / Guardian<span class="text-danger ms-1">*</span></label>
                                            <select class="form-control form-control-sm" id="parentType">
                                                <option value=""> --Select-- </option>
                                                <option value="father&mother">Father & Mother</option>
                                                <option value="guardian">Guardian</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 parent-fields">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Father<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field"
                                                value="{{ $patients->stud_father }}"
                                                name="stud_father"
                                                placeholder="Enter Father's Name" id="parentType" data-column-id="{{ $patients->id }}" data-column-name="stud_father">
                                        </div>
                                    </div>

                                    <div class="col-md-3 parent-fields">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Mother<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field"
                                                value="{{ $patients->stud_mother }}"
                                                name="stud_mother" data-column-id="{{ $patients->id }}" data-column-name="stud_mother"
                                                placeholder="Enter Mother's Name">
                                        </div>
                                    </div>

                                    <div class="col-md-3 guardian-field">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Guardian<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field"
                                                value="{{ $patients->stud_guardian }}"
                                                name="stud_guardian" data-column-id="{{ $patients->id }}" data-column-name="stud_guardian"
                                                placeholder="Enter Guardian's Name">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Region<span class="text-danger ms-1">*</span></label>
                                            <select id="gregion" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Region</option>
                                                @foreach($regions as $region)
                                                    <option value="{{ $region->region_id }}" data-name="{{ $region->name }}">{{ $region->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="gregion_name" name="gregion">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Province<span class="text-danger ms-1">*</span></label>
                                            <select id="gprovince" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Province</option>
                                            </select>
                                            <input type="hidden" id="gprovince_name" name="gprovince">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">City/Municipality<span class="text-danger ms-1">*</span></label>
                                            <select id="gcity" class="form-control form-control-sm select2bs4">
                                                <option value="">Select City</option>
                                            </select>
                                            <input type="hidden" id="gcity_name" name="gcity">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Barangay<span class="text-danger ms-1">*</span></label>
                                            <select id="gbarangay" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Barangay</option>
                                            </select>
                                            <input type="hidden" id="gbrgy_name" name="gbrgy_name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">House No. / Block / Purok<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="ghnum" id="gviewdatastudHnum" class="form-control form-control-sm" placeholder="House No. / Block / Purok" style="text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Zipcode<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="gzcode" id="gzipcode" class="form-control form-control-sm readonlytext" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Guardian Address (<span class="text-danger ms-1">Readonly</span>)</label>
                                            <input type="text" name="guardian_address" class="form-control form-control-sm readonlytext update-field" id="gviewdatastudAddress" data-column-id="{{ $patients->id }}" data-column-name="guardian_address" value="{{ $patients->guardian_address }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="medhistory">
                    <div class="col-md-12">
                        <div class="card shadow-sm flex-fill w-100">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0"><i class="ti ti-prescription me-1"></i>Medical History</h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-md-3 text-center bg-primary text-white">
                                        <strong>Disease</strong>
                                    </div>
                                    <div class="col-md-3 text-center bg-primary text-white">
                                        <strong>Specific Disease Remarks</strong>
                                    </div>
                                    <div class="col-md-2 text-center bg-primary text-white">
                                        <strong>Hospital Confinement</strong>
                                    </div>
                                    <div class="col-md-4 text-center bg-primary text-white">
                                        <strong>Date, if confined</strong>
                                    </div>
                                </div>
                                @php
                                    $labels = [
                                        "Allergy (Food, Medicine.)",
                                        "COVID-19 Infection",
                                        "Nosebleed",
                                        "Dengue Fever",
                                        "Rheumatic Fever",
                                        "Typhoid Fever",
                                        "Arthritis",
                                        "Urinary Tract Infect, STD",
                                        "Amoebiasis",
                                        "Hyperacidity",
                                        "Asthma",
                                        "Hepatitis A/B",
                                        "Heart Disease",
                                        "Mumps",
                                        "Tuberculosis, Pneumonia",
                                        "Chicken Pox",
                                        "Measles",
                                        "Fainting Spells. Seizure",
                                        "Hernia",
                                        "Thyroid Disease, Cancer",
                                    ];
                                @endphp
                                
                                <br>

                                <div class="row">
                                    @for ($i = 0; $i < 20; $i++)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="disease_{{ $i }}" class="form-check-input update-field1" data-column-id="{{ $patients->id }}" data-column-name="disease" data-array="{{ $i }}" value="1" @if(isset($patients->disease[$i]) && $patients->disease[$i] == 1) checked @endif>
                                                <label class="form-check-label">{{ $labels[$i % count($labels)] }}</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="text" name="disease_rem_{{ $i }}" class="form-control form-control-sm w-100 custom-input update-field1" data-column-id="{{ $patients->id }}" data-column-name="disease_rem" data-array="{{ $i }}" placeholder="Enter remarks here">
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <div>
                                                <input type="radio" class="form-check-input update-field1" id="hpcyes" name="hospital_confine_{{ $i }}" id="hospital_confine_{{ $i }}" data-column-id="{{ $patients->id }}" data-column-name="hospital_confine" data-array="{{ $i }}">
                                                <label class="form-check-label mr-3" for="hpcyes">Yes</label>&emsp;
                                                <input type="radio" class="form-check-input update-field1" id="hpcno" name="hospital_confine_{{ $i }}" id="hospital_confine_{{ $i }}" data-column-id="{{ $patients->id }}" data-column-name="hospital_confine" data-array="{{ $i }}">
                                                <label class="form-check-label" for="hpcno">No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_hospitaliz_{{ $i }}" class="form-control form-control-sm w-100 custom-input update-field1" data-column-id="{{ $patients->id }}" data-column-name="date_hospitaliz" data-array="{{ $i }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_hospitaliz1_{{ $i }}" class="form-control form-control-sm w-100 custom-input update-field1" data-column-id="{{ $patients->id }}" data-column-name="date_hospitaliz1" data-array="{{ $i }}">
                                        </div>
                                    @endfor
                                </div>

                                <hr>

                                <h5 class="fw-bold mb-0" style="color: teal"><i class="ti ti-first-aid-kit me-1"></i>IMMUNIZATIONS</h5><br>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="0" value="1">
                                            <label class="form-check-label">Chicken Pox</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="1" value="1">
                                            <label class="form-check-label">Hepatitis A</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="2" value="1">
                                            <label class="form-check-label">Influenza</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="3" value="1">
                                            <label class="form-check-label">Tetanus Toxoid</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="4" value="1">
                                            <label class="form-check-label">HPV Vaccine</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="5" value="1">
                                            <label class="form-check-label">Hepatitis B</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="6" value="1">
                                            <label class="form-check-label">Pneumonia</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="immunization1" data-column-id="{{ $patients->id }}" data-column-name="immunization1" data-array="7" value="1">
                                            <label class="form-check-label">Rabies</label>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Covid Vaccine</label>
                                            <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}"  data-array="0" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">1st Dose</label>
                                            <input type="date" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}"  data-array="1" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Covid Vaccine</label>
                                            <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="2" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">2nd Dose</label>
                                            <input type="date" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="3" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Booster Dose</label>
                                            <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="4" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">1st Dose</label>
                                            <input type="date" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="5" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Booster Dose</label>
                                            <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="6" data-column-name="immunization2">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">2nd Dose</label>
                                            <input type="date" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-array="7" data-column-name="immunization2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Smoking</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="smoking" data-array="0" placeholder="Sticks" value="{{ isset(explode(',', $patients->smoking)[0]) ? explode(',', $patients->smoking)[0] : '' }}">
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="smoking" data-array="1" placeholder="Years" value="{{ isset(explode(',', $patients->smoking)[1]) ? explode(',', $patients->smoking)[1] : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Drinking</label>
                                            <div class="row">
                                                <div class="col-2">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="drinking" data-array="0" value="{{ isset(explode(',', $patients->drinking)[0]) ? explode(',', $patients->drinking)[0] : '' }}">
                                                </div>
                                                <div class="col-2 text-center">
                                                    Beer per
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="drinking" data-array="1" value="{{ isset(explode(',', $patients->drinking)[1]) ? explode(',', $patients->drinking)[1] : '' }}">
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="drinking" data-array="2" value="{{ isset(explode(',', $patients->drinking)[2]) ? explode(',', $patients->drinking)[2] : '' }}">
                                                </div>
                                                <div class="col-2 text-center">
                                                    Shots per
                                                </div>
                                                <div class="col-2">
                                                    <input type="text" class="form-control form-control-sm update-field1" data-column-id="{{ $patients->id }}" data-column-name="drinking" data-array="3" value="{{ isset(explode(',', $patients->drinking)[3]) ? explode(',', $patients->drinking)[3] : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Menarche</label>
                                            <input type="text" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="Menarche" value="{{ ucfirst(strtolower($patients->Menarche)) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Duration</label>
                                            <input type="text" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="Duration" value="{{ ucfirst(strtolower($patients->Duration)) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Interval</label>
                                            <select name="Interval" id="Interval" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="Interval">
                                                <option value="">--Select--</option>
                                                <option value="0" @if(isset($patients->Interval) && $patients->Interval == 0) checked @endif>Regular</option>
                                                <option value="1" @if(isset($patients->Interval) && $patients->Interval == 1) selected @endif>Irregular</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Pads Used per Day</label>
                                            <input type="number" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="pads_use" value="{{ $patients->pads_use }}" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Menstrual Symtoms</label>
                                            <input type="text" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="mens_symp" value="{{ ucfirst(strtolower($patients->mens_symp)) }}" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">LMP</label>
                                            <input type="date" class="form-control form-control-sm update-field" data-column-id="{{ $patients->id }}" data-column-name="lmp" value="{{ $patients->lmp }}" placeholder="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="physexam">
                    <div class="col-md-12">
                        <div class="card shadow-sm flex-fill w-100">
                            <div class="card-header">
                                <h5 class="fw-bold mb-0"><i class="ti ti-heart me-1"></i>Physical Examination</h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-md-2 text-center bg-secondary">
                                        <strong>FINDING</strong>
                                    </div>
                                    <div class="col-md-2 text-center bg-secondary">
                                        <strong>E/N</strong>
                                    </div>
                                    <div class="col-md-6 text-center bg-secondary">
                                        <strong>FINDING/S</strong>
                                    </div>
                                    <div class="col-md-2 text-center bg-secondary">
                                        <strong>OTHER FINDINGS</strong>
                                    </div>
                                </div>

                                <br>

                                {{-- row1 --}}
                                <div class="row">
                                    <div class="col-md-2">
                                            <label class="form-check-label"><b>SKIN</b></label>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="">
                                            <input type="radio" class="form-check-input update-field1" id="enskinyes" name="en_pexam" data-column-id="{{ $patients->id }}" data-column-name="en_pexam" data-array="0" value="1">
                                            <label class="form-check-label mr-3" for="enskinyes">Yes</label>&emsp;
                                            <input type="radio" class="form-check-input update-field1" id="enskinno" name="en_pexam" data-column-id="{{ $patients->id }}" data-column-name="en_pexam" data-array="0" value="0">
                                            <label class="form-check-label" for="enskinno">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-left">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="0" value="1">
                                            <label class="form-check-label mr-3">Discoloration</label>&emsp;
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="1" value="1">
                                            <label class="form-check-label mr-3">Congenital Marks</label>&emsp;
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="2" value="1">
                                            <label class="form-check-label mr-3">Lesion</label>&emsp;
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="3" value="1">
                                            <label class="form-check-label">Deformity</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control form-control-sm custom-input w-100 update-field1" data-column-id="{{ $patients->id }}"  data-array="0" data-column-name="other_pexam" placeholder="Enter findings here">
                                    </div>
                                </div>
                                {{-- row2 --}}
                                <div class="row">
                                    <div class="col-md-2">
                                            <label class="form-check-label"><b>HEAD</b></label>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="">
                                            <input type="radio" class="form-check-input update-field1" id="enheadyes" name="en_pexam1" data-column-id="{{ $patients->id }}" data-column-name="en_pexam" data-array="1" value="1">
                                            <label class="form-check-label mr-3" for="enheadyes">Yes</label>&emsp;
                                            <input type="radio" class="form-check-input update-field1" id="enheadno" name="en_pexam1" data-column-id="{{ $patients->id }}" data-column-name="en_pexam" data-array="1" value="">
                                            <label class="form-check-label" for="enheadno">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-left">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam1" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="4" value="1">
                                            <label class="form-check-label mr-3">Deformity</label>&emsp;
                                            <input type="checkbox" class="form-check-input update-field1" name="findings_pexam1" data-column-id="{{ $patients->id }}" data-column-name="findings_pexam" data-array="5" value="1">
                                            <label class="form-check-label mr-3">Mass/Nodules</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control form-control-sm custom-input w-100 update-field1" data-column-id="{{ $patients->id }}"  data-array="1" data-column-name="other_pexam" placeholder="Enter findings here">
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

    <script>
        document.getElementById('parentType').addEventListener('change', function () {
            const parentFields = document.querySelectorAll('.parent-fields');
            const guardianField = document.querySelector('.guardian-field');

            if (this.value === 'father&mother') {
                parentFields.forEach(el => el.style.display = 'block');
                guardianField.style.display = 'none';
            } 
            else if (this.value === 'guardian') {
                parentFields.forEach(el => el.style.display = 'none');
                guardianField.style.display = 'block';
            } 
            else {
                parentFields.forEach(el => el.style.display = 'none');
                guardianField.style.display = 'none';
            }
        });
    </script>

@endsection


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
                        <img src="{{ asset('assets/img/icons/shape-01.svg') }}" alt="img" class="z-n1 position-absolute end-0 top-0 d-none d-lg-flex">
                        <a href="javascript:void(0);" class="avatar avatar-xxxl patient-avatar me-2 flex-shrink-0">
                            <img src="{{ asset('assets/img/users/user-08.jpg') }}" alt="product" class="rounded">
                        </a>
                        <div>
                            <p class="text-primary mb-1">#PT0025</p>
                            <h5 class="mb-1"><a href="javascript:void(0);" class="fw-bold">{{ $patients->fname }} {{ $patients->lname }}</a></h5>
                            <p class="mb-3">{{ $patients->address }}</p>
                            <div class="d-flex align-items-center flex-wrap">
                                <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-phone me-1 text-dark"></i>Phone : <span class="text-dark ms-1">+1 54546 45648</span></p>
                                <span class="mx-2 text-light">|</span>
                                <p class="mb-0 d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1 text-dark"></i>Last Visited : <span class="text-dark ms-1">30 Apr 2025</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="p-3 text-lg-end">
                        <div class="mb-4">
                            <a href="javascript:void(0);" class="btn btn-outline-white shadow-sm rounded-circle d-inline-flex align-items-center p-2 fs-14 me-2"><i class="ti ti-phone"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-white shadow-sm rounded-circle d-inline-flex align-items-center p-2 fs-14 me-2"><i class="ti ti-message-circle"></i></a>
                            <a href="javascript:void(0);" class="btn btn-outline-white shadow-sm rounded-circle d-inline-flex align-items-center p-2 fs-14"><i class="ti ti-video"></i></a>
                        </div>
                        <a href="new-appointment.html" class="btn btn-primary"><i class="ti ti-calendar-event me-1"></i>Book Apppointment</a>
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
                                <h5 class="fw-bold mb-0"><i class="ti ti-user-star me-1"></i>Personal Information</h5>
                            </div>
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Last Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field" value="{{ ucfirst(strtolower($patients->lname)) }}" data-column-id="{{ $patients->id }}" data-column-name="lname" placeholder="Enter Last Name">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">First Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field" value="{{ ucfirst(strtolower($patients->fname)) }}">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Middle Name<span class="text-danger ms-1">*</span></label>
                                            <input type="text" class="form-control form-control-sm update-field" value="{{ ucfirst(strtolower($patients->mname)) }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Ext. Name<span class="text-danger ms-1">*</span></label>
                                            <select name="ext_name" class="form-control form-control-sm update-field">
                                                <option value=""> --Select-- </option>
                                                <option value="Jr." data-column-id="{{ $patients->id }}" data-column-name="ext_name" @if($patients->ext_name == "Jr.") selected @endif>Jr.</option>
                                                <option value="Sr." data-column-id="{{ $patients->id }}" data-column-name="ext_name" @if($patients->ext_name == "Sr.") selected @endif>Sr.</option>
                                                <option value="III" data-column-id="{{ $patients->id }}" data-column-name="ext_name" @if($patients->ext_name == "III") selected @endif>III</option>
                                                <option value="IV"  data-column-id="{{ $patients->id }}" data-column-name="ext_name" @if($patients->ext_name == "IV") selected @endif>IV</option>
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
                                </div>

                                <div class="row">
                                    <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom mt-4">
                                        <div>
                                            <h6 class="fw-bold mb-0 d-flex align-items-center"><i class="ti ti-home me-1"></i> Home Address</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Address (<span class="text-danger ms-1">Readonly</span>)</label>
                                            <input type="text" name="address" class="form-control form-control-sm update-field" id="viewdatastudAddress" value="{{ $patients->address }}" readonly style="background-color: #ddd !important; border: 1px solid #aaa;">
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
                                                <input type="hidden" id="region_name" name="region">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Province<span class="text-danger ms-1">*</span></label>
                                            <select id="province" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Province</option>
                                            </select>
                                            <input type="hidden" id="province_name" name="province">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">City/Municipality<span class="text-danger ms-1">*</span></label>
                                            <select id="city" class="form-control form-control-sm select2bs4">
                                                <option value="">Select City</option>
                                            </select>
                                            <input type="hidden" id="city_name" name="city">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Barangay<span class="text-danger ms-1">*</span></label>
                                            <select id="barangay" class="form-control form-control-sm select2bs4">
                                                <option value="">Select Barangay</option>
                                            </select>
                                            <input type="hidden" id="brgy_name" name="brgy">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">House No. / Block / Purok<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="hnum" id="viewdatastudHnum" class="form-control form-control-sm" placeholder="House No. / Block / Purok" style="text-transform: uppercase;">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-meduim">Zipcode<span class="text-danger ms-1">*</span></label>
                                            <input type="text" name="zcode" id="zipcode" class="form-control form-control-sm" readonly placeholder="Zip Code" readonly style="background-color: #ddd !important; border: 1px solid #aaa;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom mt-4">
                                        <div>
                                            <h6 class="fw-bold mb-0 d-flex align-items-center"><i class="ti ti-user me-1"></i> Guardian Details</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Address (<span class="text-danger ms-1">Readonly</span>)</label>
                                            <input type="text" name="address" class="form-control form-control-sm update-field" id="viewdatastudAddress" value="{{ $patients->address }}" readonly style="background-color: #ddd !important; border: 1px solid #aaa;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom mt-4">
                                        <div>
                                            <h6 class="fw-bold mb-0 d-flex align-items-center"><i class="ti ti-user me-1"></i> Guardian Details</h6>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 fw-medium">Address (<span class="text-danger ms-1">Readonly</span>)</label>
                                            <input type="text" name="address" class="form-control form-control-sm update-field" id="viewdatastudAddress" value="{{ $patients->address }}" readonly style="background-color: #ddd !important; border: 1px solid #aaa;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="medhistory">
                    Med
                </div>

                <div class="tab-pane" id="physexam">
                    Phys
                </div>
            </div>
        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->


@endsection


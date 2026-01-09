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
                            <h5 class="mb-1"><a href="javascript:void(0);" class="fw-bold">{{ $student->fname }} {{ $student->lname }}</a></h5>
                            <p class="mb-3">{{ $student->address }}</p>
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

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm flex-fill w-100">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0"><i class="ti ti-user-star me-1"></i>More Details</h5>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">Last Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">First Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">Middle Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">Ext. Name<span class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">Date of Birth<span class="text-danger ms-1">*</span></label>
                                    <input type="date" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium">Sex<span class="text-danger ms-1">*</span></label>
                                    <select name="sex" id="sex" class="form-control form-control-sm">
                                        <option value="Male">Male</option> 
                                        <option value="Female">Female</option> 
                                    </select>
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


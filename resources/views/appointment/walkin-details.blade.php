@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Walk-In Consultation</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button id="btn-consult" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#centermodalwalkinconsult">
                    <i class="ti ti-plus me-1"></i> Add New Consultation
                </button>
                <button id="btn-referral" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#centermodalwalkinreferral">
                    <i class="ti ti-plus me-1"></i> Add New Referral
                </button>
                <button id="btn-extraction" type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#centermodalwalkintoothextraction">
                    <i class="ti ti-plus me-1"></i> Add New Tooth Extraction
                </button>
                {{-- <a href="javascript:void(0);" class="btn btn-outline-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_consult_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a> --}}
                {{-- <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a> --}}
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">
            <!-- tab start -->
            <ul class="nav nav-tabs nav-bordered mb-3">
                <li class="nav-item">
                    <a href="#consult" data-bs-toggle="tab" aria-expanded="false" class="nav-link active bg-transparent">
                        <span>Consultation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#referral" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                        <span>Referral</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#toothextraction" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                        <span>Tooth Extraction</span>
                    </a>
                </li>
            </ul>
            <!-- tab end -->

            <div class="tab-content">
                <div class="tab-pane show active" id="consult">
                    <div class="table-responsive">
                        <table id="consultationTable" class="table table-hover" style="width: 100%">
                            <thead class="">
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Chief Complaint</th>
                                    <th>Treatment</th>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10pt;">
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="patient-details.html" class="avatar avatar-md me-2">
                                                <img src="{{ asset('assets/img/user.png') }}" alt="product" class="rounded-circle">
                                            </a>
                                            <a href="patient-details.html" class="text-dark fw-semibold">Alberto Ripley <span class="text-body fs-13 fw-normal d-block"> 26, Male </span>  </a>
                                        </div>
                                    </td>
                                    <td>+1 41245 54132</td>                                
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="doctor-details.html" class="avatar me-2 flex-shrink-0">
                                                <img src="{{ asset('assets/img/doctors/doctor-01.jpg') }}" alt="img" class="rounded-circle">
                                            </a>
                                            <div>
                                            <h6 class="fs-14 mb-1"><a href="doctor-details.html" class="fw-semibold">Dr. Mick Thompson</a></h6>
                                            <p class="mb-0 fs-13">Cardiologist</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Miami, Florida</td>
                                    <td>30 Apr 2025</td>
                                    <td><span class="badge badge-soft-success rounded text-success border border-success fs-13 fw-medium">Available</span></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="appointments.html" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1">
                                                <i class="ti ti-calendar-cog"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="shadow-sm fs-14 d-inline-flex border rounded-2 p-1 me-1" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu p-2">
                                                <li>
                                                    <a href="edit-patient.html" class="dropdown-item d-flex align-items-center">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="patient-details.html" class="dropdown-item d-flex align-items-center">View</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete_modal">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="referral">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width: 100%">
                            <thead class="">
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Referred from</th>
                                    <th>Referred to</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10pt;">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="toothextraction">
                    <div class="table-responsive">
                        <table id="toothextractlisttab" class="table table-striped" style="width: 100%">
                            <thead class="">
                                <tr>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 10pt;">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
        <!-- row end -->
                        
    </div>
    <!-- End Content -->

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalwalkinconsult" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Consultation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adPVisit" method="POST">
                        @csrf

                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>
                        <input type="hidden" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                        <input type="hidden" name="time" class="form-control form-control-sm" value="{{ date('h:i A') }}"  readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="AP234354">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="choices-multiple-remove-button" class="form-label mb-1 text-dark fs-14 fw-medium">Chief Complaint <span class="text-danger">*</span></label>
                                    <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="chief_complaint[]" multiple>
                                        @foreach ($complaints as $complaint)
                                            <option style="color:black" value="{{ $complaint->id }}">
                                                {{ $complaint->complaint }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation Treatment</label>
                                        <textarea rows="4" name="treatment" class="form-control rounded"> </textarea>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium text-center">Certificate</label>
                                    <div>
                                        <input type="radio" class="form-check-input" name="certificate" id="certificate" value="1">
                                        <label class="form-check-label mr-3" for="certificate">Yes</label>&emsp;
                                        <input type="radio" class="form-check-input" name="certificate" id="noCertificate" value="0">
                                        <label class="form-check-label" for="noCertificate">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Medicine</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Quantity</label>
                                        </div>
                                    </div>

                                    <div id="dynamic-fields" class="mb-3">
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-7">
                                                <select name="medicine[]" class="form-select form-control-sm">
                                                    <option value="">Select Medicine</option>
                                                    @foreach ($medicines as $medicine)
                                                        <option value="{{ $medicine->id }}" >
                                                            {{ $medicine->medicine }} - ({{ $medicine->qty }} left )
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" placeholder="Quantity" name="qty[]" class="form-control form-control-sm" min="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <button type="button" class="btn btn-outline-success btn-sm add-button">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                        <button type="button" id="myremove" class="btn btn-danger btn-sm remove-button">
                                            <i class="fas fa-minus"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
                            <div class=" d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-danger btn-md" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-md">
                                    <i class="fas fa-save"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>

                    <template id="medicine-row-template">
                        <div class="row mb-3 align-items-end">
                            <div class="col-md-7">
                                <select name="medicine[]" class="form-select form-control form-control-sm">
                                    <option value="">Select Medicine</option>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">
                                            {{ $medicine->medicine }} - ({{ $medicine->qty }} left )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="number" placeholder="Quantity" name="qty[]" class="form-control form-control-sm" min="1">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalwalkinreferral" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Referral</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adPReferral" method="POST">
                        @csrf

                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>
                        <input type="hidden" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                        <input type="hidden" name="time" class="form-control form-control-sm" value="{{ date('h:i A') }}"  readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="AP234354">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reffered From</label><br>
                                    <select name="preferfrom" id="" class="form-control">
                                        <option disabled selected> --Select-- </option>
                                        <option value="Medical Doctor">Medical Doctor</option>
                                        <option value="School Nurse">School Nurse</option>
                                        <option value="Dentist">Dentist</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reffered To</label><br>
                                    <select name="preferto" id="" class="form-control">
                                        <option disabled selected> --Select-- </option>
                                        <option value="Medical Doctor">Medical Doctor</option>
                                        <option value="CHO">CHO</option>
                                        <option value="Dentist">Dentist</option>
                                        <option value="Radiologist">Radiologist</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reason for Referral</label><br>
                                    <textarea name="reasonrefer" id="" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Tentative Diagnosis</label><br>
                                    <textarea name="tentdiagnose" id="" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Treatment/Medication Given</label><br>
                                    <textarea name="treatmentmedgiven" id="" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
                            <div class=" d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-danger btn-md" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-md">
                                    <i class="fas fa-save"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalwalkintoothextraction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Tooth Extraction</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adPToothextract" method="POST">
                        @csrf

                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>
                        <input type="hidden" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                        <input type="hidden" name="time" class="form-control form-control-sm" value="{{ date('h:i A') }}"  readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="AP234354">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reffered From</label><br>
                                    <select name="preferfrom" id="" class="form-control">
                                        <option disabled selected> --Select-- </option>
                                        <option value="Medical Doctor">Medical Doctor</option>
                                        <option value="School Nurse">School Nurse</option>
                                        <option value="Dentist">Dentist</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reffered To</label><br>
                                    <select name="preferto" id="" class="form-control">
                                        <option disabled selected> --Select-- </option>
                                        <option value="Medical Doctor">Medical Doctor</option>
                                        <option value="CHO">CHO</option>
                                        <option value="Dentist">Dentist</option>
                                        <option value="Radiologist">Radiologist</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reason for Referral</label><br>
                                    <textarea name="reasonrefer" id="" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Tentative Diagnosis</label><br>
                                    <textarea name="tentdiagnose" id="" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Treatment/Medication Given</label><br>
                                    <textarea name="treatmentmedgiven" id="" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
                            <div class=" d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-danger btn-md" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary btn-md">
                                    <i class="fas fa-save"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection




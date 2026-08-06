@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <div class="row">
                    <div class="col-md-10">
                        <h1 class="fs-3">Walkin Consultations</h1>
                    </div>
                    <!-- Removed buttons from here -->
                </div>
                <hr>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <ul class="nav nav-pills bg-light p-2 rounded-2" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-one-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-one" type="button" role="tab"
                                    aria-controls="pills-one" aria-selected="true"> <i class="ti ti-user-bolt"></i>
                                    Consultation
                                </button>
                            </li>
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-two-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-two" type="button" role="tab"
                                    aria-controls="pills-two" aria-selected="false" tabindex="-1"> <i class="ti ti-user-code"></i>
                                    Referral
                                </button>
                            </li>
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-three-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-three" type="button" role="tab"
                                    aria-controls="pills-three" aria-selected="false" tabindex="-1"> <i class="ti ti-users"></i>
                                    Tooth Extraction
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content mt-1" id="pills-tabContent">
                                    <!-- Consultation Tab -->
                                    <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            <button id="btn-consult" type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodalwalkinconsult">
                                                <i class="ti ti-plus"></i> Add New Consultation
                                            </button>
                                        </div>
                                        <div class="table-responsive mt-2 p-3">
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
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 10pt;">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <!-- Referral Tab -->
                                    <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            <button id="btn-referral" type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodalwalkinreferral">
                                                <i class="ti ti-plus"></i> Add New Referral
                                            </button>
                                        </div>
                                        <div class="table-responsive mt-2 p-3">
                                            <table id="referlisttab" class="table table-striped" style="width: 100%">
                                                <thead class="">
                                                    <tr>
                                                        <th>Patient</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Referred from</th>
                                                        <th>Referred to</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 10pt;">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <!-- Tooth Extraction Tab -->
                                    <div class="tab-pane fade" id="pills-three" role="tabpanel" aria-labelledby="pills-three-tab" tabindex="0">
                                        <div class="d-flex justify-content-end align-items-center mb-3">
                                            <button id="btn-extraction" type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodalwalkintoothextraction">
                                                <i class="ti ti-plus"></i> Add New Tooth Extraction
                                            </button>
                                        </div>
                                        <div class="table-responsive mt-2 p-3">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalwalkinconsult" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Add New Consultation</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adPVisit" method="POST">
                        @csrf

                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="consultID" class="form-control rounded bg-light" value="STUD-CWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}" readonly>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="time" class="form-control form-control-sm" value="{{ date('h:i A') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="choices-multiple-remove-button" class="form-label mb-1 text-dark fs-14 fw-medium">Chief Complaint <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="choices-multiple-remove-button" name="chief_complaint[]" multiple="multiple">
                                        @foreach ($complaints as $complaint)
                                            <option style="color:black" value="{{ $complaint->id }}">
                                                {{ $complaint->complaintname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">BP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="bp" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">PR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pr" placeholder="e.g. 72 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">RR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="rr" placeholder="e.g. 16 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">SPO2<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="spo" placeholder="e.g. 98%">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">T<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="btemp" placeholder="e.g. 37°C">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">LMP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="lmp" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Height<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pheight" placeholder="e.g. 170 cm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Weight<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pweight" placeholder="e.g. 70 kg">
                                    </div>
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
                                                <select name="medicine[]" class="form-control form-control-sm">
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
                                <button type="submit" class="btn btn-success btn-md">
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
                    <h6 class="modal-title" id="myCenterModalLabel">Add New Referral</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adPReferral" method="POST">
                        @csrf

                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Referral ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="referralID" class="form-control rounded bg-light" value="STUD-RWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
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

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="time" class="form-control form-control-sm" value="{{ date('h:i A') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">BP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="bp" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">PR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pr" placeholder="e.g. 72 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">RR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="rr" placeholder="e.g. 16 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">SPO2<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="spo" placeholder="e.g. 98%">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">T<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="btemp" placeholder="e.g. 37°C">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">LMP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="lmp" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Height<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pheight" placeholder="e.g. 170 cm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Weight<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pweight" placeholder="e.g. 70 kg">
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
                                <button type="submit" class="btn btn-success btn-md">
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
                    <h6 class="modal-title" id="myCenterModalLabel">Add New Tooth Extraction</h6>
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

    <!-- Edit Center modal content -->
    <div class="modal fade" id="editcentermodalwalkinconsult" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Edit Consultation</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPVisit" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="editWalkinConsultId" class="form-control rounded bg-light" readonly>
                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="consultID" class="form-control rounded bg-light" value="STUD-CWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}" readonly>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="date" id="editWalkinConsultDate" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="time" id="editWalkinConsultTime" class="form-control form-control-sm" value="{{ date('h:i A') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="editWalkinConsultChiefComplaint" class="form-label mb-1 text-dark fs-14 fw-medium">Chief Complaint <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="editWalkinConsultChiefComplaint" name="chief_complaint[]" multiple="multiple">
                                        @foreach ($complaints as $complaint)
                                            <option style="color:black" value="{{ $complaint->id }}">
                                                {{ $complaint->complaintname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">BP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="bp" id="editWalkinConsultBP" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">PR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pr" id="editWalkinConsultPR" placeholder="e.g. 72 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">RR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="rr" id="editWalkinConsultRR" placeholder="e.g. 16 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">SPO2<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="spo" id="editWalkinConsultSPO2" placeholder="e.g. 98%">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">T<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="btemp" id="editWalkinConsultBTemp" placeholder="e.g. 37°C">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">LMP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="lmp" id="editWalkinConsultLMP" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Height<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pheight" id="editWalkinConsultPHeight" placeholder="e.g. 170 cm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Weight<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pweight" id="editWalkinConsultPWeight" placeholder="e.g. 70 kg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div>
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Consultation Treatment</label>
                                        <textarea rows="4" name="treatment" id="editWalkinConsultTreatment" class="form-control rounded"> </textarea>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label mb-1 fw-medium text-center">Certificate</label>
                                    <div>
                                        <input type="radio" class="form-check-input" id="editWalkinConsultCertificate1" name="certificate" value="1">
                                        <label class="form-check-label mr-3" for="editWalkinConsultCertificate1">Yes</label>&emsp;
                                        <input type="radio" class="form-check-input" id="editWalkinConsultCertificate2" name="certificate" value="0">
                                        <label class="form-check-label" for="editWalkinConsultCertificate2">No</label>
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

                                    <div id="dynamic-fieldsedit" class="mb-3"></div>

                                    <div class="mt-2">
                                        <button type="button" class="btn btn-outline-success btn-sm" id="editAddMedicine">
                                            <i class="fas fa-plus"></i> Add
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm" id="editRemoveMedicine">
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
                                <button type="submit" class="btn btn-success btn-md">
                                    <i class="fas fa-save"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>

                    <template id="medicine-row-templateedit">
                        <div class="row mb-3 align-items-end">
                            <div class="col-md-7">
                                <select name="medicine[]" class="form-control form-control-sm editMedicine">
                                    <option value="">Select Medicine</option>
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">
                                            {{ $medicine->medicine }} - ({{ $medicine->qty }} left)
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

    <!-- Edit Center modal content -->
    <div class="modal fade" id="editcentermodalwalkinreferral" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Edit Referral</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPReferral" method="POST">
                        @csrf

                        <input type="hidden" name="id" id="editWalkinReferralId" class="form-control rounded bg-light" readonly>
                        <input type="hidden" name="stid" class="form-control rounded bg-light" value="{{ $patients->id }}" readonly>
                        <input type="hidden" name="stdntID" class="form-control rounded bg-light" value="{{ $patients->stud_id }}" readonly>

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Referral ID <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="referralID" class="form-control rounded bg-light" value="STUD-RWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
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

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="date" name="date" id="editWalkinReferralDate" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Time<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="time" name="time" id="editWalkinReferralTime" class="form-control form-control-sm" value="{{ date('h:i A') }}">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">BP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="bp" id="editWalkinReferralBP" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">PR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pr" id="editWalkinReferralPR" placeholder="e.g. 72 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">RR<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="rr" id="editWalkinReferralRR" placeholder="e.g. 16 bpm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">SPO2<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="spo" id="editWalkinReferralSPO2" placeholder="e.g. 98%">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">T<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="btemp" id="editWalkinReferralBodyTemp" placeholder="e.g. 37°C">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">LMP<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="lmp" id="editWalkinReferralLMP" placeholder="e.g. 120/80 mmHg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Height<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pheight" id="editWalkinReferralHeight" placeholder="e.g. 170 cm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Weight<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control rounded" name="pweight" id="editWalkinReferralWeight" placeholder="e.g. 70 kg">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reffered From</label><br>
                                    <select name="preferfrom" id="editWalkinReferralFrom" class="form-control">
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
                                    <select name="preferto" id="editWalkinReferralTo" class="form-control">
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
                                    <textarea name="reasonrefer" id="editWalkinReferralReason" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Tentative Diagnosis</label><br>
                                    <textarea name="tentdiagnose" id="editWalkinReferralTentativeDiagnosis" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Treatment/Medication Given</label><br>
                                    <textarea name="treatmentmedgiven" id="editWalkinReferralTreatment" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                        <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
                            <div class=" d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-outline-danger btn-md" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success btn-md">
                                    <i class="fas fa-save"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var walkinconsultUpdateRoute = "{{ route('appointment.walkinconsult.update', ['id' => ':id']) }}";
        var walkinconsultDeleteRoute = "{{ route('appointment.walkinconsult.delete', ['id' => ':id']) }}";

        var walkinreferralUpdateRoute = "{{ route('appointment.walkinreferral.update', ['id' => ':id']) }}";
        var walkinreferralDeleteRoute = "{{ route('appointment.walkinreferral.delete', ['id' => ':id']) }}";
    </script>
@endsection

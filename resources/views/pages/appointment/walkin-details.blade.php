@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <div>
                        <h1 class="h4 fw-bold mb-1" style="letter-spacing: -0.02em;">Consultations</h1>
                        <p class="text-muted small mb-0">Manage Patient consulations</p>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="btn btn-light">
                            <i class="ti ti-circle-filled text-success"></i> Selected:
                            {{ $student->fname}} {{ $student->lname}}
                        </div>
                    </div>
                </div>
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
                            &nbsp;
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-four-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-four" type="button" role="tab"
                                    aria-controls="pills-four" aria-selected="false" tabindex="-1"> <i class="ti ti-stethoscope"></i>
                                    Accidents & Injuries
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content mt-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-one" role="tabpanel" aria-labelledby="pills-one-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card card-animate">
                                        <div class="card-header pt-3">
                                            <h6 class="card-title">
                                                <i class="ti ti-plus"></i> Add Consulation Section
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="adPVisit" method="POST">
                                                @csrf

                                                <!-- Hidden Inputs -->
                                                <input type="hidden" name="stid" value="{{ $patients->id }}">
                                                <input type="hidden" name="stdntID" value="{{ $patients->stud_id }}">
                                                <input type="hidden" name="pcat" value="1">

                                                <!-- 1. GENERAL INFORMATION -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-2">Visit Information</small>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Consultation ID <span class="text-danger">*</span></label>
                                                        <input type="text" name="consultID" class="form-control form-control-sm bg-light" value="STUD-CWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Patient Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="pname" class="form-control form-control-sm bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}" readonly>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Classification <span class="text-danger">*</span></label>
                                                        <select class="form-control form-select-sm" name="typeofconsultation">
                                                            <option value="">-- Select --</option>
                                                            <option value="1">New Cases</option>
                                                            <option value="2">Follow-up Cases</option>
                                                            <option value="3">Emergency Cases</option>
                                                            <option value="4">Teleconsultation</option>
                                                            <option value="5">Walk-in Consultation</option>
                                                        </select>
                                                    </div>

                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Date <span class="text-danger">*</span></label>
                                                            <input type="date" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Time <span class="text-danger">*</span></label>
                                                            <input type="time" name="time" class="form-control form-control-sm" value="{{ date('H:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 2. VITAL SIGNS -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-3">Vital Signs</small>

                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">BP <span class="text-muted fw-normal">(mmHg)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="bp" placeholder="120/80">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">PR <span class="text-muted fw-normal">(bpm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pr" placeholder="72">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">RR <span class="text-muted fw-normal">(bpm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="rr" placeholder="16">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">SPO2 <span class="text-muted fw-normal">(%)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="spo" placeholder="98">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Temp <span class="text-muted fw-normal">(°C)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="btemp" placeholder="37">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">LMP <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="lmp" placeholder="Date/Notes">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Height <span class="text-muted fw-normal">(cm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pheight" placeholder="170">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Weight <span class="text-muted fw-normal">(kg)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pweight" placeholder="70">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 3. CLINICAL ASSESSMENT -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-2">Assessment & Service</small>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Chief Complaint <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm select2bs4" name="chief_complaint[]" multiple="multiple">
                                                            @foreach ($complaints as $complaint)
                                                                <option value="{{ $complaint->id }}">{{ $complaint->complaintname }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Medical Service Rendered <span class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm select2bs4" name="medservrendered[]" multiple="multiple">
                                                            @foreach ($medserverender as $servrender)
                                                                <option value="{{ $servrender->id }}">{{ $servrender->medservrender }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Consultation Treatment <span class="text-danger">*</span></label>
                                                        <textarea rows="3" name="treatment" class="form-control form-control-sm" placeholder="Enter treatment notes..."></textarea>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                                        <label class="form-label mb-0 text-dark fs-13 fw-medium">Issue Medical Certificate? <span class="text-danger">*</span></label>
                                                        <div>
                                                            <div class="form-check form-check-inline mb-0">
                                                                <input type="radio" class="form-check-input" name="certificate" id="certYes" value="1">
                                                                <label class="form-check-label fs-13" for="certYes">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-0 me-0">
                                                                <input type="radio" class="form-check-input" name="certificate" id="certNo" value="0">
                                                                <label class="form-check-label fs-13" for="certNo">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 4. MEDICINE DISPENSING -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-2">Prescription / Dispensing</small>

                                                    <div id="dynamic-fields">
                                                        <div class="row g-2 mb-2 align-items-center medicine-row">
                                                            <div class="col-8">
                                                                <select name="medicine[]" class="form-control form-control-sm select2bs4">
                                                                    <option value="">-- Choose Medicine --</option>
                                                                    @foreach ($medicines as $medicine)
                                                                        <option value="{{ $medicine->id }}">
                                                                            {{ $medicine->name }} - {{ $medicine->generic_name }} (Stock: {{ $medicine->quantity_remaining }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="number" placeholder="Qty" name="qty[]" class="form-control form-control-sm" min="1">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-2 mt-2">
                                                        <button type="button" class="btn btn-outline-success btn-sm w-50 add-button">
                                                            <i class="fas fa-plus me-1"></i> Add Item
                                                        </button>
                                                        <button type="button" id="myremove" class="btn btn-outline-danger btn-sm w-50 remove-button">
                                                            <i class="fas fa-minus me-1"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- SUBMIT BUTTONS -->
                                                <div class="d-flex gap-2 pt-2 border-top">
                                                    <button type="button" class="btn btn-light btn-sm w-50" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-sm w-50">
                                                        <i class="fas fa-save me-1"></i> Save Data
                                                    </button>
                                                </div>
                                            </form>

                                            <template id="medicine-row-template">
                                                <div class="row g-2 mb-2 align-items-center medicine-row">
                                                    <div class="col-8">
                                                        <select name="medicine[]" class="form-control form-control-sm select2bs4">
                                                            <option value="">-- Choose Medicine --</option>
                                                            @foreach ($medicines as $medicine)
                                                                <option value="{{ $medicine->id }}">
                                                                    {{ $medicine->code }} - {{ $medicine->name }} (Stock: {{ $medicine->quantity_remaining }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="number" placeholder="Qty" name="qty[]" class="form-control form-control-sm" min="1">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-animate">
                                        <div class="card-header pt-3">
                                            <h6 class="card-title">
                                                <i class="ti ti-server"></i> Consulation Section
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive p-3">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Referral Tab -->
                        <div class="tab-pane fade" id="pills-two" role="tabpanel" aria-labelledby="pills-two-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card card-animate">
                                        <div class="card-header pt-3">
                                            <h6 class="card-title">
                                                <i class="ti ti-plus"></i> Add Referral Section
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="adPReferral" method="POST">
                                                @csrf

                                                <!-- Hidden Inputs -->
                                                <input type="hidden" name="stid" value="{{ $patients->id }}">
                                                <input type="hidden" name="stdntID" value="{{ $patients->stud_id }}">

                                                <!-- 1. REFERRAL DETAILS -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-3">Referral Details</small>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Referral ID <span class="text-danger">*</span></label>
                                                        <input type="text" name="referralID" class="form-control form-control-sm bg-light" value="STUD-RWI-{{ \Carbon\Carbon::now()->format('Ymd') }}-{{ substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10) }}" readonly>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Patient Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm bg-light" value="{{ ucwords(strtolower($patients->fname)) }} {{ ucwords(strtolower($patients->mname)) }} {{ ucwords(strtolower($patients->lname)) }} {{ $patients->ext }}" readonly>
                                                    </div>

                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Date <span class="text-danger">*</span></label>
                                                            <input type="date" name="date" class="form-control form-control-sm" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Time <span class="text-danger">*</span></label>
                                                            <input type="time" name="time" class="form-control form-control-sm" value="{{ date('H:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 2. VITAL SIGNS -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-3">Vital Signs</small>

                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">BP <span class="text-muted fw-normal">(mmHg)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="bp" placeholder="120/80">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">PR <span class="text-muted fw-normal">(bpm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pr" placeholder="72">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">RR <span class="text-muted fw-normal">(bpm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="rr" placeholder="16">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">SPO2 <span class="text-muted fw-normal">(%)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="spo" placeholder="98">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Temp <span class="text-muted fw-normal">(°C)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="btemp" placeholder="37">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">LMP <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="lmp" placeholder="Date/Notes">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Height <span class="text-muted fw-normal">(cm)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pheight" placeholder="170">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Weight <span class="text-muted fw-normal">(kg)</span> <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-sm" name="pweight" placeholder="70">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- 3. MEDICAL EVALUATION & ROUTING -->
                                                <div class="border rounded p-3 mb-3 bg-light-subtle">
                                                    <small class="fw-bold text-uppercase text-secondary d-block mb-3">Referral Routing & Assessment</small>

                                                    <div class="row g-2 mb-2">
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Referred From</label>
                                                            <select name="preferfrom" class="form-select form-select-sm">
                                                                <option value="" disabled selected>-- Select --</option>
                                                                <option value="Medical Doctor">Medical Doctor</option>
                                                                <option value="School Nurse">School Nurse</option>
                                                                <option value="Dentist">Dentist</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label mb-1 text-dark fs-13 fw-medium">Referred To</label>
                                                            <select name="preferto" class="form-select form-select-sm">
                                                                <option value="" disabled selected>-- Select --</option>
                                                                <option value="Medical Doctor">Medical Doctor</option>
                                                                <option value="CHO">CHO</option>
                                                                <option value="Dentist">Dentist</option>
                                                                <option value="Radiologist">Radiologist</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Reason for Referral</label>
                                                        <textarea name="reasonrefer" rows="2" class="form-control form-control-sm" placeholder="State reason for referral..."></textarea>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Tentative Diagnosis</label>
                                                        <textarea name="tentdiagnose" rows="2" class="form-control form-control-sm" placeholder="Enter tentative diagnosis..."></textarea>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label mb-1 text-dark fs-13 fw-medium">Treatment / Medication Given</label>
                                                        <textarea name="treatmentmedgiven" rows="2" class="form-control form-control-sm" placeholder="List initial treatments or drugs given..."></textarea>
                                                    </div>
                                                </div>

                                                <!-- SUBMIT BUTTONS -->
                                                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                                    <button type="button" class="btn btn-outline-danger btn-sm w-50" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-sm w-50">
                                                        <i class="fas fa-save me-1"></i> Save Data
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-animate">
                                        <div class="card-header pt-3">
                                            <h6 class="card-title">
                                                <i class="ti ti-server"></i> Referral Section
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive p-3">
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
                            <div class=" d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
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
                                            {{ $medicine->code }} - {{ $medicine->name }} (In Stock: {{ $medicine->quantity_remaining }} | Exp: {{ $medicine->nearest_expiry }})
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

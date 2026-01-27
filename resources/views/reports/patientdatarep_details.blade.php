@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Patient Data Report</h4>
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="referral">
                    <div class="table-responsive">
                        <table id="referlisttab" class="table table-striped" style="width: 100%">
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
@endsection




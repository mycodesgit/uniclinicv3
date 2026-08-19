@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Chief Complaints</h1>
                <hr>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-2 d-flex justify-content-between align-items-center">
                                <h6 class="card-title">
                                    <i class="ti ti-details"></i> List of Chief Complaints
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#centercomplaintAddModal">
                                    <i class="fas fa-plus me-1"></i> Add New Chief Complaint
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-2 p-2">
                                    <table id="chiefcomplaintlistab" class="table table-hover" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>Category</th>
                                                <th>Complaint</th>
                                                <th>Sepcific</th>
                                                <th class="text-center" width="7%">Action</th>
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

    <!-- Center modal content -->
    <div class="modal fade" id="centercomplaintAddModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Chief Complaint</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="chiefComplaintForm" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Category & Chief Complaint Name -->
                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Category <span class="text-danger">*</span></label>
                                <select name="categoryname" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Cardiovascular System">Cardiovascular System</option>
                                    <option value="Dermatologic (Skin)">Dermatologic (Skin)</option>
                                    <option value="Eye (Ophthalmologic)">Eye (Ophthalmologic)</option>
                                    <option value="Endocrine/Metabolic System">Endocrine/Metabolic System</option>
                                    <option value="Ear, Nose and Throat (ENT)">Ear, Nose and Throat (ENT)</option>
                                    <option value="Gastrointestinal System">Gastrointestinal System</option>
                                    <option value="Mental and Behavioral Health">Mental and Behavioral Health</option>
                                    <option value="Musculoskeletal System">Musculoskeletal System</option>
                                    <option value="Neurologic System">Neurologic System</option>
                                    <option value="Respiratory System">Respiratory System</option>
                                    <option value="Reproductive System (Female)">Reproductive System (Female)</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Chief Complaint <span class="text-danger">*</span></label>
                                <input type="text" name="complaintname" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Specific condition: </label>
                                <input type="text" name="specificcondition" class="form-control text-uppercase" autocomplete="off">
                            </div>
                        </div>

                        <!-- Form Footer Actions -->
                        <div class="offcanvas-footer mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="fas fa-save me-1"></i> Save Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Center modal content -->
    <div class="modal fade" id="editChiefComplaintModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Chief Complaint</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editChiefComplaintForm" method="POST">
                        @csrf

                        <!-- Hidden ID Field -->
                        <input type="hidden" name="id" id="editChiefComplaintId">

                        <div class="row g-3">
                            <!-- Category & Medicine Name -->
                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium" for="editCategoryname">Category: <span class="text-danger">*</span></label>
                                <select name="categoryname" class="form-control" required id="editCategoryname">
                                    <option value="">Select Category</option>
                                    <option value="Cardiovascular System">Cardiovascular System</option>
                                    <option value="Dermatologic (Skin)">Dermatologic (Skin)</option>
                                    <option value="Eye (Ophthalmologic)">Eye (Ophthalmologic)</option>
                                    <option value="Endocrine/Metabolic System">Endocrine/Metabolic System</option>
                                    <option value="Ear, Nose and Throat (ENT)">Ear, Nose and Throat (ENT)</option>
                                    <option value="Gastrointestinal System">Gastrointestinal System</option>
                                    <option value="Mental and Behavioral Health">Mental and Behavioral Health</option>
                                    <option value="Musculoskeletal System">Musculoskeletal System</option>
                                    <option value="Neurologic System">Neurologic System</option>
                                    <option value="Respiratory System">Respiratory System</option>
                                    <option value="Reproductive System (Female)">Reproductive System (Female)</option>
                                </select>
                            </div> 

                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium" for="editComplaint">Compliant: <span class="text-danger">*</span></label>
                                <input type="text" name="complaintname" class="form-control" id="editComplaint" required>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium" for="editSpecific">Sepcific: </label>
                                <input type="text" name="specificcondition" class="form-control" id="editSpecific" required>
                            </div>
                        </div>

                        <!-- Form Footer Actions -->
                        <div class="offcanvas-footer mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="fas fa-save me-1"></i> Update Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

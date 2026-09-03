@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Medicines</h1>
                <hr>
                {{-- <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fs-3 mb-0">Medicines</h1>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#centermodalmedadd">
                        + Add New Medicine
                    </button>
                </div>
                <hr> --}}
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-2 d-flex justify-content-between align-items-center">
                                <h6 class="card-title">
                                    <i class="fas fa-pills"></i> List of Medicines
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodalmedadd">
                                    <i class="fas fa-plus me-1"></i> Add New Medicine
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-2 p-2">
                                    <table id="medlistab" class="table table-hover" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>Category</th>
                                                <th>Medicine</th>
                                                <th>Qty Stock</th>
                                                <th>Qty Despense</th>
                                                <th>Total</th>
                                                <th>Unit Measure</th>
                                                <th>Lot No.</th>
                                                <th>Expiry Date</th>
                                                <th>Reference ID</th>
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
    <div class="modal fade" id="centermodalmedadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Medicine</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="medicineForm" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Category & Medicine Name -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" class="form-control form-control-sm text-capitalize" autocomplete="off" placeholder="e.g., Antibiotics, Analgesics" required>
                            </div> 

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Medicine Name <span class="text-danger">*</span></label>
                                <input type="text" name="medicine" class="form-control form-control-sm text-capitalize" autocomplete="off" placeholder="e.g., Amoxicillin, Paracetamol" required>
                            </div> 

                            <!-- Quantity & Unit Measure -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="qty" class="form-control form-control-sm" min="1" autocomplete="off" placeholder="e.g., 100" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Unit Measure <span class="text-danger">*</span></label>
                                <input type="text" name="measure" class="form-control form-control-sm" autocomplete="off" placeholder="e.g., mg, ml, Tablets, Boxes" required>
                            </div>

                            <!-- Lot No., Expiry Date, Reference ID -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Lot No. <span class="text-danger">*</span></label>
                                <input type="text" name="lotno" class="form-control form-control-sm text-uppercase" autocomplete="off" placeholder="e.g., LOT-12345" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="expirydate" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Reference ID <span class="text-danger">*</span></label>
                                <input type="text" name="refnoid" class="form-control form-control-sm text-uppercase" autocomplete="off" placeholder="e.g., REF-2024-001" required>
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
    <div class="modal fade" id="editMedicineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Medicine</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMedicineForm" method="POST">
                        @csrf

                        <!-- Hidden ID Field -->
                        <input type="hidden" name="id" id="editMedicineId">

                        <div class="row g-3">
                            <!-- Category & Medicine Name -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" id="editMedicineCategory" class="form-control form-control-sm text-capitalize" autocomplete="off" placeholder="e.g., Antibiotics, Analgesics" required>
                            </div> 

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Medicine Name <span class="text-danger">*</span></label>
                                <input type="text" name="medicine" id="editMedicineName" class="form-control form-control-sm text-capitalize" autocomplete="off" placeholder="e.g., Amoxicillin, Paracetamol" required>
                            </div>

                            <!-- Quantity & Unit Measure -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="qty" id="editMedicineQty" class="form-control form-control-sm" min="0" autocomplete="off" placeholder="Enter Quantity" required>
                            </div> 

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Unit Measure <span class="text-danger">*</span></label>
                                <input type="text" name="measure" id="editMedicineUnit" class="form-control form-control-sm" autocomplete="off" placeholder="e.g., mg, ml, Tablets" required>
                            </div>

                            <!-- Lot No., Expiry Date, Reference ID -->
                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Lot No. <span class="text-danger">*</span></label>
                                <input type="text" name="lotno" id="editMedicineLotNo" class="form-control form-control-sm text-uppercase" autocomplete="off" placeholder="Lot No." required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Expiry Date <span class="text-danger">*</span></label>
                                <input type="date" name="expirydate" id="editMedicineExpiry" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Reference ID <span class="text-danger">*</span></label>
                                <input type="text" name="refnoid" id="editMedicineReference" class="form-control form-control-sm text-uppercase" autocomplete="off" placeholder="Reference ID" required>
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

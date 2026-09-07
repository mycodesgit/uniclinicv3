@extends('layouts.app')

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Medicines Management</h1>
                <hr>
                <div class="row g-4 mb-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header pt-2 d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-pills me-1"></i> Medicine Catalog & Batches
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodalmedadd">
                                    <i class="fas fa-plus me-1"></i> Add New Medicine
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-2 p-2">
                                    <table id="medlistab" class="table table-hover align-middle" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Brand Name</th>
                                                <th>Generic Name</th>
                                                <th>Dosage</th>
                                                <th>Unit</th>
                                                <th>Batch / Lot No.</th>
                                                <th>Qty Remaining</th>
                                                <th>Expiry Date</th>
                                                <th>Ref No. ID</th>
                                                <th class="text-center" width="7%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 10pt;">
                                            {{-- Populated via DataTables / AJAX --}}
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

    <!-- Modal 1: Create New Medicine Catalog Item -->
    <div class="modal fade" id="centermodalmedadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pills me-1"></i> Add New Medicine Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="medicineForm" method="POST">
                        @csrf
                        <h6 class="fw-bold text-primary mb-3">1. Medicine Details</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Item Code / Category</label>
                                <input type="text" name="code" class="form-control form-control-sm text-uppercase" placeholder="e.g., ANTI-VERTIGO">
                            </div> 

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Brand/Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-sm text-capitalize" placeholder="Betahistine Hydrochloride" required>
                            </div> 

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Generic Name</label>
                                <input type="text" name="generic_name" class="form-control form-control-sm text-capitalize" placeholder="(Betzine)">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Dosage</label>
                                <input type="text" name="dosage" class="form-control form-control-sm" placeholder="e.g., 24mg">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Unit Measure <span class="text-danger">*</span></label>
                                <input type="text" name="unit" class="form-control form-control-sm" placeholder="pcs" value="pcs" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Reorder Alert Level</label>
                                <input type="number" name="reorder_level" class="form-control form-control-sm" value="10" min="0">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label mb-1 fs-14 fw-medium">Description</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="Optional: Add a brief description or notes about the medicine..."></textarea>
                            </div>
                        </div>

                        <div class="mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="fas fa-save me-1"></i> Save Medicine
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Stock In / Add New Batch -->
    <div class="modal fade" id="addBatchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-boxes me-1"></i> Add Stock Batch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBatchForm" method="POST">
                        @csrf
                        <input type="hidden" name="medicine_id" id="batchMedicineId">

                        <div class="mb-3">
                            <label class="form-label fw-bold mb-0" id="batchMedicineLabel">Medicine Name</label>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Batch / Lot No. <span class="text-danger">*</span></label>
                                <input type="text" name="lotbatch_number" class="form-control form-control-sm text-uppercase" placeholder="e.g., BATCH-2026-01" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity_received" class="form-control form-control-sm" min="1" placeholder="e.g., 100" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Expiration Date <span class="text-danger">*</span></label>
                                <input type="date" name="expiration_date" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Reference ID / Invoice</label>
                                <input type="text" name="refnoid" class="form-control form-control-sm text-uppercase" placeholder="e.g., REF-2026-001">
                            </div>
                        </div>

                        <div class="mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between gap-2">
                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="fas fa-plus me-1"></i> Add Batch Stock
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Edit Medicine Details -->
    <div class="modal fade" id="editMedicineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-1"></i> Edit Medicine Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMedicineForm" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="editMedicineId">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Item Code / Category</label>
                                <input type="text" name="code" id="editMedicineCode" class="form-control form-control-sm text-uppercase">
                            </div> 

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Brand/Item Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="editMedicineName" class="form-control form-control-sm text-capitalize" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Generic Name</label>
                                <input type="text" name="generic_name" id="editMedicineGenericName" class="form-control form-control-sm text-capitalize">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Dosage</label>
                                <input type="text" name="dosage" id="editMedicineDosage" class="form-control form-control-sm">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Unit Measure <span class="text-danger">*</span></label>
                                <input type="text" name="unit" id="editMedicineUnit" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-1 fs-14 fw-medium">Reorder Level</label>
                                <input type="number" name="reorder_level" id="editMedicineReorderLevel" class="form-control form-control-sm" min="0">
                            </div>
                        </div>

                        <div class="mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-end gap-2">
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

    <!-- Modal 4: View Batch List (Table / Card Toggle) -->
    <div class="modal fade" id="viewBatchesModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="viewBatchesTitle"><i class="fas fa-boxes me-1"></i> Stock Batches</h5>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Toggle Buttons for Table vs Card View -->
                        <div class="btn-group btn-group-sm" role="group" aria-label="View switch">
                            <button type="button" class="btn btn-light active" id="btnViewTable">
                                <i class="fas fa-table me-1"></i> Table
                            </button>
                            <button type="button" class="btn btn-light" id="btnViewCard">
                                <i class="fas fa-th-large me-1"></i> Cards
                            </button>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- 1. Table View Container -->
                    <div id="batchTableView" class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="batchesListTable" style="width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th>Lot No.</th>
                                    <th>Received</th>
                                    <th>Remaining</th>
                                    <th>Exp.Date</th>
                                    <th>Ref/Invoice</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- 2. Card View Container -->
                    <div id="batchCardView" class="row g-3 d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 5: Edit Batch Stock -->
    <div class="modal fade" id="editBatchModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-1"></i> Edit Stock Batch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBatchForm" method="POST">
                        @csrf
                        <input type="hidden" name="batch_id" id="editBatchId">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Batch / Lot No. <span class="text-danger">*</span></label>
                                <input type="text" name="lotbatch_number" id="editBatchLotNumber" class="form-control form-control-sm text-uppercase" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Remaining Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity_remaining" id="editBatchQtyRemaining" class="form-control form-control-sm" min="0" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Expiration Date <span class="text-danger">*</span></label>
                                <input type="date" name="expiration_date" id="editBatchExpiration" class="form-control form-control-sm" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-1 fs-14 fw-medium">Reference ID / Invoice</label>
                                <input type="text" name="refnoid" id="editBatchRefNo" class="form-control form-control-sm text-uppercase">
                            </div>
                        </div>

                        <div class="mb-1 mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success px-3">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
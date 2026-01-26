@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Medicines</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#centermodalmedadd">
                    <i class="ti ti-plus me-1"></i> Add New Medicine
                </button>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">
            <div class="table-responsive">
                <table id="medlistab" class="table datatable table-nowrap" style="width: 100%">
                    <thead class="">
                        <tr>
                            <th>Category</th>
                            <th>Medicine</th>
                            <th>Quantity</th>
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
        <!-- row end -->
                        
    </div>
    <!-- End Content -->

    <!-- Center modal content -->
    <div class="modal fade" id="centermodalmedadd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Medicine</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="medicineForm" method="POST">
                        @csrf

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Category<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="category" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Category">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Medicine Name</label><br>
                                    <input type="text" name="medicine" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Medicine">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Quantity</label><br>
                                    <input type="number" name="qty"  class="form-control form-control-sm" autocomplete="off" placeholder="Enter Quantity">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Unit Measure</label><br>
                                    <input type="text" name="measure" class="form-control form-control-sm" autocomplete="off" placeholder="Unit Measure">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Lot No.</label><br>
                                    <input type="text" name="lotno" class="form-control form-control-sm" autocomplete="off" placeholder="Lot No.">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Expiry Date</label><br>
                                    <input type="date" name="expirydate" class="form-control form-control-sm" autocomplete="off" placeholder="Expiry Date">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reference ID</label><br>
                                    <input type="text" name="refnoid" class= "form-control form-control-sm" autocomplete="off" placeholder="Reference ID">
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
    <div class="modal fade" id="editMedicineModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Medicine</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMedicineForm" method="POST">
                        <input type="hidden" name="id" id="editMedicineId">
                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Category<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="category" id="editMedicineCategory" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Category">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Medicine Name</label><br>
                                    <input type="text" name="medicine" id="editMedicineName" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Medicine">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Quantity</label><br>
                                    <input type="number" name="qty" id="editMedicineQty" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Quantity">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Unit Measure</label><br>
                                    <input type="text" name="measure" id="editMedicineUnit" class="form-control form-control-sm" autocomplete="off" placeholder="Unit Measure">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Lot No.</label><br>
                                    <input type="text" name="lotno" id="editMedicineLotNo" class="form-control form-control-sm" autocomplete="off" placeholder="Lot No.">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Expiry Date</label><br>
                                    <input type="date" name="expirydate" id="editMedicineExpiry" class="form-control form-control-sm" autocomplete="off" placeholder="Expiry Date">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Reference ID</label><br>
                                    <input type="text" name="refnoid" id="editMedicineReference" class= "form-control form-control-sm" autocomplete="off" placeholder="Reference ID">
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
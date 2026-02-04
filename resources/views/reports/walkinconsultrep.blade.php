@extends('layouts.app')

@section('body')    
    <!-- Start Content -->
    <div class="content pb-0">

        <!-- Page Header -->
        <div class="d-flex align-items-sm-center justify-content-between flex-wrap gap-2 pb-3 mb-3 border-1 border-bottom">
            <div>
                <h4 class="fw-bold mb-0">Walkin Consultation Report</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
            </div>
        </div>
        <!-- End Page Header -->

        <!-- row start -->
        <div class="row">
            <div class="tab-content">
                <div class="tab-pane show active" id="students">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST">
                                @csrf

                                <!-- start row-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 text-dark fs-14 fw-medium">
                                                Select Category<span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-control form-control-sm" name="category" id="editusercategory">
                                                    <option disabled selected>Select</option>
                                                    <option value="Month">Monthly</option>
                                                    <option value="Daily">Daily</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Monthly dropdown -->
                                    <div class="col-md-2 d-none" id="monthlyInput">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Select Month</label>
                                            <select class="form-control form-control-sm" name="month">
                                                <option disabled selected>Select Month</option>
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Daily date picker -->
                                    <div class="col-md-2 d-none" id="dailyInput">
                                        <div class="mb-3">
                                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Select Date</label>
                                            <input type="date" class="form-control form-control-sm" name="date">
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <!-- End Content -->

    <script>
        document.getElementById('editusercategory').addEventListener('change', function () {
            const monthly = document.getElementById('monthlyInput');
            const daily = document.getElementById('dailyInput');

            if (this.value === 'Month') {
                monthly.classList.remove('d-none');
                daily.classList.add('d-none');
            } 
            else if (this.value === 'Daily') {
                daily.classList.remove('d-none');
                monthly.classList.add('d-none');
            }
        });
    </script>

@endsection
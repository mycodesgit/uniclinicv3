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
                            <form action="{{ route('walkin.search.result') }}" method="GET" id="walkinreps">
                                @csrf

                                <!-- start row-->
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">
                                            Select Category<span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" name="category" id="selectcategory" required>
                                                <option disabled selected>Select</option>
                                                <option value="Month">Monthly</option>
                                                <option value="Daily">Daily</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">
                                            Select Patient Category<span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select class="form-control form-control-sm" name="pcat" id="selectpcat">
                                                <option disabled selected>Select</option>
                                                <option value="1">Student</option>
                                                <option value="2">Faculty</option>
                                                <option value="3">Guest</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-none" id="monthlyInput">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Select Month<span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm" name="monthly">
                                            <option disabled selected>Select Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 d-none" id="dailyInput">
                                        <label class="form-label mb-1 text-dark fs-14 fw-medium">Select Date<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-sm" name="date">
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-outline-primary btn-md">
                                                <i class="fas fa-file"></i>&nbsp;&nbsp;Generate Report
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="consultationstudrepTable" class="table table-hover" style="width: 100%">
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
                            <tbody>

                            </tbody>
                        </table>
                        <br>
                        <nav>
                            <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                        </nav>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <!-- End Content -->

    <script>
        document.getElementById('selectcategory').addEventListener('change', function () {
            const monthly = document.getElementById('monthlyInput');
            const daily = document.getElementById('dailyInput');

            if (this.value === 'Month') {
                monthly.classList.remove('d-none');
                daily.classList.add('d-none');
                daily.querySelector('input').value = '';
            } 
            else if (this.value === 'Daily') {
                daily.classList.remove('d-none');
                monthly.classList.add('d-none');
                monthly.querySelector('select').selectedIndex = 0;
            }
        });
    </script>

@endsection
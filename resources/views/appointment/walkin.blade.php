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
                {{-- <a href="javascript:void(0);" class="btn btn-outline-primary d-inline-flex align-items-center" data-bs-toggle="offcanvas" data-bs-target="#new_consult_appointment"><i class="ti ti-plus me-1"></i>New Appointment</a>
                <a href="javascript:void(0);" class="btn btn-outline-white bg-white d-inline-flex align-items-center"><i class="ti ti-calendar-time me-1"></i>Schedule Availability</a> --}}
            </div>
        </div>
        <!-- End Page Header -->

        <!-- tab start -->
        <ul class="nav nav-tabs nav-bordered mb-3">
            <li class="nav-item">
                <a href="#students" data-bs-toggle="tab" aria-expanded="false" class="nav-link active bg-transparent">
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#employees" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Employees</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#outsiders" data-bs-toggle="tab" aria-expanded="true" class="nav-link bg-transparent">
                    <span>Guest</span>
                </a>
            </li>
        </ul>
        <!-- tab end -->

        <!-- row start -->
        <div class="row">
            <div class="tab-content">
                <div class="tab-pane show active" id="students">
                    <div class="card">
                        <div class="card-body">
                            <form id="searchForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="searchInput" name="searchStud" class="form-control" placeholder="Search Patient Last Name or ID">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-outline-primary mt-1">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap" id="">
                            <thead class="">
                                <tr>
                                    <th>Name</th>
                                    <th>StudID</th>
                                    <th>Gender</th>
                                    <th>Campus</th>
                                    <th>Civil Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTable">
                                <tr>
                                    <td colspan="5" class="text-center">Search to load data</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <nav>
                            <ul class="pagination justify-content-center" id="paginationLinks"></ul>
                        </nav>
                    </div>
                </div>

                <div class="tab-pane" id="employees">
                    <div class="card">
                        <div class="card-body">
                            <form id="searchEmpForm">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="searchEmpInput" name="searchemp" class="form-control" placeholder="Search Patient Last Name or Employee ID">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-outline-primary mt-1">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- end card body -->
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable table-nowrap" id="">
                            <thead class="">
                                <tr>
                                    <th>Name</th>
                                    <th>EmpID</th>
                                    <th>Gender</th>
                                    <th>Campus</th>
                                    <th>Civil Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="employeesTable">
                                <tr>
                                    <td colspan="6" class="text-center">Search to load data</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <nav>
                            <ul class="pagination justify-content-center" id="paginationEmpLinks"></ul>
                        </nav>
                    </div>
                </div>

                <div class="tab-pane" id="outsiders">
                    <div class="table-responsive">
                        <table id="guesttabletab" class="table datatable table-nowrap" style="width: 100%">
                            <thead class="">
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Civil Status</th>
                                    <th>Date Added</th>
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
        <!-- row end -->
                        
    </div>
    <!-- End Content -->

@endsection
@extends('layouts.app')

@section('body')
    <div class="row ">
        <div class="col-12">
            <div class="mb-6">
                <h1 class="fs-3 mb-4">Users</h1>
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
                                    <i class="fas fa-users"></i> List of Users
                                </h6>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#centermodaluseradd">
                                    <i class="fas fa-plus me-1"></i> Add New User
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive mt-2 p-2">
                                    <table id="userlistab" class="table table-hover" style="width: 100%">
                                        <thead class="">
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
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

    <!-- Center add modal content -->
    <div class="modal fade" id="centermodaluseradd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Add New User</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" method="POST">
                        @csrf

                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Last Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="lname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter Last Name" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">First Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="fname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter First Name" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Middle Name</label><br>
                                    <input type="text" name="mname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Middle Name">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Ext</label><br>
                                    <select class="form-control form-control-sm" name="ext">
                                        <option disabled selected> --- Select Here --- </option>
                                        <option value="">None</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Gender</label><br>
                                    <select class="form-control form-control-sm" name="gender">
                                        <option value=""> --- Select Here --- </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Role</label><br>
                                    <select class="form-control select_camp form-control-sm" name="role">
                                        <option value=""> --- Select Role --- </option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Nurse">Nurse</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Email</label><br>
                                    <input type="email" name="email" placeholder="Enter Email" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Password</label><br>
                                    <input type="password" name="password" placeholder="Enter Password" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Campus<span class="text-danger">*</span></label><br>
                                    <select class="form-control form-control-sm" name="campus" required>
                                        <option disabled selected>Select</option>
                                        <option value="MC" @if (old('campus') == 'MC') {{ 'selected' }} @endif>Main</option>
                                        <option value="VC" @if (old('campus') == 'VC') {{ 'selected' }} @endif>Victorias</option>
                                        <option value="SCC" @if (old('campus') == 'SCC') {{ 'selected' }} @endif>San Carlos</option>
                                        <option value="HC" @if (old('campus') == 'HC') {{ 'selected' }} @endif>Hinigaran</option>
                                        <option value="MP" @if (old('campus') == 'MP') {{ 'selected' }} @endif>Moises Padilla</option>
                                        <option value="IC" @if (old('campus') == 'IC') {{ 'selected' }} @endif>Ilog</option>
                                        <option value="CA" @if (old('campus') == 'CA') {{ 'selected' }} @endif>Candoni</option>
                                        <option value="CC" @if (old('campus') == 'CC') {{ 'selected' }} @endif>Cauayan</option>
                                        <option value="SC" @if (old('campus') == 'SC') {{ 'selected' }} @endif>Sipalay</option>
                                        <option value="HinC" @if (old('campus') == 'HinC') {{ 'selected' }} @endif>Hinobaan</option>
                                        <option value="VE" @if (old('campus') == 'VE') {{ 'selected' }} @endif>Valladolid</option>
                                    </select>
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

    <!-- Center edit info modal content -->
    <div class="modal fade" id="edituserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Edit User</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        <input type="hidden" name="id" id="edituserId">
                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">First Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="fname" id="edituserfname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" placeholder="Enter First Name" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Middle Name</label><br>
                                    <input type="text" name="mname" id="editusermname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Middle Name">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Last Name<span class="text-danger">*</span></label><br>
                                    <input type="text" name="lname" id="edituserlname" oninput="var words = this.value.split(' '); for(var i = 0; i < words.length; i++){ words[i] = words[i].substr(0,1).toUpperCase() + words[i].substr(1); } this.value = words.join(' ');" class="form-control form-control-sm" autocomplete="off" placeholder="Enter Last Name">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Ext.</label><br>
                                    <select class="form-control form-control-sm" name="ext" id="edituserext">
                                        <option value="">None</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Email<span class="text-danger">*</span></label><br>
                                    <input type="email" name="email" id="edituseremail" placeholder="Enter Email" class="form-control form-control-sm">
                                </div>
                            </div> <!-- end col-->

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Campus<span class="text-danger">*</span></label><br>
                                    <select class="form-control form-control-sm" name="campus" id="editusercampus">
                                        <option disabled selected>Select</option>
                                        <option value="MC">Main</option>
                                        <option value="VC">Victorias</option>
                                        <option value="SCC">San Carlos</option>
                                        <option value="HC">Hinigaran</option>
                                        <option value="MP">Moises Padilla</option>
                                        <option value="IC">Ilog</option>
                                        <option value="CA">Candoni</option>
                                        <option value="CC">Cauayan</option>
                                        <option value="SC">Sipalay</option>
                                        <option value="HinC">Hinobaan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Gender<span class="text-danger">*</span></label><br>
                                    <select class="form-control form-control-sm" name="gender" id="editusergender">
                                        <option value=""> --- Select Here --- </option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">Role<span class="text-danger">*</span></label><br>
                                    <select class="form-control form-control-sm" name="role" id="edituserrole">
                                        <option disabled selected> --Select-- </option>
                                        <option value="Administrator">Administrator</option>
                                        <option value="Nurse">Nurse</option>
                                    </select>
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

    <!-- Center edit password modal content -->
    <div class="modal fade" id="edituserPassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Edit User Password</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edituserPassForm" method="POST">
                        <input type="hidden" name="id" id="edituserPassId">
                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">New Password<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="password" id="edituserpass" placeholder="Enter New Password" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div> <!-- end col-->
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

    <!-- Center edit user status modal content -->
    <div class="modal fade" id="edituserDeactModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myCenterModalLabel">Edit User Status</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edituserDeactForm" method="POST">
                        <input type="hidden" name="id" id="edituserDeactId">
                        <!-- start row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label mb-1 text-dark fs-14 fw-medium">User Status<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select name="status" class="form-control form-control-sm" id="edituserDeactStat">
                                            <option disabled selected> --Select-- </option>
                                            <option value="1">Enable</option>
                                            <option value="2">Disabled</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end col-->
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

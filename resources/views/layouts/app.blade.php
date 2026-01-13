
<!DOCTYPE html>
<html lang="en" data-color="teal">


<!-- Mirrored from preclinic.dreamstechnologies.com/html/template/doctor-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jan 2026 06:38:08 GMT -->
<head>

	<!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Dashboard - Medical & Hospital - Bootstrap 5 Admin Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="author" content="Dreams Technologies">
	
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Apple Icon -->
    <link rel="apple-touch-icon" href="{{ asset('assets/img/apple-icon.png') }}">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/theme-script.js') }}" type="c69ced46290eea12272fe16a-text/javascript"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- Simplebar CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/simplebar.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="app-style">

    <style>
        .readonlytext {
            background-color: #e9e9e9 !important; border: 1px solid #aaa;"
        }
    </style>

</head>

<body>

    <!-- Begin Wrapper -->
    <div class="main-wrapper">

        <!-- Topbar Start -->
        <header class="navbar-header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Logo -->
                    <a href="index.html" class="logo">

                        <!-- Logo Normal -->
                        <span class="logo-light">
                            <span class="logo-lg"><img src="{{ asset('assets/img/logo.svg') }}" alt="logo"></span>
                            <span class="logo-sm"><img src="{{ asset('assets/img/logo-small.svg') }}" alt="small logo"></span>
                        </span>

                        <!-- Logo Dark -->
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="{{ asset('assets/img/logo-white.svg') }}" alt="dark logo"></span>
                        </span>
                    </a>

                    <!-- Sidebar Mobile Button -->
                    <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </a>
                       
                    <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn2"> 
                        <i class="ti ti-arrow-right"></i>
                    </button>  
					
                    <!-- Search -->
                    <div class="me-auto d-flex align-items-center header-search d-lg-flex d-none">
                        <!-- Search -->
                        <div class="input-icon-start position-relative me-2">
                            <span class="input-icon-addon">
                                <i class="ti ti-search"></i>
                            </span>
                           <input type="text" class="form-control shadow-sm" placeholder="Search">
                           <span class="input-icon-addon text-dark shadow fs-18 d-inline-flex p-0 header-search-icon"><i class="ti ti-command"></i></span>
                        </div>
                        <!-- /Search -->
                    </div>
					
                </div>

                <div class="d-flex align-items-center">
				
                    <!-- Search for Mobile -->
                    <div class="header-item d-flex d-lg-none me-2">
                        <button class="topbar-link btn btn-icon" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                            <i class="ti ti-search fs-16"></i>
                        </button>
                    </div>

                    <div class="header-item">
                        <div class="dropdown me-2">
                            <a href="doctors-appointments.html" class="btn topbar-link"><i class="ti ti-calendar-due"></i></a>
                        </div>
                    </div>                    

                    <div class="header-item">
                        <div class="dropdown me-2">
                            <a href="doctors-profile-settings.html" class="btn topbar-link"><i class="ti ti-settings-2"></i></a>
                        </div> 
                    </div>                    

                    <!-- Light/Dark Mode Button -->
                    <div class="header-item d-none d-sm-flex me-2">
                        <button class="topbar-link btn btn-icon topbar-link" id="light-dark-mode" type="button">
                            <i class="ti ti-moon fs-16"></i>
                        </button>
                    </div>
                    
					
					<!-- Notification Dropdown -->
                    <div class="header-item">
						<div class="dropdown me-3">
						
							<button class="topbar-link btn btn-icon topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false" aria-expanded="false">
								<i class="ti ti-bell-check fs-16 animate-ring"></i>
								<span class="notification-badge"></span>
							</button>
							
							<div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
							
								<div class="p-2 border-bottom">
									<div class="row align-items-center">
										<div class="col">
											<h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
										</div>
									</div>
								</div>
								
								<!-- Notification Body -->
								<div class="notification-body position-relative z-2 rounded-0" data-simplebar>
								 
									<!-- Item-->
									<div class="dropdown-item notification-item py-3 text-wrap border-bottom" id="notification-1">
										<div class="d-flex">
											<div class="me-2 position-relative flex-shrink-0">
												<img src="{{ asset('assets/img/doctors/doctor-01.jpg') }}" class="avatar-md rounded-circle" alt="">
											</div>
											<div class="flex-grow-1">
												<p class="mb-0 fw-medium text-dark">Dr. Smith</p>
												<p class="mb-1 text-wrap">
													updated the <span class="fw-medium text-dark">surgery</span> schedule. 
												</p>
												<div class="d-flex justify-content-between align-items-center">
													<span class="fs-12"><i class="ti ti-clock me-1"></i>4 min ago</span>
													<div class="notification-action d-flex align-items-center float-end gap-2">
														<a href="javascript:void(0);" class="notification-read rounded-circle bg-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Make as Read" aria-label="Make as Read"></a>
														<button class="btn rounded-circle p-0" data-dismissible="#notification-1">
															<i class="ti ti-x"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
							
									<!-- Item-->
									<div class="dropdown-item notification-item py-3 text-wrap border-bottom" id="notification-2">
										<div class="d-flex">
											<div class="me-2 position-relative flex-shrink-0">
												<img src="{{ asset('assets/img/doctors/doctor-06.jpg') }}" class="avatar-md rounded-circle" alt="">
											</div>
											<div class="flex-grow-1">
												<p class="mb-0 fw-medium text-dark">Dr. Patel</p>
												<p class="mb-1 text-wrap">
                                                    completed a <span class="fw-medium text-dark">follow-up</span> report for patient <span class="fw-medium text-dark">Emily</span>.
												</p>
												<div class="d-flex justify-content-between align-items-center">
													<span class="fs-12"><i class="ti ti-clock me-1"></i>8 min ago</span>
													<div class="notification-action d-flex align-items-center float-end gap-2">
														<a href="javascript:void(0);" class="notification-read rounded-circle bg-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Make as Read" aria-label="Make as Read"></a>
														<button class="btn rounded-circle p-0" data-dismissible="#notification-2">
															<i class="ti ti-x"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Item-->
									<div class="dropdown-item notification-item py-3 text-wrap border-bottom" id="notification-3">
										<div class="d-flex">
											<div class="me-2 position-relative flex-shrink-0">
												<img src="{{ asset('assets/img/doctors/doctor-02.jpg') }}" class="avatar-md rounded-circle" alt="">
											</div>
											<div class="flex-grow-1">
												<p class="mb-0 fw-medium text-dark">Emily</p>
												<p class="mb-1 text-wrap">
                                                    booked an appointment with <span class="fw-medium text-dark">Dr. Patel</span> for <span class="fw-medium text-dark">April 15</span>
												</p>
												<div class="d-flex justify-content-between align-items-center">
													<span class="fs-12"><i class="ti ti-clock me-1"></i>15 min ago</span>
													<div class="notification-action d-flex align-items-center float-end gap-2">
														<a href="javascript:void(0);" class="notification-read rounded-circle bg-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Make as Read" aria-label="Make as Read"></a>
														<button class="btn rounded-circle p-0" data-dismissible="#notification-3">
															<i class="ti ti-x"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Item-->
									<div class="dropdown-item notification-item py-3 text-wrap" id="notification-4">
										<div class="d-flex">
											<div class="me-2 position-relative flex-shrink-0">
												<img src="{{ asset('assets/img/doctors/doctor-07.jpg') }}" class="avatar-md rounded-circle" alt="">
											</div>
											<div class="flex-grow-1">
												<p class="mb-0 fw-medium text-dark">Amelia</p>
												<p class="mb-1 text-wrap">
                                                    completed the <span class="fw-medium text-dark">pre-visit</span> health questionnaire.
												</p>
												<div class="d-flex justify-content-between align-items-center">
													<span class="fs-12"><i class="ti ti-clock me-1"></i>20 min ago</span>
													<div class="notification-action d-flex align-items-center float-end gap-2">
														<a href="javascript:void(0);" class="notification-read rounded-circle bg-danger" data-bs-toggle="tooltip" title="" data-bs-original-title="Make as Read" aria-label="Make as Read"></a>
														<button class="btn rounded-circle p-0" data-dismissible="#notification-4">
															<i class="ti ti-x"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									 
								</div>
								
								<!-- View All-->
								<div class="p-2 rounded-bottom border-top text-center">
									<a href="doctors-notifications.html" class="text-center text-decoration-underline fs-14 mb-0">
										View All Notifications
									</a>
								</div> 
								
							</div>
						</div>
					</div>
					
					<!-- User Dropdown -->
					<div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);" class="topbar-link dropdown-toggle drop-arrow-none position-relative" data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('assets/img/doctors/doctor-01.jpg') }}" width="32" class="rounded-circle d-flex" alt="user-image">
                            <span class="online text-success"><i class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                        
                            <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                                <img src="{{ asset('assets/img/doctors/doctor-01.jpg') }}" class="rounded-circle" width="42" height="42" alt="">
                                <div class="ms-2">
                                    <p class="fw-medium text-dark mb-0">Dr.Michael Smith</p>
                                    <span class="d-block fs-13">Cardiologist</span>
                                </div>
                            </div>

                            <!-- Item-->
                            <a href="doctors-profile-settings.html" class="dropdown-item">
                                <i class="ti ti-user-circle me-1 align-middle"></i>
                                <span class="align-middle">Profile Settings</span>
                            </a>

                            <!-- item -->
                            <div class="form-check form-switch form-check-reverse d-flex align-items-center justify-content-between dropdown-item mb-0">
                                <label class="form-check-label" for="notify"><i class="ti ti-bell me-1"></i>Notifications</label>
                                <input class="form-check-input me-0" type="checkbox" role="switch" id="notify">
                            </div>

                            <!-- Item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="ti ti-receipt me-1 align-middle"></i>
                                <span class="align-middle">Activity Logs</span>
                            </a>

                             <!-- Item-->
                             <a href="javascript:void(0);" class="dropdown-item">
                                <i class="ti ti-help me-1 align-middle"></i>
                                <span class="align-middle">Help & Support</span>
                            </a>
                                        
                            
                            <!-- Item-->
                            <div class="pt-2 mt-2 border-top">
                                <a href="login.html" class="dropdown-item text-danger">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
						
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card shadow-none mb-0">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="search-top">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" placeholder="Search">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i class="ti ti-x fs-22"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidenav Menu Start -->
        <div class="sidebar" id="sidebar">
            
            <!-- Start Logo -->
            <div class="sidebar-logo">
                <div>
                    <!-- Logo Normal -->
                    <a href="./" class="logo logo-normal" style="margin-top: -5px">
                        <img src="{{ asset('assets/img/MDHULogoblack.png') }}" alt="Logo">
                    </a>

                    <!-- Logo Small -->
                    <a href="index.html" class="logo-small">
                        <img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
                    </a>

                    <!-- Logo Dark -->
                    <a href="index.html" class="dark-logo">
                        <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
                    </a>
                </div>
                {{-- <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn"> 
                    <i class="ti ti-arrow-left text-body"></i>
                </button> --}}

                <!-- Sidebar Menu Close -->
                <button class="sidebar-close">
                    <i class="ti ti-x align-middle"></i>
                </button>                
            </div>
            <!-- End Logo -->

            <!-- Sidenav Menu -->
            <div class="sidebar-inner" data-simplebar>                
                <div id="sidebar-menu" class="sidebar-menu">
                    @include('includes.sidebar')                   
                </div>
                {{-- <div class="sidebar-footer mt-5">
                    <div class="trial-item mt-0 p-3 text-center">
                        <div class="trial-item-icon rounded-4 mb-3 p-2 text-center shadow-sm d-inline-flex">
                            <img src="{{ asset('assets/img/icons/sidebar-icon.svg') }}" alt="img">
                        </div>
                        <div>
                            <h6 class="fs-14 fw-semibold mb-1">Upgrade To Pro</h6>
                            <p class="fs-13 mb-0">Check 1 min video and begin use Preclinic like a pro</p>
                        </div>
                        <a href="javascript:void(0);" class="close-icon shadow-sm"><i class="ti ti-x"></i></a>
                    </div>
                </div> --}}
            </div>

        </div>
        <!-- Sidenav Menu End -->

        <!-- ========================
			Start Page Content
		========================= -->
         
        <div class="page-wrapper">

            @yield('body')

            <!-- Footer Start -->
            <div class="footer text-center bg-white p-2 border-top">
                <p class="text-dark mb-0">2025 &copy; <a href="javascript:void(0);" class="link-primary">MDHU</a>, All Rights Reserved</p>
            </div>
            <!-- Footer End -->

        </div>

        <!-- ========================
			End Page Content
		========================= -->

    </div>
    <!-- End Wrapper -->
    
    <!-- Start Add New Appointment -->
    <div class="offcanvas offcanvas-offset offcanvas-end" tabindex="-1" id="new_appointment">
        <div class="offcanvas-header d-block pb-0 px-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3 px-3">
                <h5 class="offcanvas-title fs-18 fw-bold">New Appointment</h5>
                <button type="button" class="btn-close custom-btn-close opacity-100" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body pt-3">
            <form action="#">
                <!-- start row-->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Appointment ID <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control rounded bg-light" value="AP234354">
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Patient<span class="text-danger">*</span></label>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle form-control rounded d-flex align-items-center justify-content-between border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                    Select
                                </a>
                                <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                                    <div class="mb-3">
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon fs-12">
                                                <i class="ti ti-search"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-sm" placeholder="Search">
                                        </div>
                                    </div>
                                    <ul class="mb-3 list-style-none">
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/users/user-02.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Emily Clark
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>John Carter
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/profiles/avatar-16.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Sophia White
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/profiles/avatar-15.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Michael Johnson
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/profiles/avatar-14.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>Olivia Harris
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                <span class="avatar avatar-sm rounded-circle me-2"><img src="{{ asset('assets/img/profiles/avatar-01.jpg') }}" class="flex-shrink-0 rounded-circle" alt="img"></span>David Anderson
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Appointment Type <span class="text-danger">*</span></label>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle form-control rounded d-flex align-items-center justify-content-between border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                    Select
                                </a>
                                <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                                    <div class="mb-3">
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon fs-12">
                                                <i class="ti ti-search"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-sm" placeholder="Select">
                                        </div>
                                    </div>
                                    <ul class="mb-3 list-style-none">
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                In Person
                                            </label>
                                        </li>
                                        <li class="list-none">
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                Online
                                            </label>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium"> Date of Appointment <span class="text-danger">*</span></label>
                            <div class="input-icon-end position-relative">  
                                <input type="text" class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                <span class="input-icon-addon">
                                    <i class="ti ti-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium"> Time <span class="text-danger">*</span></label>
                            <div class="input-icon-end position-relative">  
                                <input type="text" class="form-control timepicker" placeholder="-- : --">
                                <span class="input-icon-addon">
                                    <i class="ti ti-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <div>
                                <label class="form-label mb-1 text-dark fs-14 fw-medium">Appointment Reason</label>
                                <textarea rows="4" class="form-control rounded"> </textarea>
                            </div>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label mb-1 text-dark fs-14 fw-medium">Status<span class="text-danger">*</span></label>
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle form-control rounded d-flex align-items-center justify-content-between border" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                                    Select
                                </a>
                                <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                                    <div class="mb-3">
                                        <div class="input-icon-start position-relative">
                                            <span class="input-icon-addon fs-12">
                                                <i class="ti ti-search"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-sm" placeholder="Select">
                                        </div>
                                    </div>
                                    <ul class="mb-3 list-style-none">
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                Checked Out
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox" checked>
                                                Checked In
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                Cancelled
                                            </label>
                                        </li>
                                        <li>
                                            <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                                <input class="form-check-input m-0 me-2" type="checkbox">
                                                Scheduled
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                </div>
                <!-- end row-->
            </form>
        </div>
        <div class="offcanvas-footer mb-1 mt-3 p-3 border-1 border-top">
            <div class=" d-flex justify-content-end gap-2">
                <a href="javascript:void(0);" class="btn btn-light btm-md">Cancel</a>
                <button data-bs-dismiss="offcanvas" class="btn btn-primary btm-md" id="filter-submit">Create Create Appointment</button>
            </div>
        </div>
    </div>
    <!-- End Add New Appointment-->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>    

	<!-- Simplebar JS -->
	<script src="{{ asset('assets/plugins/simplebar/simplebar.min.js') }}" type="text/javascript"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}" type="text/javascript"></script>

    <!-- Daterangepikcer JS -->
	<script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script> 

    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>

    @if (request()->routeIs('patients.students'))
    @endif
    @if (request()->routeIs('patients.details'))
        @include('script.patient.studentscript')
        @include('script.patient.patientaddressscript')
    @endif

</body>


<!-- Mirrored from preclinic.dreamstechnologies.com/html/template/doctor-dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jan 2026 06:38:13 GMT -->
</html>
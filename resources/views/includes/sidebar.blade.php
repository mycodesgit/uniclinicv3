@php
    $current_route=request()->route()->getName();

    $medicineActive = in_array($current_route, ['medicine.index']) ? 'active' : '';
    $complaintActive = in_array($current_route, ['complaint.index']) ? 'active' : '';
    $medserviceActive = in_array($current_route, ['medservices.index']) ? 'active' : '';
    $accidentActive = in_array($current_route, ['accident.index']) ? 'active' : '';

    $preenrolmentActive = in_array($current_route, ['admission.index', 'admission.store']) ? 'active' : '';

    $walkInActive = in_array($current_route, ['appointment.walkin', 'appointment.walkin.details', 'appointment.walkin.empdetails']) ? 'active' : '';
    $onlineActive = in_array($current_route, ['appointment.online']) ? 'active' : '';

    $reportsActive = in_array($current_route, ['reports.medical.statistic', 'reports.medical.statistic.store']) ? 'active' : '';
    $reportsMedicineActive = in_array($current_route, ['reports.medicine', 'reports.medicine.store']) ? 'active' : '';
    $reportsStockMedicineActive = in_array($current_route, ['reports.stockmedicine', 'reports.stockmedicine.store']) ? 'active' : '';

    $usersActive = in_array($current_route, ['users.list']) ? 'active' : '';
@endphp

<ul class="nav flex-column">
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Main</small>
    </li>
    <li>
        <a class="nav-link {{$current_route=='dashboard.index'?'active':''}}" href="{{ route('dashboard.index') }}">
            <i class="ti ti-layout-grid"></i><span class="nav-text">Dashboard</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ request()->is('patient/*') ? 'active' : '' }}" href="{{ route('patients.students') }}">
            <i class="ti ti-users"></i><span class="nav-text">Patients</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $medicineActive }}" href="{{ route('medicine.index') }}">
            <i class="ti ti-pills"></i><span class="nav-text">Medicines</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $complaintActive }}" href="{{ route('complaint.index') }}">
            <i class="ti ti-details"></i><span class="nav-text">Chief Complaints</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $medserviceActive }}" href="{{ route('medservices.index') }}">
            <i class="ti ti-server"></i><span class="nav-text">Medical Services</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $accidentActive }}" href="{{ route('accident.index') }}">
            <i class="ti ti-stethoscope"></i><span class="nav-text">Accident & Injuries</span>
        </a>
    </li>

    <li class="px-4 py-2">
        <small class="nav-text text-muted">Admission</small>
    </li>
    <li>
        <a class="nav-link {{ $preenrolmentActive }}" href="{{ route('admission.index') }}">
            <i class="ti ti-users-group"></i><span class="nav-text">Pre-enrollment</span>
        </a>
    </li>
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Appointments</small>
    </li>
    <li>
        <a class="nav-link {{ $walkInActive }}" href="{{ route('appointment.walkin') }}">
            <i class="ti ti-calendar-check"></i><span class="nav-text">Consultations</span>
        </a>
    </li>
    {{-- <li>
        <a class="nav-link {{ $onlineActive }}" href="{{ route('appointment.online') }}">
            <i class="ti ti-calendar-check"></i><span class="nav-text">Online Consultations</span>
        </a>
    </li> --}}

    <li class="px-4 py-2">
        <small class="nav-text text-muted">Reports</small>
    </li>
    <li>
        <a class="nav-link {{ $reportsActive }}" href="{{ route('reports.medical.statistic') }}">
            <i class="ti ti-file-type-pdf"></i><span class="nav-text">Medical Statistics</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $reportsMedicineActive }}" href="{{ route('reports.medicine') }}">
            <i class="ti ti-file-type-pdf"></i><span class="nav-text">Medicines Report</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $reportsStockMedicineActive }}" href="{{ route('reports.stockmedicine') }}">
            <i class="ti ti-file-type-pdf"></i><span class="nav-text">Medicines Stock Report</span>
        </a>
    </li>

    <li class="px-4 py-2">
        <small class="nav-text text-muted">User Management</small>
    </li>
    <li>
        <a class="nav-link {{ $usersActive }}" href="{{ route('users.list') }}">
            <i class="ti ti-users"></i><span class="nav-text">Users</span>
        </a>
    </li>
</ul>
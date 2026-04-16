@php
    $current_route=request()->route()->getName();

    $walkInActive = in_array($current_route, ['appointment.walkin', 'appointment.walkin.details']) ? 'active' : '';
    $onlineActive = in_array($current_route, ['appointment.online']) ? 'active' : '';
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
    <li class="px-4 py-2">
        <small class="nav-text text-muted">Appointments</small>
    </li>
    <li>
        <a class="nav-link {{ $walkInActive }}" href="{{ route('appointment.walkin') }}">
            <i class="ti ti-calendar-check"></i><span class="nav-text">Walkin Consultations</span>
        </a>
    </li>
    <li>
        <a class="nav-link {{ $onlineActive }}" href="{{ route('appointment.online') }}">
            <i class="ti ti-calendar-check"></i><span class="nav-text">Online Consultations</span>
        </a>
    </li>
</ul>
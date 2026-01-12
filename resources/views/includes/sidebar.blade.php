@php
    $current_route=request()->route()->getName();
@endphp

<ul>
    <li class="menu-title"><span>Main Menu</span></li>
    <li>
        <ul>
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="ti ti-layout-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('patient/*') ? 'active' : '' }}">
                <a href="{{ route('patients.students') }}">
                    <i class="ti ti-users"></i><span>Patients</span>
                </a>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);" class="{{ request()->is('appointment/*') ? 'active subdrop' : '' }}">
                    <i class="ti ti-calendar-check"></i><span>Appointments</span>
                    <span class="menu-arrow"></span>
                </a>
                <ul>
                    <li class="{{ request()->is('appointment/walkins') ? 'active' : '' }}"><a href="{{ route('appointment.walkin') }}">Walkin Consultation</a></li>
                    <li class="{{ request()->is('appointment/online') ? 'active' : '' }}"><a href="{{ route('appointment.online') }}">Online Consultations</a></li>
                </ul>
            </li>
            <li>
                <a href="doctors-prescriptions.html">
                    <i class="ti ti-prescription"></i><span>Medicines</span>
                </a>
            </li>
            <li>
                <a href="doctors-schedules.html">
                    <i class="ti ti-file"></i><span>Reports</span>
                </a>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);">
                    <i class="ti ti-settings"></i><span>Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <ul>
                    <li><a href="doctors-profile-settings.html">Profile Settings</a></li>
                    <li><a href="doctors-password-settings.html">Change Password</a></li>
                    <li><a href="doctors-notification-settings.html">Notifications</a></li>
                </ul>
            </li>
        </ul>
    </li>
                    
</ul>
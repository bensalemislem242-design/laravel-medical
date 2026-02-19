<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Logout button -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link logout" href="{{ route('logout') }}" role="button" title="logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('img/appointments1.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="max-height: 38px; opacity: .8">
        <span class="brand-text font-weight-light"><b>CIMS</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- User Info -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
                    </a>
                </li>

                {{-- Hide Patients list for PATIENT role --}}
                @if (Auth::user()->role->value != \App\Enums\UserRoles::PATIENT->value)
                    <li class="nav-item">
                        <a href="{{ route('patients.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus-circle"></i>
                            <p>Patients List</p>
                        </a>
                    </li>
                @endif

                <!-- Doctors list -->
                <li class="nav-item">
                    <a href="{{ route('doctors.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Doctors List</p>
                    </a>
                </li>

                <!-- Appointments list -->
                <li class="nav-item">
                    <a href="{{ route('appointments.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Appointment List</p>
                    </a>
                </li>

                {{-- Display Users list only for Admin --}}
                @if (Auth::user()->role->value == \App\Enums\UserRoles::ADMIN->value)
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users List</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>
<!-- /.sidebar -->

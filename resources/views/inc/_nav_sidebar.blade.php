<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light bg-white border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars fa-lg"></i>
            </a>
        </li>
    </ul>

    <!-- Logout button -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" role="button" title="Logout">
                <i class="fas fa-power-off fa-lg"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light elevation-4" style="background-color: #ffffff;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link d-flex align-items-center">
        <img src="{{ asset('img/logo.png') }}" alt="SmartHospital Logo"
             style="height: 38px; margin-right: 10px;">
        <span class="brand-text font-weight-bold text-dark">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Info -->
        <li class="nav-item d-flex align-items-center mb-3 mt-3">
            <a href="{{ route('profile.edit') }}" class="nav-link d-flex align-items-center">
                @if(Auth::user()->image)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" 
                         style="width:35px;height:35px;border-radius:50%;object-fit:cover;margin-right:8px;">
                @else
                    <i class="nav-icon fas fa-user-circle mr-2" style="font-size:1.5rem;"></i>
                @endif
                <span>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</span>
            </a>
        </li>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Manage Hospitals -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('hospitals.index') }}">
                      <i class="nav-icon fas fa-home"></i>
                        <p>Manage Hospitals</p>
                    </a>
                </li>

                <!-- Patients List -->
                @if (Auth::user()->role->value != \App\Enums\UserRoles::PATIENT->value)
                    <li class="nav-item">
                        <a href="{{ route('patients.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>Patients List</p>
                        </a>
                    </li>
                @endif

                <!-- Doctors List -->
                <li class="nav-item">
                    <a href="{{ route('doctors.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>Doctors List</p>
                    </a>
                </li>

    <!-- Appointments with Badge -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar-check"></i>
                <p>
                    Appointments
                    @if(isset($newAppointmentsCount) && $newAppointmentsCount > 0)
                        <span class="badge bg-danger ml-2">{{ $newAppointmentsCount }}</span>
                    @endif
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('appointments.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Appointments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('appointments.calendar') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Calendar View</p>
                    </a>
                </li>

                <!-- Notifications Link -->
                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="nav-link d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="nav-icon fas fa-bell"></i>
                            <p class="ml-2 mb-0">Notifications</p>
                        </div>
                        @if(isset($newAppointmentsCount) && $newAppointmentsCount > 0)
                            <span class="badge bg-warning">{{ $newAppointmentsCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
                <!-- Invoices -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            Invoices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ route('invoices.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>All Invoices</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('invoices.revenue_chart') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Revenue Chart</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('invoices.calendar') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Invoices Calendar</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Users List for Admin -->
                @if (Auth::user()->role->value == \App\Enums\UserRoles::ADMIN->value)
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
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

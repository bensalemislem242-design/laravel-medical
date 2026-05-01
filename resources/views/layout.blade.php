<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SmartHospital')</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Tempusdominus -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Theme -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --text: #1e293b;
            --primary: #2aa9fb;
            --primary-gradient: linear-gradient(135deg, #2aa9fb, #37e1c3);
        }

        body {
            background: var(--bg);
            font-family: "Inter", system-ui, sans-serif;
            color: var(--text);
        }

        .main-sidebar {
            background-color: #ffffff !important;
        }

        .nav-sidebar .nav-link {
            color: var(--text);
            font-weight: 500;
        }

        .nav-sidebar .nav-link.active {
            background: var(--primary);
            color: #fff;
        }

        .brand-link {
            background: none !important;
            border-radius: 0 !important;
            text-align: left;
        }

        .brand-image {
            max-height: 40px;
            margin-right: 10px;
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        h1, h2, h3, h4, h5, h6, p, span, a {
            font-family: "Inter", system-ui, sans-serif;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <!-- Navbar & Sidebar -->
        @includeWhen($includeNavbar ?? true, 'inc._nav_sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper" style="min-height: 100vh;">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 id="Header">@yield('header')</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Control Sidebar -->
    <!--    <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <li class="nav-item">
    <a href="{{ route('invoices.index') }}" class="nav-link">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>Invoices</p>
    </a>
</li> -->



    @include('inc._users_scripts')
</body>

</html>

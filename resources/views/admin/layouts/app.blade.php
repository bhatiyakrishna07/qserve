<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QServe Admin | @yield('title', 'Dashboard')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Nunito', sans-serif; }
        .brand-link { background-color: #e8451e !important; }
        .brand-text { color: white !important; font-weight: 700; font-size: 1.3rem; }
        .sidebar-dark-primary { background-color: #2d2d2d !important; }
        .nav-sidebar .nav-item .nav-link.active { background-color: #e8451e !important; }
        .nav-sidebar .nav-link:hover { background-color: #e8451e33 !important; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .content-header h1 { font-weight: 700; }
    </style>

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle fa-lg"></i>
                    <span class="ml-1">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
            <span class="brand-text">
                <i class="fas fa-utensils mr-2"></i> QServe
            </span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    {{-- Menu Management --}}
                    <li class="nav-header">MENU MANAGEMENT</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Categories</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.food-items.index') }}" class="nav-link {{ request()->routeIs('admin.food-items.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-burger"></i>
                            <p>Food Items</p>
                        </a>
                    </li>

                    {{-- Table Management --}}
                    <li class="nav-header">TABLE MANAGEMENT</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.tables.index') }}" class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chair"></i>
                            <p>Tables & QR Codes</p>
                        </a>
                    </li>

                    {{-- Orders --}}
                    <li class="nav-header">ORDERS</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-receipt"></i>
                            <p>Orders</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    {{-- Content --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">@yield('title', 'Dashboard')</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    {{-- Footer --}}
    <footer class="main-footer text-center">
        <strong>QServe</strong> &copy; {{ date('Y') }} — Restaurant Management System
    </footer>

</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>
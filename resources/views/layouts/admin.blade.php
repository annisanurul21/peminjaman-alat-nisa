<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Peminjaman Alat Nisa</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; overflow-x: hidden; }
        .sidebar { 
            min-height: 100vh; 
            background-color: #2c3e50; 
            color: white; 
            transition: all 0.3s;
        }
        .sidebar a { 
            color: #ecf0f1; 
            text-decoration: none; 
            padding: 12px 15px; 
            display: block; 
            border-radius: 5px;
            margin: 5px 0;
        }
        .sidebar a:hover, .sidebar a.active { 
            background-color: #34495e; 
            color: #3498db; 
        }
        .main-content { padding: 25px; }
        .navbar-admin { 
            background-color: white; 
            border-bottom: 1px solid #dee2e6; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .logout-btn:hover { background-color: #e74c3c !important; color: white !important; }
    </style>
</head>
<body>
    <div class="container-fluid p-0 d-flex">
        <div class="sidebar col-md-2 p-3 d-none d-md-block">
            <h4 class="text-center mb-4 text-info fw-bold">Nisa Alat</h4>
            
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> CRUD Kategori
            </a>
            
            <a href="{{ route('admin.tools.index') }}" class="{{ request()->routeIs('admin.tools.*') ? 'active' : '' }}">
                <i class="fas fa-tools me-2"></i> CRUD Alat
            </a>
            
            <a href="{{ route('admin.loans.index') }}" class="{{ request()->routeIs('admin.loans.index') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list me-2"></i> CRUD Peminjaman
            </a>
            
            <a href="{{ route('admin.loans.history') }}" class="{{ request()->routeIs('admin.loans.history') ? 'active' : '' }}">
                <i class="fas fa-history me-2"></i> Riwayat
            </a>
            
            <hr class="text-secondary">
            
            <a href="#" class="text-danger logout-btn"
               onclick="event.preventDefault(); if(confirm('Yakin ingin keluar?')) document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

        <div class="col-md-10 p-0 flex-grow-1">
            <nav class="navbar navbar-expand navbar-admin p-3 d-flex justify-content-between">
                <span class="navbar-brand mb-0 h1 text-secondary">
                    <i class="fas fa-user-shield me-2"></i> Panel Admin
                </span>
                
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle px-3" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <a class="dropdown-item text-danger" href="#" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               <i class="fas fa-power-off me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

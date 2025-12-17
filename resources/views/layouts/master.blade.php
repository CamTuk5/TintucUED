<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Tin tức đa tác giả - @yield('title', 'Trang chủ')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #f8f9fa; }
        .heat-score { color: #dc3545; font-weight: bold; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .dropdown-item:active { background-color: #0d6efd; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-newspaper me-2"></i>Tin tức đa tác giả
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle me-1"></i> 
                                {{ Auth::user()->name }}
                                @if(Auth::user()->is_vip)
                                    <i class="fa-solid fa-crown text-warning ms-1" title="Thành viên VIP"></i>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-header">Tài khoản</span></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Hồ sơ cá nhân</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-1"></i> Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>

                        <div class="vr bg-secondary mx-1" style="height: 25px;"></div>
                        
                        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success">
                            <i class="fa-solid fa-pen-to-square"></i> Viết bài
                        </a>
                        <a href="{{ route('posts.manage') }}" class="btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-list-check"></i> Bài của tôi
                        </a>

                        @if(Auth::user()->role === 'admin')
                            <div class="vr bg-secondary mx-1" style="height: 25px;"></div>
                            
                            <div class="dropdown">
                                <button class="btn btn-warning btn-sm dropdown-toggle text-dark" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-shield-halved"></i> Quản trị
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Duyệt bài viết</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Quản lý Chuyên mục</a></li>
                                </ul>
                            </div>
                        @endif

                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-user-plus"></i> Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> Vui lòng kiểm tra lại dữ liệu nhập vào.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-dark text-light text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-1 fw-bold">Project Tin tức đa tác giả</p>
            <small class="text-secondary">Xây dựng hệ thống tin tức đa tác giả & thuật toán HeatScore.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
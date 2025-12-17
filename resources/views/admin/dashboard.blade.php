@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-gauge-high me-2"></i>Tổng quan hệ thống</h1>
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">Xem trang chủ</a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2 border-0 border-start border-4 border-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng bài viết</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_posts']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-file-pen fa-2x text-gray-300 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2 border-0 border-start border-4 border-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng Lượt xem</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_views']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-eye fa-2x text-gray-300 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2 border-0 border-start border-4 border-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Thành viên</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-users fa-2x text-gray-300 text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2 border-0 border-start border-4 border-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Cần duyệt ngay</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-bell fa-2x text-gray-300 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">📊 Số lượng bài viết (7 ngày qua)</h6>
            </div>
            <div class="card-body">
                <canvas id="postsChart" style="height: 300px; width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">🍰 Tỷ lệ Chuyên mục</h6>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" style="height: 250px; width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list-check me-2"></i>Danh sách bài viết chờ duyệt</h6>
        @if($pendingPosts->count() > 0)
            <span class="badge bg-danger">{{ $pendingPosts->count() }} bài</span>
        @endif
    </div>
    <div class="card-body">
        @if($pendingPosts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        
                        <th>Ngày gửi</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingPosts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-decoration-none fw-bold">
                                {{ Str::limit($post->title, 50) }} <i class="fa-solid fa-arrow-up-right-from-square small ms-1"></i>
                            </a>
                        </td>
                        <td>{{ $post->author->name }}</td>
                       
                        <td>{{ $post->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm" title="Duyệt bài"><i class="fa-solid fa-check"></i></button>
                            </form>
                            <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn chắc chắn muốn từ chối bài viết này? Tác giả sẽ phải sửa lại.');">
                                @csrf
                            <button type="submit" class="btn btn-danger btn-sm" title="Từ chối - Yêu cầu sửa lại">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="fa-solid fa-mug-hot fa-3x mb-3"></i>
                <p>Tuyệt vời! Không có bài viết nào cần duyệt.</p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxPosts = document.getElementById('postsChart').getContext('2d');
    new Chart(ctxPosts, {
        type: 'bar',
        data: {
            labels: @json($days), 
            datasets: [{
                label: 'Bài viết mới',
                data: @json($postCounts), 
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

  
    const ctxCat = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: @json($catLabels),
            datasets: [{
                data: @json($catData),
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
@endsection
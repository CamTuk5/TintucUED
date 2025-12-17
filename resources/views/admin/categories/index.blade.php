@extends('layouts.master')

@section('title', 'Quản lý Chuyên mục')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h1>📂 Quản lý Chuyên mục</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Quay lại Admin</a>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">Danh sách hiện có</div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên chuyên mục</th>
                            <th>Slug (Đường dẫn)</th>
                            <th>Số bài viết</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $cat)
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td class="fw-bold">{{ $cat->name }}</td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td><span class="badge bg-info">{{ $cat->posts_count }} bài</span></td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-info text-dark me-1">Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Xóa chuyên mục này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">Thêm chuyên mục mới</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tên chuyên mục</label>
                        <input type="text" name="name" class="form-control" placeholder="Ví dụ: Đời sống, Xe cộ..." required>
                        <div class="form-text">Slug sẽ được tạo tự động.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">+ Thêm ngay</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
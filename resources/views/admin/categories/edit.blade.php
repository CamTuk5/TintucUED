@extends('layouts.master')

@section('title', 'Sửa chuyên mục')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark font-weight-bold">
                ✏️ Chỉnh sửa chuyên mục
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label class="form-label">Tên chuyên mục cũ</label>
                        <input type="text" class="form-control" value="{{ $category->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên chuyên mục mới</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        <div class="form-text">Slug đường dẫn sẽ tự động đổi theo.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy bỏ</a>
                        <button type="submit" class="btn btn-warning">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
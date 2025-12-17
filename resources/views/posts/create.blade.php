@extends('layouts.master')

@section('title', 'Viết bài mới')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<div class="card">
    <div class="card-header">Viết bài mới</div>
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control" required placeholder="Nhập tiêu đề bài viết...">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Chuyên mục</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung (Đã tích hợp bộ soạn thảo)</label>
                <textarea id="summernote" name="content" required>
                    <p>Nhập nội dung bài viết tại đây...</p>
                </textarea>
                
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
    <label class="form-label">Chuyên mục</label>
    <select name="category_id" class="form-select">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

                <div class="mb-3">
                    <div class="form-check form-switch p-3 bg-light border rounded">
                        <input class="form-check-input ms-0 me-2" type="checkbox" id="isPremiumSwitch" name="is_premium" value="1">
                        <label class="form-check-label fw-bold text-primary" for="isPremiumSwitch">
                            💎 Đặt là bài viết Premium (Chỉ VIP mới xem được)
                        </label>
                        <div class="form-text mt-1 ms-1">Nếu bật, người dùng thường sẽ bị chặn xem nội dung chi tiết.</div>
                    </div>
                </div>
            
            <button type="submit" class="btn btn-primary">Gửi bài duyệt</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Viết nội dung tại đây...',
            tabsize: 2,
            height: 300, // Chiều cao của khung soạn thảo
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']], // Nút PICTURE để chèn ảnh
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endsection
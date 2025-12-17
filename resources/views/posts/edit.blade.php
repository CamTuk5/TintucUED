@extends('layouts.master')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<div class="card">
    <div class="card-header">Chỉnh sửa bài viết: {{ $post->title }}</div>
    <div class="card-body">
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Chuyên mục</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nội dung</label>
                <textarea name="content" class="form-control" rows="10" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-3">
                    <div class="form-check form-switch p-3 bg-light border rounded">
                        <input class="form-check-input ms-0 me-2" type="checkbox" id="isPremiumSwitch" name="is_premium" value="1"
                        {{ $post->is_premium ? 'checked' : '' }}> <label class="form-check-label fw-bold text-primary" for="isPremiumSwitch">
                            💎 Đặt là bài viết Premium
                        </label>
                        </div>
                </div>
            
            <div class="alert alert-warning">
                Lưu ý: Sau khi sửa, bài viết sẽ chuyển về trạng thái <strong>Chờ duyệt</strong>.
            </div>

            <a href="{{ route('posts.manage') }}" class="btn btn-secondary">Hủy</a>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
</div>
@endsection
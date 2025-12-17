@extends('layouts.master')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bài viết của tôi</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Viết bài mới</a>
</div>

<div class="card">
    <div class="card-body">
        @if($posts->count() > 0)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th style="width: 200px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if($post->status == 'published')
                            <span class="badge bg-success">Đã xuất bản</span>
                        @elseif($post->status == 'pending_review')
                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                        @else
                            <span class="badge bg-secondary">Nháp</span>
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-info text-white">Sửa</a>
                        
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn chắc chắn muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
        @else
            <p class="text-center py-4">Bạn chưa có bài viết nào. Hãy viết bài ngay!</p>
        @endif
    </div>
</div>
@endsection
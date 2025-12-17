@extends('layouts.master')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <h1 class="mb-3">{{ $post->title }}</h1>
        
        <div class="text-muted mb-4 fst-italic border-bottom pb-3">
            <span class="me-3">
                <i class="fa-solid fa-user me-1"></i> {{ $post->author->name }}
            </span>
            <span class="me-3">
                <i class="fa-regular fa-clock me-1"></i> 
            @if($post->published_at)
                {{ $post->published_at->format('d/m/Y H:i') }}
            @else
                <span class="text-warning fw-bold">Đang chờ duyệt</span> 
                <small>({{ $post->created_at->format('d/m/Y H:i') }})</small>
            @endif
            </span>
            <span class="me-3">
                <i class="fa-solid fa-eye me-1"></i> {{ number_format($post->views) }} lượt xem
            </span>
            
            <span class="badge bg-danger">
                🔥 Độ nóng: {{ number_format($post->heat_score, 1) }}
            </span>
        </div>

        <article class="blog-post fs-5">
            @if($post->is_premium && (!Auth::check() || !Auth::user()->is_vip))
        <div class="premium-blur-content">
            {!! Str::limit($post->content, 300) !!}
        </div>
        
        <div class="alert alert-warning text-center shadow p-5 mt-3">
            <h3 class="fw-bold">💎 Bài viết này dành riêng cho VIP</h3>
            <p>Nội dung này chứa kiến thức chuyên sâu và chỉ dành cho thành viên Premium.</p>
            <hr>
            @auth
                <a href="{{ route('subscription.index') }}" class="btn btn-primary btn-lg">Nâng cấp VIP ngay ($10)</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập để nâng cấp</a>
            @endauth
        </div>

        <style>
            .premium-blur-content {
                filter: blur(3px);
                user-select: none;
                opacity: 0.6;
            }
        </style>

            @else
                {!! $post->content !!} 
            @endif

        </article>

        <hr class="my-5">

        <h4>Bình luận ({{ $post->comments->count() }})</h4>
        
        <div class="card bg-light mb-4">
            <div class="card-body">
                @auth
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                        @csrf
                        <textarea name="content" class="form-control" rows="3" placeholder="Chia sẻ ý kiến của bạn..." required></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <button type="submit" class="btn btn-primary mt-2 btn-sm">Gửi bình luận</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        Vui lòng <a href="{{ route('login') }}" class="fw-bold">đăng nhập</a> để tham gia bình luận.
                    </div>
                @endauth
                
                @if($post->comments->count() > 0)
                    @foreach($post->comments as $comment)
                        <div class="d-flex mb-3 border-bottom pb-3">
                            <div class="flex-shrink-0">
                                <img class="rounded-circle" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" 
                                     alt="{{ $comment->user->name }}" 
                                     width="50" height="50">
                            </div>
                            <div class="ms-3 w-100">
                                    <div class="fw-bold">
                                        {{ $comment->user->name }}
                                        @if($comment->user->is_vip)
                                            <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7em;">
                                                <i class="fa-solid fa-crown"></i> VIP
                                            </span>
                                        @endif

                                        <small class="text-muted fw-normal ms-2" style="font-size: 0.8rem">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                <div>{{ $comment->content }}</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">Chưa có bình luận nào. Hãy là người đầu tiên!</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Chuyên mục</div>
            <div class="list-group list-group-flush">
                @if($post->category)
                    <a href="{{ route('categories.show', $post->category->slug) }}" class="list-group-item list-group-item-action active">
                        📂 {{ $post->category->name }}
                    </a>
                @else
                    <span class="list-group-item">Tin tức chung</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
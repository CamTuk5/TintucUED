@extends('layouts.master')

@section('title', 'Trang chủ')

@section('content')

<style>
    .post-thumbnail { height: 200px; object-fit: cover; width: 100%; }
    .hero-thumbnail { height: 350px; object-fit: cover; width: 100%; }
    
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        transition: all 0.3s ease;
    }
    .line-clamp-2 {
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
</style>

@php
    function getFirstImage($html) {
        if (preg_match('/<img.+?src="([^"]*)"/', $html, $matches)) {
            return $matches[1]; 
        }
        return 'https://placehold.co/600x400?text=No+Image'; 
    }
@endphp

<div class="row g-4">
    
 
    <div class="col-lg-8">
        
       
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            @if(isset($category))
                <h2 class="m-0 text-primary">📂 {{ $category->name }}</h2>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary">← Xem tất cả</a>
            @else
                <h2 class="m-0">🔥 Xu hướng (HeatScore)</h2>
            @endif
        </div>

      
        @if($posts->count() > 0)
            @php 
                $heroPost = $posts->first(); 
            @endphp

            <div class="card border-0 shadow-sm mb-5 card-hover overflow-hidden">
                <div class="position-relative">
                    <img src="{{ getFirstImage($heroPost->content) }}" class="hero-thumbnail card-img-top" alt="{{ $heroPost->title }}">
                    
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger rounded-pill py-2 px-3">
                            🔥 Hot: {{ number_format($heroPost->heat_score, 0) }}
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="mb-2 text-muted small">
                        <span class="fw-bold text-primary">{{ $heroPost->category->name ?? 'Tin tức' }}</span> • 
                        {{ $heroPost->published_at->diffForHumans() }} • 
                        Bởi {{ $heroPost->author->name }}
                    </div>
                    
                    <h3 class="card-title fw-bold fs-2">
                        <a href="{{ route('posts.show', $heroPost->slug) }}" class="text-decoration-none text-dark stretched-link">
                            {{ $heroPost->title }}
                        </a>
                    </h3>
                    
                    <p class="card-text text-secondary mt-2">
                        {{ Str::limit(strip_tags($heroPost->content), 200) }}
                    </p>
                </div>
            </div>
        @else
            <div class="alert alert-warning">Chưa có bài viết nào được đăng.</div>
        @endif

   
        <div class="row g-4">
            @foreach($posts->skip(1) as $post)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        
                        <div class="position-relative">
                            <img src="{{ getFirstImage($post->content) }}" class="post-thumbnail card-img-top">
                            <span class="position-absolute bottom-0 start-0 bg-dark text-white px-2 py-1 small opacity-75">
                                {{ $post->category->name ?? 'News' }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold lh-base mb-3">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link line-clamp-2">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            
                            <div class="mt-auto d-flex align-items-center justify-content-between small text-muted border-top pt-3">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=random" 
                                         class="rounded-circle me-2" width="25" height="25">
                                    <span>{{ $post->author->name }}</span>
                                </div>
                                <div class="text-danger fw-bold">
                                    🌡 {{ number_format($post->heat_score, 0) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $posts->links() }} 
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="position-sticky" style="top: 5rem;">
            
            <div class="p-4 mb-3 bg-light rounded shadow-sm border-start border-4 border-primary">
                <h4 class="fst-italic">Về Tin tức đa tác giả</h4>
                <p class="mb-0 text-muted small">Nền tảng tin tức đa chiều, tiên phong ứng dụng công nghệ <strong>HeatScore™</strong> để phân tích và đề xuất nội dung nóng hổi.</p>
            </div>

            <div class="card mb-4 border-0 shadow-sm">
                <img src="https://images2.thanhnien.vn/zoom/686_429/Uploaded/truongnghi/2022_11_01/1-8673.png" class="card-img-top" alt="Quảng cáo">
            </div>

            <div class="p-3">
                <h5 class="font-italic">Kết nối với quản lý nền tảng</h5>
                <ul class="list-unstyled">
                    <li><a href="https://github.com/CamTuk5" class="text-decoration-none">GitHub</a></li>
                    <li><a href="https://www.facebook.com/bao.ngoc.438627" class="text-decoration-none">Facebook</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection
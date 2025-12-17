@extends('layouts.master')

@section('title', 'Nâng cấp VIP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center mb-5">
            <h1 class="fw-bold">💎 Nâng cấp tài khoản VIP</h1>
            <p class="text-muted">Đọc không giới hạn các bài viết Premium chất lượng cao.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal text-muted">Thành viên Thường</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">0đ <small class="text-muted">/ trọn đời</small></h1>
                    
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>✅ Đọc tin tức cơ bản</li>
                        <li>✅ Bình luận bài viết</li>
                        <li class="text-muted text-decoration-line-through">❌ Đọc bài viết Premium</li>
                        <li class="text-muted text-decoration-line-through">❌ Huy hiệu VIP</li>
                        
                    </ul>

                    <button type="button" class="w-100 btn btn-lg btn-outline-secondary" disabled>
                        Đang sử dụng
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow-sm border-primary h-100 border-2 position-relative">
                <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger">
                    Khuyên dùng
                </span>

                <div class="card-header py-3 bg-primary text-white border-primary">
                    <h4 class="my-0 fw-normal">💎 VIP Premium</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">260.000đ <small class="text-muted">/ tháng</small></h1>
                    
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>✅ <strong>Bao gồm quyền lợi Gói Thường</strong></li>
                        <li>✅ <strong>Mở khóa nội dung Premium</strong></li>
                        <li>✅ Huy hiệu VIP 💎 trên Avatar</li>
                        
                        <li class="text-muted small fst-italic mt-2">
                            (*Thanh toán qua PayPal ~ $10 USD)
                        </li>
                    </ul>
                    
                    <form action="{{ route('subscription.paypal') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-100 btn btn-lg btn-primary">
                            <i class="fa-brands fa-paypal"></i> Nâng cấp ngay
                        </button>
                    </form>
                    <small class="d-block mt-2 text-muted text-center">Hoàn tiền nếu không hài lòng trong 7 ngày</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
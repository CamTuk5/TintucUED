<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\SubscriptionController;

// Ai cũng xem được
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bai-viet/{slug}', [HomeController::class, 'show'])->name('posts.show');
Route::get('/bai-viet/{slug}', [HomeController::class, 'show'])->name('posts.show');
Route::get('/chuyen-muc/{slug}', [HomeController::class, 'category'])->name('categories.show');

// cần đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::get('/my-posts', [PostController::class, 'manage'])->name('posts.manage');
    // Tác giả & Admin
    Route::resource('posts', PostController::class)->except(['show', 'index']);
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/goi-vip', [SubscriptionController::class, 'index'])->name('subscription.index');
    // Tạo thanh toán
    Route::post('/thanh-toan/paypal', [SubscriptionController::class, 'createPayment'])->name('subscription.paypal');
    // PayPal trả về
    Route::get('/thanh-toan/thanh-cong', [SubscriptionController::class, 'success'])->name('subscription.success');
    
    
    
    // Chỉ Admin mới vào được
    Route::get('/admin', [DashboardController::class, 'index'])
        ->middleware('can:approve,App\Models\Post') // Dùng Policy đã viết
        ->name('admin.dashboard');
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
        
    Route::post('/admin/approve/{post}', [DashboardController::class, 'approve'])
        ->name('admin.posts.approve');
    Route::post('/posts/{post}/reject', [AdminPostController::class, 'reject'])->name('admin.posts.reject');
});

require __DIR__.'/auth.php';
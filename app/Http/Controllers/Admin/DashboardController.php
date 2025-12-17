<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\ReputationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $reputationService;

    public function __construct(ReputationService $reputationService)
    {
        $this->reputationService = $reputationService;
    }

    public function index()
    {
   
    $stats = [
        'total_posts' => Post::count(),
        'total_views' => Post::sum('views'),
        'total_users' => User::count(),
        'pending_count' => Post::where('status', 'pending_review')->count(),
    ];

    
    $categories = Category::withCount('posts')->get();
    $catLabels = $categories->pluck('name'); 
    $catData = $categories->pluck('posts_count'); 

   
    $days = [];
    $postCounts = [];
    
    // từ 6 ngày trước đến hôm nay
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $days[] = $date->format('d/m');
        
        // Đếm số bài trong ngày đó
        $postCounts[] = Post::whereDate('created_at', $date->format('Y-m-d'))->count();
    }

  
    $pendingPosts = Post::with('author')
        ->where('status', 'pending_review')
        ->orderBy('created_at', 'asc')
        ->get();

    return view('admin.dashboard', compact(
        'stats', 
        'pendingPosts', 
        'catLabels', 
        'catData', 
        'days', 
        'postCounts'
    ));
}

    // duyệt bài
    public function approve(Post $post)
    {
        // Check quyền
        Gate::authorize('approve', Post::class);

        // Cập nhật trạng thái
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Đã duyệt bài viết: ' . $post->title);
    }
}
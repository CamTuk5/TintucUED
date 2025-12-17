<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Events\PostPublished;
use App\Services\ReputationService;
use App\Jobs\CalculateTrendScore;
use Illuminate\Support\Facades\Gate;

class AdminPostController extends Controller
{
    protected $reputationService;

    public function __construct(ReputationService $reputationService)
    {
        $this->reputationService = $reputationService;
    }

    public function approve(Post $post)
    {
        // Kiểm tra quyền
        Gate::authorize('approve', Post::class);

        // Cập nhật trạng thái
        $post->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        $this->reputationService->awardPoints($post->author, 10);

        // Real-time qua webSocket
        PostPublished::dispatch($post);

        // Queue để tính toán lại điểm Heat Score định kỳ
        // Đẩy vào hàng đợi để không làm chậm request
        CalculateTrendScore::dispatch($post)->delay(now()->addHours(1));

        return back()->with('success', 'Đã duyệt bài và thông báo tới độc giả!');
    }

    public function reject(Post $post)
    {
        Gate::authorize('approve', Post::class);

        $post->update([
            'status' => 'draft' 
        ]);

        return back()->with('success', 'Đã từ chối bài viết. Trạng thái chuyển về Nháp.');
    }
}
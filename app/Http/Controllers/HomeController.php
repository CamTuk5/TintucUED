<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy bài đã published, sắp xếp theo Heat Score (Logic độc nhất 1)
        $posts = Post::with('author')
            ->where('status', 'published')
            ->orderByDesc('heat_score') 
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('home.index', compact('posts'));
    }

    public function show($slug)
    {
        // Lấy bài viết (kèm đếm số comment)
        $post = Post::where('slug', $slug)->withCount('comments')->firstOrFail();

        // Tăng view
        $post->increment('views');

        // TÍNH LẠI HEAT SCORE NGAY LẬP TỨC
        // Tính tuổi thọ (giờ)
        $ageInHours = $post->published_at 
            ? Carbon::now()->diffInHours($post->published_at) 
            : 1;
        // Công thức Gravity
        $score = ($post->views + ($post->comments_count * 2)) / pow(($ageInHours + 2), 1.8);
        $post->update(['heat_score' => $score]);

        return view('home.show', compact('post'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->with('author')
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('home.index', compact('posts', 'category'));
    }
}
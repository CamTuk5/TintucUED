<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function manage()
    {
        $posts = Auth::user()->posts()->latest()->paginate(10);
        return view('posts.manage', compact('posts'));
    }

  
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:50', // Yêu cầu tối thiểu 50 ký tự
            'category_id' => 'required|exists:categories,id',
        ]);

        Auth::user()->posts()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_premium' => $request->has('is_premium'),
            'status' => 'pending_review', // Mặc định chờ duyệt
        ]);

        return redirect()->route('posts.manage')->with('success', 'Bài viết đã được tạo và đang chờ duyệt!');
    }


    public function edit(Post $post)
    {
        // Phân quyền: Chỉ tác giả hoặc Admin mới được sửa
        Gate::authorize('update', $post);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_premium' => $request->has('is_premium'),
            'status' => 'pending_review' 
        ]);

        return redirect()->route('posts.manage')->with('success', 'Cập nhật thành công! Bài viết đang chờ duyệt lại.');
    }

   
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.manage')->with('success', 'Đã xóa bài viết.');
    }
}
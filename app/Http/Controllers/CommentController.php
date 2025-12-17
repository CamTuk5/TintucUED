<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:500', // Giới hạn 500 ký tự
        ]);

     
        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        
        return back()->with('success', 'Bình luận đã được đăng!');
    }
}
<?php
namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Chỉ Admin mới được duyệt bài
    public function approve(User $user): bool
    {
        return $user->role === 'admin';
    }

    // Tác giả chỉ được sửa bài của mình khi chưa published
    public function update(User $user, Post $post): bool
    {
        if ($user->role === 'admin') return true;
        
        return $user->id === $post->user_id;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'post_id'];
//Thiết lập rằng một bình luận thuộc về một người dùng (User). Trong cơ sở dữ liệu, Eloquent sẽ tự tìm cột user_id trong bảng comments để kết nối với bảng users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
//Thiết lập rằng một bình luận thuộc về một bài viết (Post). Eloquent sẽ sử dụng cột post_id để biết bình luận này nằm ở bài viết nào.
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
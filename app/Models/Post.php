<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'status', 'heat_score', 'user_id', 'category_id', 'published_at','is_premium',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Eloquent Relationship
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Scope cho query gọn gàng
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function comments()
{
    // Lấy bình luận mới nhất lên đầu
    return $this->hasMany(Comment::class)->latest(); 
}
}
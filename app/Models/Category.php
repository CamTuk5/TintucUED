<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];
// Bấm 1 chuyên mục sẽ hiện tất cả bài viết chuyên mục đó
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}

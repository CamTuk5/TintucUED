<?php

namespace App\Services;

use App\Models\Post;
use Carbon\Carbon;

class TrendingService
{
    public function calculateHeatScore(Post $post): float
    {
        // Công thức: (View + Comment*2) / (Tuổi thọ giờ + 2)^1.8
        $interactions = $post->views + ($post->comments()->count() * 2);
        
        $ageInHours = $post->published_at 
            ? Carbon::now()->diffInHours($post->published_at) 
            : 1;

        // Tránh chia cho 0 và thêm trọng số thời gian
        return $interactions / pow(($ageInHours + 2), 1.8);
    }
}
<?php

namespace App\Services;

class ContentAnalyzer
{
    public function isQualityContent(string $content): bool
    {
        // Logic: Phải > 50 từ (giảm xuống để dễ test) và không được rỗng
        $wordCount = str_word_count(strip_tags($content));
        return $wordCount > 50; 
    }
}
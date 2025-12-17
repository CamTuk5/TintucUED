<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'admin',
        ]);

        // 2. Tạo Tác giả
        $author = User::create([
            'name' => 'Nhà Báo A',
            'email' => 'author@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 'author',
            'reputation_score' => 50,
        ]);

        // 3. Tạo Categories
        $cats = ['Công Nghệ', 'Thể Thao', 'Kinh Tế', 'Giáo Dục'];
        foreach ($cats as $c) {
            Category::create(['name' => $c, 'slug' => Str::slug($c)]);
        }

        // 4. Tạo bài viết mẫu (Giả lập thuật toán Heat Score)
        
        // Bài A: Cũ, nhiều view (Heat thấp dần theo thời gian)
        Post::create([
            'user_id' => $author->id,
            'category_id' => 1,
            'title' => 'iPhone 15 ra mắt năm ngoái',
            'slug' => 'iphone-15-ra-mat',
            'content' => '<p>Nội dung bài viết cũ...</p>',
            'status' => 'published',
            'views' => 1000,
            'heat_score' => 50.5, // Giả định
            'published_at' => now()->subDays(10),
        ]);

        // Bài B: Mới tinh, view trung bình (Heat cao vì mới)
        Post::create([
            'user_id' => $author->id,
            'category_id' => 1,
            'title' => 'Công nghệ AI mới nhất hôm nay',
            'slug' => 'cong-nghe-ai-moi',
            'content' => '<p>Tin nóng hổi vừa thổi vừa ăn...</p>',
            'status' => 'published',
            'views' => 100,
            'heat_score' => 95.0, // Giả định cao hơn bài A
            'published_at' => now()->subHours(2),
        ]);

        // Tạo thêm 10 bài ngẫu nhiên để test phân trang
        for ($i = 1; $i <= 10; $i++) {
            Post::create([
                'user_id' => $author->id,
                'category_id' => rand(1, 4),
                'title' => "Tin tức tổng hợp số $i",
                'slug' => "tin-tuc-tong-hop-$i",
                'content' => "<p>Nội dung mẫu số $i...</p>",
                'status' => 'published',
                'views' => rand(10, 500),
                'heat_score' => rand(10, 80),
                'published_at' => now()->subDays(rand(1, 5)),
            ]);
        }
    }
}
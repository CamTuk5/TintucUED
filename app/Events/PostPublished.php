<?php
namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // Phát trên kênh chung 'news-feed'
    public function broadcastOn(): array
    {
        return [
            new Channel('news-feed'),
        ];
    }
    
    public function broadcastAs(): string
    {
        return 'article.new';
    }
}
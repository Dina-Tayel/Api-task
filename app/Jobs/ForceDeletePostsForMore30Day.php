<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Post\EloquentPost;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use function App\Utitlities\deleteFile;

class ForceDeletePostsForMore30Day implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $eloquentPost;

    public function __construct()
    {
        $this->eloquentPost = new EloquentPost();
    }

    public function handle()
    {
        $posts = $this->eloquentPost->allTrashed();
        foreach ($posts as $post) {
            $days = Carbon::parse($post->created_at)->diffInDays($post->deleted_at);
            if ($days >= 30) {
                deleteFile('posts/' . $post->cover_image);
                $this->eloquentPost->forceDelete($post);
            }
        }
    }
}

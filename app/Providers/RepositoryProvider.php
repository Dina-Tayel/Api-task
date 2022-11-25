<?php

namespace App\Providers;

use App\Repositories\Post\EloquentPost;
use App\Repositories\Post\PostRepository;
use App\Repositories\Tag\EloquentTag;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Tag\TagRepository;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentTag::class , TagRepository::class);
        $this->app->bind(EloquentPost::class , PostRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

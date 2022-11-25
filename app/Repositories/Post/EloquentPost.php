<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Models\Tag;
use App\Repositories\Post\PostRepository;

use function App\Utitlities\deleteFile;

class EloquentPost implements PostRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new Post();
    }
    public function all()
    {
        return $this->model->orderBy('pinned', 'DESC')->get();
    }

    public function allTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }
    public function find($id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function attach($post, $tag_id)
    {
        return $post->tags()->attach($tag_id);
    }

    public function sync($post, $tag_id)
    {
        return  $post->tags()->sync($tag_id);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($post, $data)
    {
        return $post->update($data);
    }

    public function delete($id)
    {
        $post = $this->find($id);
        return $post->delete();
    }

    public function restore($id)
    {
        $post = $this->find($id);
        return $post->restore();
    }

    public function restoreAll()
    {
        return $this->model->onlyTrashed()->restore();
    }
    public function forceDelete($post)
    {
        $post->forceDelete();
    }
}

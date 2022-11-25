<?php 

namespace App\Repositories\Tag ;

use App\Models\Tag;
use App\Repositories\Tag\TagRepository;

class EloquentTag implements TagRepository
{
    public $model ;

    public function __construct(Tag $tag)
    {
        $this->model = $tag ;
    }
    public function all()
    {
        return $this->model->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
        
    }

    public function store($data)
    {
       return $this->model->create($data);
    }

    public function update($id , $data)
    {
        $tag= $this->find($id);
        return $tag->update($data);
    }

    public function delete($id)
    {
        $tag= $this->find($id);
        return $tag->delete();
    }
}
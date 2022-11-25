<?php 

namespace App\Repositories\Post ;

interface PostRepository
{
    public function all();
    public function allTrashed();
    public function find($id);
    public function store($data);
    public function attach($post , $tag_id);
    public function show($id);
    public function update($id , $data);
    public function sync($post , $tag_id);
    public function delete($id);
    public function restore($id);
    public function restoreAll();
    public function forceDelete($post);

}


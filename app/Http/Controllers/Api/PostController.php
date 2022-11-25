<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Http\Resources\PostResource;
use App\Http\Requests\Api\PostRequest;
use App\Jobs\ForceDeletePostsForMore30Day;
use App\Repositories\Post\EloquentPost;
use function App\Utitlities\deleteFile;
use function App\Utitlities\uploadFile;

class PostController extends BaseController
{
    public $eloquentPost;

    public function __construct(EloquentPost $eloquentPost)
    {
        $this->eloquentPost = $eloquentPost;
    }
    public function index()
    {
        $data = PostResource::collection($this->eloquentPost->all());
        return $this->sendResponse('data is recieved successfully', $data);
    }

    public function trashedPosts()
    {
        $data = PostResource::collection($this->eloquentPost->allTrashed());
        return $this->sendResponse('data is recieved successfully', $data);
    }

    public function store(PostRequest $request)
    {
        try {
            $data = $request->except('cover_image', 'tag_id');
            $data['cover_image'] = uploadFile($request->file('cover_image'), 'posts');
            $post = $this->eloquentPost->store($data);
            $this->eloquentPost->attach($post, $request->input('tag_id'));
            return $this->sendResponse('post is creared successfully');
        } catch (Throwable $th) {
            return $this->sendError('something wrong happend , try again please!');
        }
    }
    public function update(PostRequest $request, $id)
    {
        try {
            $post = $this->eloquentPost->find($id);
            // return  Carbon::parse($post->created_at)->diffInDays($post->deleted_at);
            $data = $request->except('cover_image', 'tag_id');
            if (!empty($request->file('cover_image'))) {
                deleteFile('posts/' . $post->cover_image);
                $data['cover_image'] = uploadFile($request->file('cover_image'), 'posts');
            }
            $this->eloquentPost->sync($post, $request->input('tag_id'));
            $this->eloquentPost->update($post, $data);
            return $this->sendResponse('tag is updated successfully');
        } catch (Throwable $th) {
            return $this->sendError('something wrong happend , try again please!');
        }
    }

    public function show($id)
    {
        $post = $this->eloquentPost->show($id);
        if (auth()->id() != $post->user_id)
            return $this->sendError('Unauthenticated', 403);
        $data = PostResource::make($post);
        return $this->sendResponse('data is recieved successfully', $data);
    }

    public function destroy($id)
    {
        $this->eloquentPost->delete($id);
        // dispatch(new ForceDeletePostsForMore30Day());
        return $this->sendResponse('post is deleted successfully');
        
    }
    public function restore($id)
    {
        $this->eloquentPost->restore($id);
        return $this->sendResponse('deleted post are restored successfully');
    }

    public function restoreAll()
    {
        $this->eloquentPost->restoreAll();
        return $this->sendResponse('All deleted posts are restored successfully');
    }
    public function forceDelete($post)
    {
        $post = $this->eloquentPost->find($post);
        deleteFile('posts/' . $post->cover_image);
        $this->eloquentPost->forceDelete($post);
        return $this->sendResponse('post is force deleted successfully');
    }
}

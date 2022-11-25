<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TageResource;
use App\Http\Requests\Api\TagRequest;
use App\Repositories\Tag\EloquentTag;
use App\Http\Controllers\Api\BaseController;

class TagController extends BaseController
{
    public $eloquentTag;

    public function __construct(EloquentTag $eloquentTag)
    {
        $this->eloquentTag = $eloquentTag;
    }
    public function index()
    {
        $data = TageResource::collection($this->eloquentTag->all());
        return $this->sendResponse('data is recieved successfully', $data);
    }

    public function store(TagRequest $rquest)
    {
        try {
            $this->eloquentTag->store($rquest->validated());
            return $this->sendResponse('tag is creared successfully');
        } catch (Throwable $th) {
            return $this->sendError('something wrong happend , try again please!');
        }
    }

    public function update(TagRequest $rquest, $id)
    {
        $this->eloquentTag->update($id, $rquest->validated());
        return $this->sendResponse('tag is updated successfully');
    }

    public function destroy($id)
    {
        $this->eloquentTag->delete($id);
        return $this->sendResponse('tag is deleted successfully');
    }
}

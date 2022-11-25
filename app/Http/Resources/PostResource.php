<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'body'=>$this->body ,
            'cover image'=>asset('storage/posts/'.$this->cover_image),
            'pinned'=>$this->pinned,
            'user'=>auth()->user()->name,
        ];
    }
}

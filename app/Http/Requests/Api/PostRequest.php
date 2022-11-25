<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }

    public function onCreate()
    {
        return [
            'title' => 'required|max:255',
            'body'=>'required|max:255',
            'cover_image'=>'required|image|mimes:png,jpg,jpeg',
            'pinned'=>'nullable|boolean',
            'user_id' => 'required',
            'tag_id'=>'nullable|exists:tags,id', 

        ];
    }

    public function onUpdate()
    {
        return [
            'title' => 'required|max:255',
            'body'=>'required|max:255',
            'cover_image'=>'nullable|image|mimes:png,jpg,jpeg',
            'pinned'=>'nullable|boolean',
            'user_id' => 'required',
            'tag_id'=>'nullable|exists:tags,id', 
        ];

    }

    public function rules()
    {    
        return request()->isMethod('post') ? $this->onCreate() : $this->onUpdate();
    }


}

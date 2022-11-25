<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function onCreate()
    {
        return [
            'name' => 'required|unique:tags,name',
        ];
    }

    public function onUpdate()
    {
        // dd($this->tag , request()->tag);
        return [
            'name' => 'required|unique:tags,name,' . $this->tag,
        ];
    }

    public function rules()
    {
        return request()->isMethod('post') ? $this->onCreate() : $this->onUpdate();
    }
}

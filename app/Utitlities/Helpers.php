<?php

namespace App\Utitlities;

use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadFile')) {
    
    function uploadFile($file, $path)
    {
        if (!$file)
            return null;
        $extension = $file->getClientOriginalExtension();
        $uploade_file = date('d-m-Y') . '-' . time() . '-' . uniqid() . '.' . $extension;
        $file->storeAs($path, $uploade_file);
        return $uploade_file;
    }
}

if (!function_exists('deleteFile')) {

    function deleteFile($path)
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}

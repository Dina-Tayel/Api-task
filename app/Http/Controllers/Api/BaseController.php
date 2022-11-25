<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($message , $data=null)
    {
        $response=[
            'status'=>true ,
            'message'=>$message ,
        ];
        if(! empty($data))
            $response['data']= $data ;
        return response()->json($response , 200);
    }

    public function sendError($message , $errors=null , $code =401)
    {
        $response=[
            'status'=>false,
            'message'=>$message ,
        ];
        if(!empty($errors))
            $response['errors']=$errors;
        return response()->json($response , $code);
    }
}

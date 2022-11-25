<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;

class StatsController extends BaseController
{
    public function index()
    {
        $data=[]; 
        $data['users']=User::count();
        $data['users_with_no_posts'] =User::whereDoesntHave('posts')->count();
        $data['posts']=Post::count();
        return $this->sendResponse('data is recieved successfully' , $data) ;
    }
}

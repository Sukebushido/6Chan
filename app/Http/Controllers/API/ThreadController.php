<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index($boardName, $threadID){
        $thread = Thread::find($threadID)->first();
        $posts = $thread->getPosts();
        $postsJSon = json_encode($thread->getPosts());
        return $postsJSon;
    }
}

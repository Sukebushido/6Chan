<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index($boardName, $postID){
        $post = Post::find($postID);
        $thread = Thread::find($post->getThreadId());
        $postsJSon = json_encode($thread->getPosts());
        return $postsJSon;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Post;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BoardController extends Controller
{
    public function index($boardName)
    {
        $boardId = Board::where(['name' => $boardName])->first()->id;
        $threads = Thread::where(['board_id' => $boardId])->get();
        $totalPosts = [];

        foreach ($threads as $thread) {
            $posts = Post::getAllPostsByThread($thread->id)->get();
            foreach ($posts as $post) {
                $totalPosts[] = $post;
            }
        }

        return view()->exists($boardName) ? view($boardName, ["posts" => $totalPosts]) : Redirect::route("home");
    }
}

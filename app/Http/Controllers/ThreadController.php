<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index($boardName, $threadId, $threadTitle)
    {
        $thread = Thread::where("id", $threadId)->where("title", $threadTitle)->first() ?? abort(404);
        return view("thread", ["thread" => $thread]);
    }
}

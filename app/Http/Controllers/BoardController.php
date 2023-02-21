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
        $boardId = Board::where('name', $boardName)->first()->id;
        $threads = Thread::where('board_id', $boardId)->get();

        return view()->exists($boardName) ? view($boardName, ["threads" => $threads]) : Redirect::route("home");
    }

    public function thread($boardName, $threadId, $threadTitle)
    {
        $threads = Thread::where("id", $threadId)->where("title", $threadTitle)->get();
        // dd($threadId, $threadTitle);
        return view("blue", ["threads" => $threads]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index($boardName){
        $board = Board::where(["name" => $boardName])->first();
        $OPs = $board->getOPs();

        $threads = $board->getThreads()->get();

        foreach ($threads as $thread) {
            dump(count($thread->getPosts()));
        };
        return view('catalog', ["OPs" => $OPs]);
    }
}

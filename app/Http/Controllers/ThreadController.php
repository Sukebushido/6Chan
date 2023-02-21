<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(){
        $thread = Thread::find(1);
        return view("thread", ["thread" => $thread]);
    }
}

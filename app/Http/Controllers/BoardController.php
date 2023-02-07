<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BoardController extends Controller
{
    public function index($boardName){
        
        return view()->exists($boardName)? view($boardName) : Redirect::route("home");
    }
}

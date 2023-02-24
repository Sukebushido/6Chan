<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "name" => 'nullable|string',
            "options" => 'nullable|string',
            "comment" => 'required',
            "captcha" => 'nullable',
            "file" => 'nullable'
        ]);

        return "kek";
    }
}

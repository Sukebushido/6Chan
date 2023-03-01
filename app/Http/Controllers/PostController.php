<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "threadId" => Rule::exists('threads', 'id'),
            "name" => 'nullable',
            "options" => 'nullable',
            "comment" => 'required',
            "captcha" => 'nullable',
            "file" => 'nullable'
        ], [
            "comment.required" => "You must at least post a comment with your reply",
            "threadId" => "Wrong thread Id"
        ]);

        try {
            true;
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'error',
                'errors' => $e->errors()
            ], 422);
        }
        return response()->json($request->all());
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostPivot;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            DB::beginTransaction();
            $currentPost = Post::create([
                "title" => $request->name,
                "content" => $request->comment,
                "author" => "Anonymous",
                "thread_id" => $request->threadId
            ]);

            $quoteRegex = "/(>{2}[0-9]+)\b/";
            if (preg_match($quoteRegex, $request->comment)) {
                preg_match_all($quoteRegex, $request->comment, $matches);
                $rawPostIDs = $matches[0];

                foreach ($rawPostIDs as $rawPostID) {
                    $postID = substr($rawPostID, 2);
                    PostPivot::create([
                        "parent_id" => $postID,
                        "child_id" => $currentPost->id
                    ]);
                }

            } else {

            }
            DB::commit();
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

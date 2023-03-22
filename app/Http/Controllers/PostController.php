<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use App\Models\Thread;
use App\Models\PostPivot;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "threadId" => Rule::exists('threads', 'id'),
            "comment" => 'required',
            "image" => 'nullable|image|mimes:jpg,png,jpeg,gif,svg'
        ], [
            "comment.required" => "You must at least post a comment with your reply",
            "threadId" => "Wrong thread Id",
            "image.mimes" => "Wrong image format"
        ]);

        DB::beginTransaction();
        try {

            if($request->file('image')){
                $imagePath = $request->file('image')->storeAs($request->threadId, uniqid() . "." . $request->file('image')->extension(), 'public');
                $image = Image::create([
                    'image' => $imagePath,
                    'name' => basename($imagePath)
                ]);
            }

            $currentPost = Post::create([
                "title" => $request->name,
                "content" => $request->comment,
                "author" => "Anonymous",
                "thread_id" => $request->threadId,
                "image_id" => $image->id ?? NULL
            ]);



            $quoteRegex = "/(>{2}[0-9]+)\b/";
            $greentextRegex = "/^>[^>\n]+$/m";

            // Handle greentexts
            if (preg_match($greentextRegex, $request->comment)) {
                preg_match_all($greentextRegex, $request->comment, $matches);
                $greentextLines = $matches[0];

                foreach ($greentextLines as $greentextLine) {
                    $newcontent = str_replace($greentextLine, "<span class='greentext'>" . $greentextLine . "</span>", $currentPost->content);
                    $currentPost->content = $newcontent;
                    $currentPost->save();
                }
            }

            // Handle quotes
            if (preg_match($quoteRegex, $request->comment)) {
                preg_match_all($quoteRegex, $request->comment, $matches);
                $rawPostIDs = $matches[0];

                // Need to find if quoted post in current Thread or Not

                foreach ($rawPostIDs as $rawPostID) {
                    $postID = substr($rawPostID, 2);
                    $relatedPost = Post::find($postID);
                    $newcontent = "";
                    // Add arrow to quote if CrossThread
                    if ($relatedPost->thread_id != $request->threadId) {
                        $newcontent = str_replace($rawPostID, "<a href='#p" . $postID . "' class='quotelink'>" . $rawPostID . " →</a>", $currentPost->content);
                        // Add OP to quote if OP    
                    } else if ($relatedPost->OP) {
                        $newcontent = str_replace($rawPostID, "<a href='#p" . $postID . "' class='quotelink'>" . $rawPostID . " (OP)</a>", $currentPost->content);
                    } else {
                        $newcontent = str_replace($rawPostID, "<a href='#p" . $postID . "' class='quotelink'>" . $rawPostID . "</a>", $currentPost->content);
                    }
                    $currentPost->content = $newcontent;
                    $currentPost->save();


                    // HTML directement dans le plaintext
                    PostPivot::create([
                        "parent_id" => $postID,
                        "child_id" => $currentPost->id
                    ]);
                }
            }
            DB::commit();
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'msg' => 'error',
                'errors' => $e->errors()
            ], 422);
            DB::rollback();
        }
        return response()->json($request->all());
    }
}

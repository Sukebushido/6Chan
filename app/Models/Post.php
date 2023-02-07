<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        // img,
        "OP",
        "content"
    ];

    protected function getAllPostsByThread(int $threadId){
        $posts = Post::where(["thread_id" => $threadId]);
        return $posts;
    }
}

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

    // protected function getAllPostsByThread(int $threadId){
    //     $posts = Post::where(["thread_id" => $threadId]);
    //     return $posts;
    // }

    public function getThread()
    {
        return $this->belongsTo(Thread::class, 'thread_id', 'id')->first();
    }

    public function getBoard()
    {
        return $this->getThread()->getBoard();
    }
    
    public function getBoardId()
    {
        return $this->getThread()->getBoard()->id;
    }

    public function getBoardName()
    {
        return $this->getBoard()->name;
    }

    public function getThreadId()
    {
        return $this->getThread()->id;
    }

    public function getThreadTitle()
    {
        return $this->getThread()->title;
    }

}

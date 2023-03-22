<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        "OP",
        "content",
        "thread_id",
        "image_id"
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

    // Many to many test

    public function parent(): BelongsToMany{
        return $this->belongsToMany(Post::class, "post_pivot", "child_id", "parent_id");
    }

    public function children(): BelongsToMany{
        return $this->belongsToMany(Post::class, "post_pivot", "parent_id", "child_id");
    }

    // Evite de récupérer les quotes d'une autre thread / board
    
    public function trueChildren(){
        return $this->children()->where(["thread_id"=>$this->getThreadId()]);
    }

}

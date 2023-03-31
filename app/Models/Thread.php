<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        "has_title",
        "board_id",
        "title"
    ];

    public function getPosts()
    {
        return $this->hasMany(Post::class, 'thread_id')->get();
    }

    public function getBoard()
    {
        return $this->belongsTo(Board::class, 'board_id', 'id')->first();
    }

    public function getBoardName()
    {
        return $this->getBoard()->name;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        "board"
    ];

    public function getPosts()
    {
        return $this->hasMany(Post::class, 'thread_id')->get();
    }

    public function getBoard(){
        return $this->belongsTo(Board::class, 'board_id', 'id')->first();
    }
}

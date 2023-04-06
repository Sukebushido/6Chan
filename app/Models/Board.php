<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    public function getThreads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function getOPs()
    {
        $threads = $this->getThreads()->where(['board_id' => $this->id])->get();
        $OPs = [];

        foreach ($threads as $thread) {
            $OPs[] = Post::where(['thread_id' => $thread->id], ['OP' => true])->first();
        };
        
        return $OPs;
    }

    protected $fillable = [
        "name"
    ];
}

// public function getOPs()
//     {
//         $threads = $this->getThreads()->where(['board_id' => $this->id])->get();
//         $OPs = [];

//         foreach ($threads as $thread) {
//             $OPs[] = Post::where(['thread_id' => $thread->id], ['OP' => true])->get();
//         };
        
//         return $OPs;
//     }

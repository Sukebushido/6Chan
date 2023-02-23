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
        $threadsIDs = [];

        foreach ($threads as $thread) {
            $threadsIDs[] = $thread->id;
        };

        $OPs = Post::find($threadsIDs);
        
        return $OPs;
    }

    protected $fillable = [
        "name"
    ];
}

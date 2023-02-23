<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function getOPs()
    {
        $threads = Thread::where(['board_id' => $this->id])->get();
        $threadsIDs = [];

        foreach ($threads as $thread) {
            $threadsIDs[] = $thread->id;
        };

        $OPs = Post::find($threadsIDs);
        
        // dd($OPs);
        return $OPs;
        // return Post::where(["OP" => true])->get();
    }

    public function getCurrentID()
    {
        return $this->id;
    }

    protected $fillable = [
        "name"
    ];
}

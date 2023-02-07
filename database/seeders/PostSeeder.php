<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                "thread_id" => 1,
                "title" => "I'm so sad",
                "content" => "I'm so sad, what do",
                "OP" => true
            ],
            [
                "thread_id" => 1,
                "content" => "Just lift faggot",
            ],
            [
                "thread_id" => 1,
                "content" => "FPBP",
            ],
            [
                "thread_id" => 4,
                "content" => "Wake up, you see this, what do",
                "OP" => true
            ],
            [
                "thread_id" => 4,
                "content" => "Run",
            ],
            [
                "thread_id" => 4,
                "content" => "This mf gets it",
            ],
            [
                "thread_id" => 7,
                "title" => "Hello",
                "author" => "NameFagging",
                "content" => "I paid for 6Chan gold",
                "OP" => true
            ],
            [
                "thread_id" => 7,
                "content" => "Imagine namefagging in 2023",
            ],
        ];

        foreach($posts as $post){
            Post::create($post);
        }
    }
}

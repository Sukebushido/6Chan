<?php

namespace Database\Seeders;

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
                "thread" => 1,
                "title" => "I'm so sad",
                "content" => "I'm so sad, what do",
                "OP" => true
            ],
            [
                "thread" => 1,
                "content" => "Just lift faggot",
            ],
            [
                "thread" => 1,
                "content" => "FPBP",
            ],
            [
                "thread" => 4,
                "content" => "Wake up, you see this, what do",
                "OP" => true
            ],
            [
                "thread" => 4,
                "content" => "Run",
            ],
            [
                "thread" => 4,
                "content" => "This mf gets it",
            ],
            [
                "thread" => 7,
                "title" => "Hello",
                "author" => "NameFagging",
                "content" => "I paid for 6Chan gold",
            ],
            [
                "thread" => 7,
                "content" => "Imagine namefagging in 2023",
            ],
        ];
    }
}

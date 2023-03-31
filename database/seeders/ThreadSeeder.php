<?php

namespace Database\Seeders;

use App\Models\Thread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = [
            [
                "id" => 1,
                "has_title" => true,
                "title" => "im-so-sad",
                "board_id" => 1
            ],
            [
                "id" => 4,
                "has_title" => false,
                "title" => "wake-up-you-see-this-what-do",
                "board_id" => 1
            ],
            [
                "id" => 20,
                "has_title" => true,
                "title" => "hello",
                "board_id" => 1
            ]
        ];

        foreach($threads as $thread){
            Thread::create($thread);
        }
    }
}

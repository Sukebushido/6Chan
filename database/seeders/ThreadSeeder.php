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
                "board_id" => 1
            ],
            [
                "id" => 4,
                "board_id" => 1
            ],
            [
                "id" => 7,
                "board_id" => 2
            ]
        ];

        foreach($threads as $thread){
            Thread::create($thread);
        }
    }
}

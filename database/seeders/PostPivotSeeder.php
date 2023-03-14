<?php

namespace Database\Seeders;

use App\Models\PostPivot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postPivots = [
            [
                "parent_id" => 5,
                "child_id" => 19
            ],
            [
                "parent_id" => 11,
                "child_id" => 19
            ],
            ];

        foreach ($postPivots as $postPivot) {
            PostPivot::create($postPivot);
        }
    }
}

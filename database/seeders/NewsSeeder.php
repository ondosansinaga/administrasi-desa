<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('news')->insert([
            'title' => 'title',
            'content' => 'content',
            'creator_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}

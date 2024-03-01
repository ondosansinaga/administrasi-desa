<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'nik' => '1',
            'username' => 'admin',
            'password' => 'admin',
            'name' => 'admin',
            'job_title' => 'admin',
            'gender' => true,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'nik' => '2',
            'username' => 'admin2',
            'password' => 'admin2',
            'name' => 'admin2',
            'job_title' => 'admin',
            'gender' => true,
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'nik' => '3',
            'username' => 'ada',
            'password' => 'ada',
            'name' => 'ada',
            'job_title' => 'programmer',
            'gender' => true,
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 2,
            'updated_by' => 2,
        ]);
    }
}

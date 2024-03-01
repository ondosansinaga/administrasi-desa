<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('letters')->insert([
            'id' => 1,
            'title' => 'surat keterangan usaha',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 2,
            'title' => 'surat keterangan tidak mampu',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 3,
            'title' => 'surat pengantar skck',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 4,
            'title' => 'surat keterangan pindah domisili',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 5,
            'title' => 'surat keterangan jual beli',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 6,
            'title' => 'surat permohonan kartu keluarga',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('letters')->insert([
            'id' => 7,
            'title' => 'surat permohonan KTP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

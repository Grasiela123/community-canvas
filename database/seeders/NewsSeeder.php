<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert([
            [
                'id' => '1',
                'user_id' => '3',
                'title' => 'Kecelakaan',
                'description' => 'Hari ini terjadi kecelakaan',
                'picture' => '',
                'date_made' => '2024-05-31 08:00:00',
                'picture' => '',
            ]
        ]);
    }
}

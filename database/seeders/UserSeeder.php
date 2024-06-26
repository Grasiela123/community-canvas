<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'address' => 'BSD',
                'password' => bcrypt('Admin123'),
                'picture' => '',
                'role' => 'admin',
            ]
        ]);
        DB::table('users')->insert([
            [
                'id' => '2',
                'username' => 'user',
                'email' => 'user@user.com',
                'address' => 'Gading Serpong',
                'password' => bcrypt('User123'),
                'picture' => '',
            ]
        ]);
    }
}

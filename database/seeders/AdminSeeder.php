<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'lastname' => 'Admin_lastname',
            'username' => 'Admin_username',
            'email' => 'admin@clinictlemcen.com',
            'role' => 2,
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            'name' => 'Bimal Adhikari',
            'email' => 'bimaladhikari8158@gmail.com',
            'password' => Hash::make('00000000'),
            'role_id' => 1,
        ]);
    }
}

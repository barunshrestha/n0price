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
            'approval_status' => 1,
            'email_verified_at' => '2022-09-19',
        ]);
        DB::table('users')->insert([
            'name' => 'Bimal Adhikari 2',
            'email' => 'bimaladhikari81582@gmail.com',
            'password' => Hash::make('00000000'),
            'role_id' => 1,
            'approval_status' => 1,
            'email_verified_at' => '2022-09-19',
        ]);
        DB::table('users')->insert([
            'name' => 'Bimal Adhikari 3',
            'email' => 'bimaladhikari81583@gmail.com',
            'password' => Hash::make('00000000'),
            'role_id' => 1,
            'approval_status' => 1,
            'email_verified_at' => '2022-09-19',
        ]);
    }
}

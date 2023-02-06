<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //930d9bf891352d14b3c8863ba1c34e30eaae17fa6ee0173addbed42588c8
        User::create([
            'name' => 'Jose',
            'last_name' => 'Rodriguez',
            'email' => 'jose@gmail.com',
            'user_token' => 'eb7fe35c630e720b8bb4fce514b6fb5d359c213081a7af422f293a509110',
            'id_socket' => 'eb7fe35c630e720b8bb4fce514b6fb',
            'socket_room' => '59c213081a7af422',
            'password' => Hash::make('12345678'),
            'hash_validate_email' => 'edfefe648',
            'email_verified_at' => '2022-12-14 11:32:51'
        ]);

        /* User::create([
            'name' => 'Joaquin',
            'last_name' => 'Robles',
            'email' => 'joaquin@gmail.com',
            'password' => Hash::make('12345678'),
            'hash_validate_email' => 'drgedfefe648',
            'email_verified_at' => '2022-12-14 11:32:51'
        ]); */
    }
}

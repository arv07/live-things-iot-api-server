<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DeviceAvailablesSeeder;
use Database\Seeders\UserSeeder;

class IndustriaCodeIOTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan migrate:fresh --seeder=IndustriaCodeIOTSeeder
        $this->call(DeviceAvailablesSeeder::class);
        //$this->call(UserSeeder::class);
    }
}

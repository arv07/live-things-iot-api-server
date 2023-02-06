<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $seller = Role::create(['name' => 'vendedor']);

        Permission::create(['name' => 'sales.index']);
        Permission::create(['name' => 'sales.create']);
        Permission::create(['name' => 'sales.update']);
        Permission::create(['name' => 'sales.delete']);

        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.update']);

        Permission::create(['name' => 'invoices.index']);
        Permission::create(['name' => 'invoices.update']);
        Permission::create(['name' => 'invoices.delete']);

        Permission::create(['name' => 'products.index']);
        Permission::create(['name' => 'products.create']);
        Permission::create(['name' => 'products.update']);
        Permission::create(['name' => 'products.delete']);

        Permission::create(['name' => 'detailProducts.index']);
        Permission::create(['name' => 'detailProducts.create']);
        Permission::create(['name' => 'detailProducts.update']);
        Permission::create(['name' => 'detailProducts.delete']);

        Permission::create(['name' => 'warehouse.index']);
        Permission::create(['name' => 'warehouse.create']);
        Permission::create(['name' => 'warehouse.update']);
        Permission::create(['name' => 'warehouse.delete']);


        

        
    
        
    }
}

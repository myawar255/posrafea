<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserManagement\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating New Permissions
        $permissions = [
            // User Management Permissions
            ['name'=>'User Management|Users|Create', 'key'=>'create-user'],
            ['name'=>'User Management|Users|View', 'key'=>'view-user'],
            ['name'=>'User Management|Users|Update', 'key'=>'update-user'],
            ['name'=>'User Management|Users|Delete', 'key'=>'delete-user'],
            ['name'=>'User Management|Roles|Create', 'key'=>'create-role'],
            ['name'=>'User Management|Roles|View', 'key'=>'view-role'],
            ['name'=>'User Management|Roles|Update', 'key'=>'update-role'],
            ['name'=>'User Management|Roles|Delete', 'key'=>'delete-role'],
            ['name'=>'Catalogue Management|Stock Unit|Create', 'key'=>'create-stock-unit'],
            ['name'=>'Catalogue Management|Stock Unit|View', 'key'=>'view-stock-unit'],
            ['name'=>'Catalogue Management|Stock Unit|Update', 'key'=>'update-stock-unit'],
            ['name'=>'Catalogue Management|Stock Unit|Delete', 'key'=>'delete-stock-unit'],
            ['name'=>'Stock|Create', 'key'=>'create-stock'],
            ['name'=>'Stock|View', 'key'=>'view-stock'],
            ['name'=>'Stock|Update', 'key'=>'update-stock'],
            ['name'=>'Stock|Delete', 'key'=>'delete-stock'],
            ['name'=>'product|Create', 'key'=>'create-product'],
            ['name'=>'product|View', 'key'=>'view-product'],
            ['name'=>'product|Update', 'key'=>'update-product'],
            ['name'=>'product|Delete', 'key'=>'delete-product'],
        ];
        Permission::insert($permissions);
    }
}

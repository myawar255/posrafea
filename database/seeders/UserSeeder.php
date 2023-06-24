<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserManagement\Role;
use App\Models\User;
use App\Models\UserManagement\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "Super Admin";
        $role->save();

        $superadmin = config('app.superadmin');
        $user = new User();
        $user->name = $superadmin["name"];
        $user->email = $superadmin["email"];
        $user->password = bcrypt('12345678');
        $user->save();

        $user_role = new UserRole();
        $user_role->user_id = $user->id;
        $user_role->role_id = $role->id;
        $user_role->save();
    }
}

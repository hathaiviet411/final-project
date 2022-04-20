<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::first()) {
            $user = User::create([
                'user_code' => 111111,
                'password' => '123456789',
                'user_name' => 'Super Admin',
                'department_id' => 1,
            ]);

            $role = Role::findByName(ROLE_ADMIN, 'api');
            $user->syncRoles($role);

            $user = User::create([
                'user_code' => 222222,
                'password' => '123456789',
                'user_name' => 'Manager',
                'department_id' => 2,
            ]);

            $role = Role::findByName(ROLE_MANAGER, 'api');
            $user->syncRoles($role);

            $user = User::create([
                'user_code' => 666666,
                'password' => '123456789',
                'user_name' => 'Staff',
                'department_id' => 3,
            ]);

            $role = Role::findByName(ROLE_STAFF, 'api');
            $user->syncRoles($role);
        }
    }
}

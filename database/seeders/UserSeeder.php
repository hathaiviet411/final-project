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
                'user_name' => 'Super Admin',
                'user_code' => 111111,
                'password' => '123456789',
                'email' => 'superadmin@gmail.com',
                'dob' => '2000-04-11',
                'participated_date' => '2022-01-01',
                'address' => '39 Tokyo, No Man Stand Street St. 391',
                'phone_number' => '0341239182',
                'is_retired' => 0,
                'avatar' => '',
                'department_id' => 1,
                'position_id' => 1,
                'contract_id' => 1,
            ]);

            $role = Role::findByName(ROLE_ADMIN, 'api');
            $user->syncRoles($role);

            $user = User::create([
              'user_name' => 'Manager',
              'user_code' => 222222,
              'password' => '123456789',
              'email' => 'manager@gmail.com',
              'dob' => '2000-04-11',
              'participated_date' => '2022-01-01',
              'address' => '39 Tokyo, No Man Stand Street St. 391',
              'phone_number' => '0341239182',
              'is_retired' => 0,
              'avatar' => '',
              'department_id' => 2,
              'position_id' => 12,
              'contract_id' => 2,
            ]);

            $role = Role::findByName(ROLE_MANAGER, 'api');
            $user->syncRoles($role);

            $user = User::create([
              'user_name' => 'Staff',
              'user_code' => 333333,
              'password' => '123456789',
              'email' => 'staff@gmail.com',
              'dob' => '2000-04-11',
              'participated_date' => '2022-01-01',
              'address' => '39 Tokyo, No Man Stand Street St. 391',
              'phone_number' => '0341239182',
              'is_retired' => 1,
              'avatar' => '',
              'department_id' => 3,
              'position_id' => 5,
              'contract_id' => 1,
            ]);

            $role = Role::findByName(ROLE_STAFF, 'api');
            $user->syncRoles($role);
        }
    }
}

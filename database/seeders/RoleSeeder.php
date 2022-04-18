<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::first()) {
            Role::insert([
                ['name' => ROLE_ADMIN, 'guard_name' => 'api'],
                ['name' => ROLE_MANAGER, 'guard_name' => 'api'],
                ['name' => ROLE_STAFF, 'guard_name' => 'api'],
            ]);
        }
    }
}

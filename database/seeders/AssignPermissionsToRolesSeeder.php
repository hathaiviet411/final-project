<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignPermissionsToRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName(ROLE_ADMIN, 'api');
        if ($role) {
            // This system do not require any permission
        }

        $role = Role::findByName(ROLE_MANAGER, 'api');
        if ($role) {
          // This system do not require any permission
        }

        $role = Role::findByName(ROLE_STAFF, 'api');
        if ($role) {
          // This system do not require any permission
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'department_name' => 'Ban Lễ Tân',
            'department_address' => 'Toà A',
            'department_manager' => 0,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Ban Quản L',
            'department_address' => 'Toà B',
            'department_manager' => 1,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Ban Vệ Sinh',
            'department_address' => 'Toà C',
            'department_manager' => 2,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);
    }
}



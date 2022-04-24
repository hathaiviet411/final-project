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
            'user_id' => 0,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Ban Quản Lý',
            'department_address' => 'Toà B',
            'user_id' => 1,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Ban Vệ Sinh',
            'department_address' => 'Toà C',
            'user_id' => 2,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);
    }
}



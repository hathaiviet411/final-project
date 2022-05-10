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
            'department_name' => 'Bộ Phận Lễ Tân',
            'department_address' => 'Toà A',
            'user_id' => 0,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Bộ Phận Quản Lý',
            'department_address' => 'Toà B',
            'user_id' => 1,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Bộ Phận Vệ Sinh',
            'department_address' => 'Toà C',
            'user_id' => 2,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Bộ Phận Bếp',
            'department_address' => 'Toà D',
            'user_id' => 0,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Bộ Phận Kỹ Thuạt',
            'department_address' => 'Toà E',
            'user_id' => 1,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);

        Department::create([
            'department_name' => 'Bộ Phận Tài Chính - Kế Toán',
            'department_address' => 'Toà F',
            'user_id' => 2,
            'total_staff' => 0,
            'organized_date' => '2020-01-01',
        ]);
    }
}



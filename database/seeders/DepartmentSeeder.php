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
        $listDepartmentName = [
            'Ban Lễ Tân',
            'Ban Quản Lí',
            'Ban Vệ Sinh'
        ];

        foreach ($listDepartmentName as $key => $department_name) {
            $check = Department::where('department_name', $department_name)->first();

            if (!$check) {
                Department::create([
                    'department_name' => $department_name,
                    'department_address' => $department_name,
                    'department_manager' => 0
                ]);
            }
        }
    }
}



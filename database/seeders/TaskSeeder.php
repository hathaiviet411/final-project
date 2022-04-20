<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Task::create([
      'task_name' => 'Nhập liệu',
      'task_description' => 'Nhập dữ liệu vào bảng tổ chức',
      'required_position' => 1,
      'required_contract_type' => 1,
    ]);

    Task::create([
      'task_name' => 'Thay ga giường',
      'task_description' => 'Thay ga giường ở phòng 301 - toà C',
      'required_position' => 2,
      'required_contract_type' => 0,
    ]);

    Task::create([
      'task_name' => 'Tiếp khách',
      'task_description' => 'Tiếp khách ở toà D',
      'required_position' => 3,
      'required_contract_type' => 1,
    ]);
  }
}

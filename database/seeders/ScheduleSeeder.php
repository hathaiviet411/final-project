<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Schedule::create([
      'contract_type' => 1,
      'department_id' => 1,
      'id' => 1,
      'position_id' => 1,
      'role_id' => 1,
      'schedules' => json_encode([]),
      'user_id' => 1,
      'user_name' => "Meo Mat Trang",
    ]);

    Schedule::create([
      'contract_type' => 2,
      'department_id' => 2,
      'id' => 2,
      'position_id' => 2,
      'role_id' => 2,
      'schedules' => json_encode([]),
      'user_id' => 2,
      'user_name' => "Meo Hac Am",
    ]);

    Schedule::create([
      'contract_type' => 1,
      'department_id' => 3,
      'id' => 3,
      'position_id' => 3,
      'role_id' => 3,
      'schedules' => json_encode([]),
      'user_id' => 3,
      'user_name' => "Meo Cong Chua",
    ]);

    Schedule::create([
      'contract_type' => 2,
      'department_id' => 4,
      'id' => 4,
      'position_id' => 4,
      'role_id' => 2,
      'schedules' => json_encode([]),
      'user_id' => 4,
      'user_name' => "Meo Chim Sau",
    ]);

    Schedule::create([
      'contract_type' => 1,
      'department_id' => 5,
      'id' => 5,
      'position_id' => 5,
      'role_id' => 1,
      'schedules' => json_encode([]),
      'user_id' => 5,
      'user_name' => "Meo Thu Linh",
    ]);

    Schedule::create([
      'contract_type' => 2,
      'department_id' => 6,
      'id' => 6,
      'position_id' => 6,
      'role_id' => 2,
      'schedules' => json_encode([]),
      'user_id' => 6,
      'user_name' => "Meo See Tinh",
    ]);
  }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Facility::create([
      'facility_title' => 'Tủ lạnh',
      'facility_detail' => 'Tủ lạnh phòng bếp',
      'user_id' => 1,
      'start_date' => '2022-04-18',
      'end_date' => '2022-04-20',
      'status' => 1,
    ]);

    Facility::create([
      'facility_title' => 'Đường dân điện',
      'facility_detail' => 'Đường dây điện phòng 310 Toà C',
      'user_id' => 1,
      'start_date' => '2022-04-18',
      'end_date' => '2022-04-20',
      'status' => 1,
    ]);
  }
}

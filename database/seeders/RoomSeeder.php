<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Room::create([
      'room_number' => 302,
      'building_id' => 1,
      'room_type' => 1,
      'room_capacity' => 2,
      'level' => 3,
      'room_information' => 'Phòng nhìn ra biển',
      'room_status' => 1,
    ]);

    Room::create([
      'room_number' => 202,
      'building_id' => 1,
      'room_type' => 2,
      'room_capacity' => 1,
      'level' => 2,
      'room_information' => 'Phòng nhìn lên núi',
      'room_status' => 0,
    ]);
  }
}

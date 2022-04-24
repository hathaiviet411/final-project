<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Building::create([
            'building_name' => 'Toà A',
        ]);

        Building::create([
            'building_name' => 'Toà B',
        ]);

        Building::create([
            'building_name' => 'Toà C',
        ]);

        Building::create([
            'building_name' => 'Toà D',
        ]);

        Building::create([
            'building_name' => 'Toà E',
        ]);
    }
}



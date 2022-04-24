<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Contract::create([
      'contract_type' => 'FULL_TIME',
      'contract_duration' => '2 year',
    ]);

    Contract::create([
      'contract_type' => 'PART_TIME',
      'contract_duration' => '5 months',
    ]);
  }
}

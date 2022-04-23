<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    $listPosition = [
      'GENERAL_MANAGER',
      'DEPUTY_GENERAL_MANAGER',
      'ROOMS_DIVISION_MANAGER',
      'FRONT_DESK_MANAGER',
      'HOUSEKEEPING_MANAGER',
      'FB_MANAGER',
      'SALES_MARKETING_MANAGER',
      'ACCOUNTING_MANAGER',
      'HR_MANAGER',
      'ADMINISTRATION_MANAGER',
      'ENGINEERING_MANAGER',
      'RECEPTIONIST',
      'RESERVATION',
      'CASHIER',
      'CONCIERGE',
      'BELLMAN',
      'DOORMAN',
      'HOUSEKEEPING',
      'LAUNDRY',
      'LINEN_ROOM',
      'GARDENER',
      'PEST_CONTROL',
      'PUBLIC_AREA_CLEANER',
      'BABY_SITTER',
      'LOCKER_ATTENDANT',
      'CHEF',
      'COOK_ASSISTANT',
      'BAKERY',
      'STEWARD',
      'WAITRESS',
      'HOSTESS',
      'ORDER_TAKER',
      'FOOD_RUNNER',
      'EVENT_STAFF',
      'BARTENDER',
      'BARISTA',
      'MARKETING',
      'PR',
      'SALES_CORP',
      'SALES_TOUR',
      'SALES_ONLINE',
      'GENERAL_ACCOUNTANT',
      'DEBT_ACCOUNTANT',
      'AUDITOR',
      'CASH_KEEPER',
      'PURCHASER',
      'PAYROLL',
      'INSURANCE',
      'LEGAL_OFFICER',
      'ELECTRICAL_ENGINEER',
      'PLUMBER',
      'CARPENTER',
      'PAINTER',
      'AC_CHILLER',
      'BOILER',
      'IT_MAN',
      'RESCUER',
      'SECURITY',
      'STORE_KEEPER',
    ];

    foreach ($listPosition as $key => $position) {
      Position::create([
        'position_name' => $position,
      ]);
    }
  }
}

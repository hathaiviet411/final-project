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
      // Leader, Manager
      'General_Manager',
      'Deputy_General_Manager',
      'Rooms_Division_Manager',
      'Front_Desk_Manager',
      'Housekeeping_Manager',
      'FB_Manager',
      'Sales_Marketing_Manager',
      'Accounting_Manager',
      'HR_Manager',
      'Administration_Manager',
      'Engineering_Manager',
      // Front Desk Department
      'Receptionist',
      'Reservation',
      'Cashier',
      'Concierge',
      'BellMan',
      'DoorMan',
      // Housekeeping Department
      'Housekeeping',
      'Laundry',
      'Linen_Room',
      'Gardener',
      'Pest_Control',
      'Public_Area_Cleaner',
      'Baby_Sitter',
      'Locker_Attendant',
      // Chef Department
      'Chef',
      'Cook_Assistant',
      'Bakery',
      'Steward',
      'Waitress',
      'Hostess',
      'Order_Taker',
      'Food_Runner',
      'Event_Staff',
      'Bartender',
      'Barista',
      // Marketing Department
      'Marketing',
      'PR',
      'Sales_Corp',
      'Sales_Tour',
      'Sales_Online',
      // Finance and Accounting Department
      'General_Accountant',
      'Debt_Accountant',
      'Auditor',
      'Cash_Keeper',
      'Purchaser',
      // Human Resource Department
      'Payroll',
      'Insurance',
      'Legal_Officer',
      // Engineering Department
      'Electrical_Engineer',
      'Plumber',
      'Carpenter',
      'Painter',
      'AC_Chiller',
      'Boiler',
      // Other Department
      'IT_Man',
      'Rescuer',
      'Security',
      'Store_Keeper',
    ];

    foreach ($listPosition as $key => $position) {
      Position::create([
        'position_name' => $position,
      ]);
    }
  }
}

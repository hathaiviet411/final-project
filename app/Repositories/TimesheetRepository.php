<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\TimesheetRequest;
use App\Models\Timesheet;
use App\Repositories\Contracts\TimesheetRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class TimesheetRepository extends BaseRepository implements TimesheetRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Timesheet $model
   */

  const SORT_BY = [
    'department' => 'department',
    'position' => 'position',
    'contract' => 'contract',
    'role' => 'role'
  ];

  const SORT_TYPE = [
    '0' => 'desc',
    '1' => 'asc'
  ];

  public function model()
  {
    return Timesheet::class;
  }

  public function getAll()
  {
    return $this->model->select('*')->get();
  }

  public function getPagination(TimesheetRequest $request)
  {
    $query = $this->model;
    $sorttype = Arr::get($request->all(), 'sorttype', null);
    $sortby = Arr::get($request->all(), 'sortby', null);
    $department = Arr::get($request->all(), 'department', null);
    $position = Arr::get($request->all(), 'position', null);
    $contract = Arr::get($request->all(), 'contract', null);
    $role = Arr::get($request->all(), 'role', null);
    $user_id = Arr::get($request->all(), 'user_id', null);
    $sorted = false;

    if (isset(self::SORT_BY[$sortby]) && isset(self::SORT_TYPE[$sorttype])) {
      $query = $query->orderBy(self::SORT_BY[$sortby], self::SORT_TYPE[$sorttype]);
      $sorted = true;
    }

    if ($department || $department === "0") {
      $query = $query->where('department_id', 'like', "%{$department}%");
    }

    if ($position || $position === "0") {
      $query = $query->where('position_id', 'like', "%{$position}%");
    }

    if ($contract || $contract === "0") {
      $query = $query->where('contract_type', 'like', "%{$contract}%");
    }

    if ($user_id || $user_id === "0") {
      $query = $query->where('id', 'like', "%{$user_id}%");
    }

    if ($role || $role === "0") {
      $query = $query->where('role_id', 'like', "%{$role}%");
    }

    if ($sorted == false) {
      $query = $query->orderBy('user_name', 'DESC');
    }

    $result = $query->paginate($request->per_page);
    return $result;
  }

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'user_id' => $attribute['user_id'],
        'user_code' => $attribute['user_code'],
        'user_name' => $attribute['user_name'],
        'role_id' => $attribute['role_id'],
        'department_id' => $attribute['department_id'],
        'position_id' => $attribute['position_id'],
        'contract_type' => $attribute['contract_type'],
        'timesheet' => json_encode($attribute['timesheet']),
        'total_salary' => $attribute['total_salary'],
        'deduction' => $attribute['deduction'],
        'deduction_reason' => $attribute['deduction_reason'],
        'payroll_status' => $attribute['payroll_status'],
        'schedule' => json_encode($attribute['schedule']),
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function update(array $request, $code)
  {
    $status = DB::transaction(function () use ($request, $code) {
      $timesheet = $this->model->where('user_code', $code)->first();

      if(isset($request['deduction'])) {
        $timesheet->deduction = $request['deduction'];
      } else if (isset($request['deduction_reason'])) {
        $timesheet->deduction_reason = $request['deduction_reason'];
      } else if (isset($request['payroll_status'])) {
        $timesheet->payroll_status = $request['payroll_status'];
      } else if (isset($request['schedule'])) {
        $timesheet->schedule = $request['schedule'];
      }

      $list_schedule = json_decode($timesheet->schedule, true);
      $total_salary = 0;

      $full_time = 1;
      $part_time = 2;

      $admin = 1;
      $manager = 2;
      $staff = 3;

      $salary_per_hour_manager = 140000;
      $salary_per_hour_staff = 70000;

      $basic_salary_manager = 30000000;
      $salary_per_day_manager = 1200000;

      $basic_salary_staff = 15000000;
      $salary_per_day_staff = 600000;

      $working_day_count = 0;
      $working_time_hours = 0;
      $working_time_minutes = 0;

      $contract_type = $timesheet->contract_type;
      $role = $timesheet->role_id;

      // Step 1: Check if user is full time or part time.
      if ($contract_type === $full_time) {
        foreach ($list_schedule as $schedule) {
          if ($schedule['approve_status'] === 1) {
            $working_day_count += 1;
          }
        }

        // Step 2: Calculate total_salary by staff role.
        if ($role === $manager) {
          $total_salary = $working_day_count * $salary_per_day_manager;
        } else if ($role === $staff) {
          $total_salary = $working_day_count * $salary_per_day_staff;
        }
      } else if ($contract_type === $part_time) {
        foreach ($list_schedule as $schedule) {
          if ($schedule['approve_status'] === 1) {
            $working_time_hours += (int)$schedule['spent_time_hour'];
            $working_time_minutes += (int)$schedule['spent_time_minute'];
          }
        }

        // Step 3: Transform working minutes to hours.
        $working_time_hours += $working_time_minutes / 60;

        // Step 4: Calculate total_salary by staff role.
        if ($role === $manager) {
          $total_salary = $working_time_hours * $salary_per_hour_manager;
        } else if ($role === $staff) {
          $total_salary = $working_time_hours * $salary_per_hour_staff;
        }
      }

      // Step 5: Check if have deduction.
      if (isset($request['deduction'])) {
        $total_salary -= $request['deduction'];
      }

      // Step 6: Check if payroll status is valid.
      if (isset($request['payroll_status'])) {
        if ($request['payroll_status'] === 1 || $request['payroll_status'] === 3) {
          $total_salary = 0;
        }
      }

      $timesheet->total_salary = $total_salary;

      $timesheet->save();
    });

    return $status;
  }

  public function getOne($id)
  {
    $timesheet = $this->model->find($id);
    return $timesheet;
  }
}

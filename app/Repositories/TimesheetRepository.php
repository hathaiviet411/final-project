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
      $timesheet->schedule = $request['schedule'];
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

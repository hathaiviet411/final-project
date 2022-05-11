<?php

/**
 * Created by VeHo.
 * Year: 2022-04-24
 */

namespace Repository;

use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Schedule $model
   */

  const SORT_BY = [
    'department' => 'department',
    'position' => 'position',
    'contract' => 'contract',
  ];

  const SORT_TYPE = [
    '0' => 'desc',
    '1' => 'asc'
  ];


  public function model()
  {
    return Schedule::class;
  }

  public function getAll()
  {
    return $this->model->select('*')->get();
  }

  public function getPagination(ScheduleRequest $request)
  {
    $query = $this->model;
    $sorttype = Arr::get($request->all(), 'sorttype', null);
    $sortby = Arr::get($request->all(), 'sortby', null);
    $department = Arr::get($request->all(), 'department', null);
    $position = Arr::get($request->all(), 'position', null);
    $contract = Arr::get($request->all(), 'contract', null);
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
        'contract_type' => $attribute['contract_type'],
        'department_id' => $attribute['department_id'],
        'position_id' => $attribute['position_id'],
        'role_id' => $attribute['role_id'],
        'schedules' => json_encode($attribute['schedules']),
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function update(array $request, $id)
  {
    $status = DB::transaction(function () use ($request, $id) {
      $schedule = $this->model->where('id', $id)->first();
      $schedule->schedules = $request['schedules'];
      $schedule->save();
    });

    return $status;
  }

  public function getOne($id)
  {
    $schedule = $this->model->find($id);
    return $schedule;
  }
}

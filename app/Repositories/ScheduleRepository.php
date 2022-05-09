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
      $result = $this->paginate($request->per_page);
      return $result;
  }

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'user_id' => $attribute['user_id'],
        'user_name' => $attribute['user_name'],
        'contract_type' => $attribute['contract_type'],
        'department_id' => $attribute['department_id'],
        'schedules' => json_encode($attribute['schedules']),
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function getOne($id)
  {
      $room = $this->model->find($id);
      return $room;
  }
}

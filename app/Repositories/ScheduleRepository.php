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

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'task_name' => $attribute['task_name'],
        'task_description' => $attribute['task_description'],
        'required_position' => $attribute['required_position'],
        'required_contract_type' => $attribute['required_contract_type'],
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }
}

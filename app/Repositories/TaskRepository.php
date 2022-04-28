<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Task $model
   */

  public function model()
  {
    return Task::class;
  }

  public function getAll()
  {
      return $this->model->select('id', 'task_name', 'task_description')->get();
  }

  public function getPagination(TaskRequest $request)
  {
      $result = $this->paginate($request->per_page);
      return $result;
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

  public function update(array $request, $id)
  {
      $status = DB::transaction(function () use ($request, $id) {
          $task = $this->model->where('id', $id)->first();
          $task->task_name = $request['task_name'];
          $task->task_description = $request['task_description'];
          $task->required_position = $request['required_position'];
          $task->required_contract_type = $request['required_contract_type'];
          $task->save();
      });

      return $status;
  }

  public function getOne($id)
  {
      $task = $this->model->find($id);
      return $task;
  }
  
  public function destroy($id)
  {
      return $this->model->where('id', $id)->delete($id);
  }
}

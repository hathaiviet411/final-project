<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Repositories\Contracts\FeedbackRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedbackRepository extends BaseRepository implements FeedbackRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Feedback $model
   */

  public function model()
  {
    return Feedback::class;
  }

  public function getAll()
  {
      return $this->model->select('id', 'task_name')->get();
  }

  public function getPagination(FeedbackRequest $request)
  {
      $result = $this->model->with([
        'user' => function ($query) {
          $query->with('department')->select(['*']);
        },
      ])->paginate($request->per_page);
      return $result;
  }

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'feedback_title' => $attribute['feedback_title'],
        'feedback_content' => $attribute['feedback_content'],
        'upload_date' => $attribute['upload_date'],
        'subject' => $attribute['subject'],
        'status' => $attribute['status'],
        'user_id' => $attribute['user_id'],
        'department_id' => $attribute['department_id'],
        'position_id' => $attribute['position_id'],
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function update(array $request, $id)
  {
      $status = DB::transaction(function () use ($request, $id) {
          $feedback = $this->model->where('id', $id)->first();
          $feedback->feedback_title = $request['feedback_title'];
          $feedback->feedback_content = $request['feedback_content'];
          $feedback->upload_date = $request['upload_date'];
          $feedback->subject = $request['subject'];
          $feedback->status = $request['status'];
          $feedback->user_id = $request['user_id'];
          $feedback->department_id = $request['department_id'];
          $feedback->position_id = $request['position_id'];
          $feedback->save();
      });

      return $status;
  }

  public function getOne($id)
  {
      $feedback = $this->model->find($id);
      return $feedback;
  }
  
  public function destroy($id)
  {
      return $this->model->where('id', $id)->delete($id);
  }
}

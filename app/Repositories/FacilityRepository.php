<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\FacilityRequest;
use App\Models\Facility;
use App\Repositories\Contracts\FacilityRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacilityRepository extends BaseRepository implements FacilityRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Facility $model
   */

  public function model()
  {
    return Facility::class;
  }

  public function getAll()
  {
      return $this->model->select('id', 'facility_title')->get();
  }

  public function getPagination(FacilityRequest $request)
  {
      $result = $this->paginate($request->per_page);
      return $result;
  }

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'facility_title' => $attribute['facility_title'],
        'facility_detail' => $attribute['facility_detail'],
        'user_id' => $attribute['user_id'],
        'start_date' => $attribute['start_date'],
        'end_date' => $attribute['end_date'],
        'status' => $attribute['status'],
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function update(array $request, $id)
  {
      $status = DB::transaction(function () use ($request, $id) {
          $facility = $this->model->where('id', $id)->first();
          $facility->facility_title = $request['facility_title'];
          $facility->facility_detail = $request['facility_detail'];
          $facility->user_id = $request['user_id'];
          $facility->start_date = $request['start_date'];
          $facility->end_date = $request['end_date'];
          $facility->status = $request['status'];
          $facility->save();
      });

      return $status;
  }

  public function getOne($id)
  {
      $facility = $this->model->find($id);
      return $facility;
  }
  
  public function destroy($id)
  {
      return $this->model->where('id', $id)->delete($id);
  }
}

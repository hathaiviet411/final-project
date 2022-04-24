<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\BuildingRequest;
use App\Models\Building;
use App\Repositories\Contracts\BuildingRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class BuildingRepository extends BaseRepository implements BuildingRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Building $model
   */

  public function model()
  {
    return Building::class;
  }

  public function getAll()
  {
    return $this->model->select('id', 'department_name')->get();
  }

  public function getPagination(BuildingRequest $request)
  {
    $result = $this->model->with('rooms')->paginate($request->per_page);
    return $result;
  }
}

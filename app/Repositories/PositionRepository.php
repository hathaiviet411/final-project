<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use App\Repositories\Contracts\PositionRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Position $model
   */

  public function model()
  {
    return Position::class;
  }

  public function getAll()
  {
      return $this->model->select('id', 'position_name')->get();
  }

  public function getPagination(PositionRequest $request)
  {
      $result = $this->paginate($request->per_page);
      return $result;
  }
}

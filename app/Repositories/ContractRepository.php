<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Repositories\Contracts\ContractRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class ContractRepository extends BaseRepository implements ContractRepositoryInterface
{

  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  /**
   * Instantiate model
   *
   * @param Contract $model
   */

  public function model()
  {
    return Contract::class;
  }

  public function getAll()
  {
      return $this->model->select('id', 'contract_type')->get();
  }

  public function getPagination(ContractRequest $request)
  {
      $result = $this->paginate($request->per_page);
      return $result;
  }
}

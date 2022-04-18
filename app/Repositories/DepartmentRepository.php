<?php
/**
 * Created by VeHo.
 * Year: 2022-01-04
 */

namespace Repository;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{

    public function __construct(Application $app)
    {
        parent::__construct($app);

    }

    /**
     * Instantiate model
     *
     * @param Department $model
     */

    public function model()
    {
        return Department::class;
    }

    public function getAll()
    {
        return $this->model->select('id', 'department_name')->get();
    }

    public function getPagination(DepartmentRequest $request)
    {
        $result = $this->paginate($request->per_page);
        return $result;
    }

    public function create(array $attribute)
    {
      $status = DB::transaction(function () use ($attribute) {
        $department = $this->model->create([
          'department_name' => $attribute['department_name'],
          'created_by' => Auth::id(),
        ]);
      });

      return $status;
    }
}

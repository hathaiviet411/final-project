<?php
/**
 * Created by VeHo.
 * Year: 2022-01-04
 */

namespace Repository;

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
        return $this->model->select('id', 'name')->get();
    }

    public function create(array $attribute)
    {
      $status = DB::transaction(function () use ($attribute) {
        $department = $this->model->create([
          'name' => $attribute['name'],
          'created_by' => Auth::id(),
        ]);
      });

      return $status;
    }
}

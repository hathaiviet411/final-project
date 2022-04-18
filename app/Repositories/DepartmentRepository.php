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
        $this->model->create([
          'department_name' => $attribute['department_name'],
          'department_address' => $attribute['department_address'],
          'department_manager' => $attribute['department_manager'],
          'organized_date' => $attribute['organized_date'],
          'created_by' => Auth::id(),
        ]);
      });

      return $status;
    }

    public function update(array $request, $id)
    {
        $status = DB::transaction(function () use ($request, $id) {
            $department = $this->model->where('id',$id)->first();
            $department->department_name = $request['department_name'];
            $department->department_address = $request['department_address'];
            $department->department_manager = $request['department_manager'];
            $department->organized_date = $request['organized_date'];
            $department->save();
        });
        return $status;
    }

    public function getOne($id)
    {
        $department = $this->model->find($id);
        return $department;
    }
    
    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete($id);
    }
}

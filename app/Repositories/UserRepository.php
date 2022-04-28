<?php


namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Repository\BaseRepository;
use Spatie\Permission\Models\Role;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
  public function __construct(Application $app)
  {
    parent::__construct($app);
  }

  public function model()
  {
    return User::class;
  }

  public function getAll()
  {
    return User::with('roles')->select('*')->get();
  }

  public function getOne($id)
  {
    $user = $this->model->find($id);
    $user->getRoleNames();
    return $user;
  }

  public function getOneByCode($userCode)
  {
    return $this->model->find($userCode);
  }

  public function getPagination(UserRequest $request)
  {
    $sortby = $request->has('sortby') ? $request->sortby : 'users.id';
    if ($sortby == 'name') {
      $sortby = 'users.user_name';
    }
    if ($sortby == 'role') {
      $sortby = 'roles.name';
    }
    if ($sortby == 'department') {
      $sortby = 'departments.department_name';
    }

    $sorttype = $request->has('sorttype') && $request->sorttype ? 'desc' : 'asc';

    $query = User::select(
      "users.id",
      "users.user_code",
      "users.department_id",
      "users.position_id",
      "users.contract_id",
      "users.user_name",
      "roles.id as role_id",
      "roles.name as role_name",
      "departments.department_name as departments_name",
      "model_has_roles.model_type"
    )
      ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
      ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
      ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
      ->leftJoin('positions', 'positions.id', '=', 'users.position_id')
      ->leftJoin('contracts', 'contracts.id', '=', 'users.contract_id');

    if ($request->has('user_code')) {
      $query->where('user_code', 'LIKE', '%' . $request->user_code . '%');
    }

    if ($request->has('user_name')) {
      $query->where(function ($query) use ($request) {
        $query->where('user_name', 'LIKE', '%' . $request->user_name . '%');
      });
    }

    $query->when($request->get('department_id'), function ($query) use ($request) {
      return $query->where('department_id', $request->get('department_id'));
    });

    $result = $query->orderBy($sortby, $sorttype)->paginate($request->per_page);
    
    return $result;
  }

  public function create(array $attributes)
  {
    $status = DB::transaction(function () use ($attributes) {
      $user = $this->model->create([
        'user_name' => $attributes['user_name'],
        'user_code' => $attributes['user_code'],
        'password' => $attributes['password'],
        'email' => $attributes['email'],
        'dob' => $attributes['dob'],
        'participated_date' => $attributes['participated_date'],
        'address' => $attributes['address'],
        'phone_number' => $attributes['phone_number'],
        'is_retired' => $attributes['is_retired'],
        'avatar' => $attributes['avatar'],
        'role_id' => $attributes['role_id'],
        'department_id' => $attributes['department_id'],
        'position_id' => $attributes['position_id'],
        'contract_id' => $attributes['contract_id'],
        'created_by' => Auth::id(),
      ]);

      if ($role = Role::findById($attributes['role_id'], 'api')) {
        $user->syncRoles($role);
        return true;
      } else {
        DB::rollBack();
        return false;
      }
    });
    return $status;
  }

  public function update(array $request, $id)
  {
    $status = DB::transaction(function () use ($request, $id) {
      $user = $this->model->where('id', $id)->first();
      // if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
      //   return false;
      // }

      $user->user_name = $request['user_name'];
      
      if (isset($request['user_code'])) {
        $user->user_code = $request['user_code'];
      }

      $user->email = $request['email'];
      $user->dob = $request['dob'];
      $user->address = $request['address'];
      $user->phone_number = $request['phone_number'];
      $user->is_retired = $request['is_retired'];

            
      if (isset($request['avatar'])) {
        $user->avatar = $request['avatar'];
      }

      $user->role_id = $request['role_id'];
      $user->department_id = $request['department_id'];
      $user->position_id = $request['position_id'];
      $user->contract_id = $request['contract_id'];

      if (isset($request['password']) && strlen($request['password'] >= 8)) {
        $user->password = $request['password'];
      }
      $user->save();

      if ($role = Role::findById($request['role_id'], 'api')) {
        $user->syncRoles($role);
        return true;
      } else {
        DB::rollBack();
        return false;
      }
    });
    return $status;
  }

  public function destroy($id)
  {
    return $this->model->where('id', $id)->delete($id);
  }
}

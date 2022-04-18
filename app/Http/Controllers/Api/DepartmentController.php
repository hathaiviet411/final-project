<?php
/**
 * Created by VeHo.
 * Year: 2022-01-04
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;
use Repository\DepartmentRepository;

class DepartmentController extends Controller
{

    /**
     * var Repository
     */
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @OA\Get(
     *   path="/api/department",
     *   tags={"Department"},
     *   summary="List Department",
     *   operationId="department_index",
     *   @OA\Response(
     *     response=200,
     *     description="Send request success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{{"id": 1,"name": "Ban Lễ Tân"}, {"id": 2,"name": "Ban Vệ Sinh"}, {"id": 3,"name": "Ban Quản Lí"}}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login false",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Username or password invalid"}
     *     )
     *   ),
     *   security={},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DepartmentRequest $request)
    {
        $department = $this->departmentRepository->getPagination($request);
        return $this->responseJson(200, DepartmentResource::collection($department));
    }

    /**
     * @return \Illuminate\Http\JsonResponse 
     * @throws \Exception
    */
    public function store(DepartmentRequest $request)
    { 
      if (isset($request)) {
          $this->departmentRepository->create($request->all());
          return $this->responseJson(201, null, 'Create department successfully !');
      } else {
          return $this->responseJson(500, null, 'Create department failed !');
      }
    }

    /** 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
    */
    public function update(DepartmentRequest $request, $id)
    {
      if (isset($request)) {
          $this->departmentRepository->update($request->all(), $id);
          return $this->responseJson(200, null, 'Update department successfully !');
      } else {
          return $this->responseJson(500, null, 'Update department failed !');
      }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
    */
    public function show($id)
    {
        if (isset($id)) {
            $department = $this->departmentRepository->getOne($id);
            return $this->responseJson(200, new DepartmentResource($department));
        } else {
            return $this->responseJson(500, null, 'Get department failed !');
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
    */
    public function destroy($id) 
    {
        if(isset($id)) {
            $this->departmentRepository->delete($id);
            return $this->responseJson(200, null, 'Delete department successfully !');
        } else {
            return $this->responseJson(500, null, 'Delete department failed !');
        }
    }
}

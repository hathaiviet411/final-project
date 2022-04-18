<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-15
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    //  /**
    //  * var Repository
    //  */
    // protected $repository;

    // public function __construct(RoleRepositoryInterface $repository)
    // {
    //     $this->middleware(['role_or_permission:' . ROLE_ADMIN]);
    //     $this->repository = $repository;
    // }

    // /**
    //  * @OA\Get(
    //  *   path="/api/role",
    //  *   tags={"Role"},
    //  *   summary="List role",
    //  *   operationId="role_index",
    //  *   @OA\Response(
    //  *     response=200,
    //  *     description="Send request success",
    //  *     @OA\MediaType(
    //  *      mediaType="application/json",
    //  *      example={"code":200,"data":{{"id": 1,"name": "admin"},{"id": 2,"name": "admin"},{"id": 3,"name": "TienNamNguyen"},{"id": 1,"name": "God"}}}
    //  *     )
    //  *   ),
    //  *   @OA\Response(
    //  *     response=401,
    //  *     description="Login false",
    //  *     @OA\MediaType(
    //  *      mediaType="application/json",
    //  *      example={"code":401,"message":"Username or password invalid"}
    //  *     )
    //  *   ),
    //  *   security={{"auth": {}}},
    //  * )
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function index(RoleRequest $request)
    // {
    //     $data = $this->repository->getAll();
    //     return $this->responseJson(200, new RoleResource($data));
    // }

    // public function show($id)
    // {
    //     try {
    //         $department = $this->repository->find($id);
    //         return $this->responseJson(200, new BaseResource($department));
    //     } catch (\Exception $e) {
    //         throw $e;
    //     }
    // }
}

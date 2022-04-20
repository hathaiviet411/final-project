<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{

  /**
   * var Repository
   */
  protected $taskRepository;

  public function __construct(TaskRepositoryInterface $taskRepository)
  {
    $this->taskRepository = $taskRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/task",
   *   tags={"Task"},
   *   summary="List Task",
   *   operationId="task_index",
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{{"id": 1,"name": "..........."}}}
   *     )
   *   ),
   *   @OA\Parameter(
   *     name="page",
   *     in="query",
   *     @OA\Schema(
   *      type="integer",
   *     ),
   *   ),
   *   @OA\Parameter(
   *     name="per_page",
   *     in="query",
   *     @OA\Schema(
   *      type="integer",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=401,
   *     description="Login false",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":401,"message":"Username or password invalid"}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(TaskRequest $request)
  {
    $task = $this->taskRepository->getPagination($request);
    return $this->responseJson(200, TaskResource::collection($task));
  }

  /**
   * @OA\Post(
   *   path="/api/task",
   *   tags={"Task"},
   *   summary="Add new Task",
   *   operationId="task_create",
   *   @OA\Parameter(name="name", in="query", required=true,
   *     @OA\Schema(type="string"),
   *   ),
   *
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name": "......"}}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function store(TaskRequest $request)
  {
    try {
      $this->taskRepository->create($request->all());
      return $this->responseJson(201, null, 'Create task successfully !');
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Create task failed !');
    }
  }

  /**
   * @OA\Get(
   *   path="/api/task/{id}",
   *   tags={"Task"},
   *   summary="Detail Task",
   *   operationId="task_show",
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name":"......"}}
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
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    try {
      $task = $this->taskRepository->getOne($id);
      return $this->responseJson(200, new TaskResource($task));
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Get detail task failed !');
    }
  }

  /**
   * @OA\Post(
   *   path="/api/task/{id}",
   *   tags={"Task"},
   *   summary="Update Task",
   *   operationId="task_update",
   *   @OA\Parameter(
   *     name="id",
   *     in="path",
   *     required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\RequestBody(
   *       @OA\MediaType(
   *          mediaType="application/json",
   *          example={"name":"string"},
   *          @OA\Schema(
   *            required={"name"},
   *            @OA\Property(
   *              property="name",
   *              format="string",
   *            ),
   *         )
   *      )
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":{"id": 1,"name":  "............."}}
   *     ),
   *   ),
   *   @OA\Response(
   *     response=403,
   *     description="Access Deny permission",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":403,"message":"Access Deny permission"}
   *     ),
   *   ),
   *   security={{"auth": {}}},
   * )
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(TaskRequest $request, $id)
  {
    if (isset($request)) {
      $this->taskRepository->update($request->all(), $id);
      return $this->responseJson(200, null, 'Update task successfully !');
    } else {
      return $this->responseJson(403, null, 'Update department failed !');
    }
  }

  /**
   * @OA\Delete(
   *   path="/api/task/{id}",
   *   tags={"Task"},
   *   summary="Delete Task",
   *   operationId="task_delete",
   *   @OA\Parameter(
   *      name="id",
   *      in="path",
   *      required=true,
   *     @OA\Schema(
   *      type="string",
   *     ),
   *   ),
   *   @OA\Response(
   *     response=200,
   *     description="Send request success",
   *     @OA\MediaType(
   *      mediaType="application/json",
   *      example={"code":200,"data":"Send request success"}
   *     )
   *   ),
   *   security={{"auth": {}}},
   * )
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    if (isset($id)) {
      $this->taskRepository->delete($id);
      return $this->responseJson(200, null, 'Delete department successfully !');
    } else {
      return $this->responseJson(500, null, 'Delete department failed !');
    }
  }
}

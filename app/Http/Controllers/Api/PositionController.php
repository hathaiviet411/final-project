<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Repositories\Contracts\PositionRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PositionResource;
use Illuminate\Http\Request;

class PositionController extends Controller
{

  /**
   * var Repository
   */
  protected $positionRepository;

  public function __construct(PositionRepositoryInterface $positionRepository)
  {
    $this->positionRepository = $positionRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/position",
   *   tags={"Position"},
   *   summary="List Position",
   *   operationId="position_index",
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
  public function index(PositionRequest $request)
  {
    $positions = $this->positionRepository->getPagination($request);
    return $this->responseJson(200, PositionResource::collection($positions));
  }

  /**
   * @OA\Post(
   *   path="/api/position",
   *   tags={"Position"},
   *   summary="Add new Position",
   *   operationId="position_create",
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
  public function store(PositionRequest $request)
  {
    try {
      $data = $this->repository->create($request->all());
      return $this->responseJson(200, new PositionResource($data));
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @OA\Get(
   *   path="/api/position/{id}",
   *   tags={"Position"},
   *   summary="Detail Position",
   *   operationId="position_show",
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
      $department = $this->repository->find($id);
      return $this->responseJson(200, new BaseResource($department));
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /**
   * @OA\Post(
   *   path="/api/position/{id}",
   *   tags={"Position"},
   *   summary="Update Position",
   *   operationId="position_update",
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
  public function update(PositionRequest $request, $id)
  {
    $attributes = $request->except([]);
    $data = $this->repository->update($attributes, $id);
    return $this->responseJson(200, new BaseResource($data));
  }

  /**
   * @OA\Delete(
   *   path="/api/position/{id}",
   *   tags={"Position"},
   *   summary="Delete Position",
   *   operationId="position_delete",
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
    $this->repository->delete($id);
    return $this->responseJson(200, null, trans('messages.mes.delete_success'));
  }
}

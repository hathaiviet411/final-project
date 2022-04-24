<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\RoomResource;
use Illuminate\Http\Request;

class RoomController extends Controller
{

  /**
   * var Repository
   */
  protected $roomRepository;

  public function __construct(RoomRepositoryInterface $roomRepository)
  {
    $this->roomRepository = $roomRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/room",
   *   tags={"Room"},
   *   summary="List Room",
   *   operationId="room_index",
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
  public function index(RoomRequest $request)
  {
    $rooms = $this->roomRepository->getPagination($request);
    return $this->responseJson(200, RoomResource::collection($rooms));
  }

  /**
   * @OA\Post(
   *   path="/api/room",
   *   tags={"Room"},
   *   summary="Add new Room",
   *   operationId="room_create",
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
  public function store(RoomRequest $request)
  {
    try {
      $this->roomRepository->create($request->all());
      return $this->responseJson(201, null, 'Create room successfully !');
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Create room failed !');
    }
  }

  /**
   * @OA\Get(
   *   path="/api/room/{id}",
   *   tags={"Room"},
   *   summary="Detail Room",
   *   operationId="room_show",
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
      $room = $this->roomRepository->getOne($id);
      return $this->responseJson(200, new RoomResource($room));
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Get detail room failed !');
    }
  }

  /**
   * @OA\Post(
   *   path="/api/room/{id}",
   *   tags={"Room"},
   *   summary="Update Room",
   *   operationId="room_update",
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
  public function update(RoomRequest $request, $id)
  {
    if (isset($request)) {
      $this->roomRepository->update($request->all(), $id);
      return $this->responseJson(200, null, 'Update room successfully !');
    } else {
      return $this->responseJson(403, null, 'Update department failed !');
    }
  }

  /**
   * @OA\Delete(
   *   path="/api/room/{id}",
   *   tags={"Room"},
   *   summary="Delete Room",
   *   operationId="room_delete",
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
      $this->roomRepository->delete($id);
      return $this->responseJson(200, null, 'Delete department successfully !');
    } else {
      return $this->responseJson(500, null, 'Delete department failed !');
    }
  }
}

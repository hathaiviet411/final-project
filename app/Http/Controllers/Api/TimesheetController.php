<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimesheetRequest;
use App\Repositories\Contracts\TimesheetRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\TimesheetResource;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{

  /**
   * var timesheetRepository
   */
  protected $timesheetRepository;

  public function __construct(TimesheetRepositoryInterface $timesheetRepository)
  {
    $this->timesheetRepository = $timesheetRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/timesheet",
   *   tags={"Timesheet"},
   *   summary="List Timesheet",
   *   operationId="timesheet_index",
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
  public function index(TimesheetRequest $request)
  {
    $timesheet = $this->timesheetRepository->getPagination($request);
    return $this->responseJson(200, TimesheetResource::collection($timesheet));
  }

  /**
   * @OA\Post(
   *   path="/api/timesheet",
   *   tags={"Timesheet"},
   *   summary="Add new Timesheet",
   *   operationId="timesheet_create",
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
  public function store(TimesheetRequest $request)
  {
    try {
      $this->timesheetRepository->create($request->all());
      return $this->responseJson(201, null, 'Create timesheet successfully !');
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Create timesheet failed !');
    }
  }

  /**
   * @OA\Get(
   *   path="/api/timesheet/{id}",
   *   tags={"Timesheet"},
   *   summary="Detail Timesheet",
   *   operationId="timesheet_show",
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
      $timesheet = $this->timesheetRepository->getOne($id);
      return $this->responseJson(200, new TimesheetResource($timesheet));
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Get detail timesheet failed !');
    }
  }

  /**
   * @OA\Post(
   *   path="/api/timesheet/{id}",
   *   tags={"Timesheet"},
   *   summary="Update Timesheet",
   *   operationId="timesheet_update",
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
  public function update(TimesheetRequest $request, $id)
  {
    $attributes = $request->except([]);
    $data = $this->timesheetRepository->update($attributes, $id);
    return $this->responseJson(200, new BaseResource($data));
  }

  /**
   * @OA\Delete(
   *   path="/api/timesheet/{id}",
   *   tags={"Timesheet"},
   *   summary="Delete Timesheet",
   *   operationId="timesheet_delete",
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
    $this->timesheetRepository->delete($id);
    return $this->responseJson(200, null, trans('messages.mes.delete_success'));
  }
}

<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacilityRequest;
use App\Repositories\Contracts\FacilityRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\FacilityResource;
use Illuminate\Http\Request;

class FacilityController extends Controller
{

  /**
   * var Repository
   */
  protected $facilityRepository;

  public function __construct(FacilityRepositoryInterface $facilityRepository)
  {
    $this->facilityRepository = $facilityRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/facility",
   *   tags={"Facility"},
   *   summary="List Facility",
   *   operationId="facility_index",
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
  public function index(FacilityRequest $request)
  {
    $facility = $this->facilityRepository->getPagination($request);
    return $this->responseJson(200, FacilityResource::collection($facility));
  }

  /**
   * @OA\Post(
   *   path="/api/facility",
   *   tags={"Facility"},
   *   summary="Add new Facility",
   *   operationId="facility_create",
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
  public function store(FacilityRequest $request)
  {
    try {
      $this->facilityRepository->create($request->all());
      return $this->responseJson(201, null, 'Create facility successfully !');
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Create facility failed !');
    }
  }

  /**
   * @OA\Get(
   *   path="/api/facility/{id}",
   *   tags={"Facility"},
   *   summary="Detail Facility",
   *   operationId="facility_show",
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
      $facility = $this->facilityRepository->getOne($id);
      return $this->responseJson(200, new FacilityResource($facility));
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Get detail facility failed !');
    }
  }

  /**
   * @OA\Post(
   *   path="/api/facility/{id}",
   *   tags={"Facility"},
   *   summary="Update Facility",
   *   operationId="facility_update",
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
  public function update(FacilityRequest $request, $id)
  {
    if (isset($request)) {
      $this->facilityRepository->update($request->all(), $id);
      return $this->responseJson(200, null, 'Update facility successfully !');
    } else {
      return $this->responseJson(403, null, 'Update department failed !');
    }
  }

  /**
   * @OA\Delete(
   *   path="/api/facility/{id}",
   *   tags={"Facility"},
   *   summary="Delete Facility",
   *   operationId="facility_delete",
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
      $this->facilityRepository->delete($id);
      return $this->responseJson(200, null, 'Delete department successfully !');
    } else {
      return $this->responseJson(500, null, 'Delete department failed !');
    }
  }
}

<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Repositories\Contracts\FeedbackRepositoryInterface;
use App\Http\Resources\BaseResource;
use App\Http\Resources\FeedbackResource;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{

  /**
   * var Repository
   */
  protected $feedbackRepository;

  public function __construct(FeedbackRepositoryInterface $feedbackRepository)
  {
    $this->feedbackRepository = $feedbackRepository;
  }

  /**
   * @OA\Get(
   *   path="/api/feedback",
   *   tags={"Feedback"},
   *   summary="List Feedback",
   *   operationId="feedback_index",
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
  public function index(FeedbackRequest $request)
  {
    $feedback = $this->feedbackRepository->getPagination($request);
    return $this->responseJson(200, FeedbackResource::collection($feedback));
  }

  /**
   * @OA\Post(
   *   path="/api/feedback",
   *   tags={"Feedback"},
   *   summary="Add new Feedback",
   *   operationId="feedback_create",
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
  public function store(FeedbackRequest $request)
  {
    try {
      $this->feedbackRepository->create($request->all());
      return $this->responseJson(201, null, 'Create feedback successfully !');
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Create feedback failed !');
    }
  }

  /**
   * @OA\Get(
   *   path="/api/feedback/{id}",
   *   tags={"Feedback"},
   *   summary="Detail Feedback",
   *   operationId="feedback_show",
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
      $feedback = $this->feedbackRepository->getOne($id);
      return $this->responseJson(200, new FeedbackResource($feedback));
    } catch (\Exception $e) {
      throw $e;
      return $this->responseJson(500, null, 'Get detail feedback failed !');
    }
  }

  /**
   * @OA\Post(
   *   path="/api/feedback/{id}",
   *   tags={"Feedback"},
   *   summary="Update Feedback",
   *   operationId="feedback_update",
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
  public function update(FeedbackRequest $request, $id)
  {
    if (isset($request)) {
      $this->feedbackRepository->update($request->all(), $id);
      return $this->responseJson(200, null, 'Update feedback successfully !');
    } else {
      return $this->responseJson(403, null, 'Update feedback failed !');
    }
  }

  /**
   * @OA\Delete(
   *   path="/api/feedback/{id}",
   *   tags={"Feedback"},
   *   summary="Delete Feedback",
   *   operationId="feedback_delete",
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
      $this->feedbackRepository->delete($id);
      return $this->responseJson(200, null, 'Delete feedback successfully !');
    } else {
      return $this->responseJson(500, null, 'Delete feedback failed !');
    }
  }
}

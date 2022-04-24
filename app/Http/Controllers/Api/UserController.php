<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Arr;
class UserController extends BaseController
{
    protected $repository;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['role_or_permission:' . ROLE_ADMIN]);
        $this->userRepository = $userRepository;
    }
    /**
     * @OA\Get(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="List user",
     *   operationId="user_index",
     *   @OA\Response(
     *     response=200,
     *     description="response success",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *        example={"code": 200,"data": {{"id": 1,"user_name": "Ha Thai Viet","user_code": 111111,"roles": {"admin"},"department_id": 1},{"id": 2,"user_name": "Vu Duck Viet","user_code": 222222,"roles": {"manager"},"department_id": 1}}}
     *     )
     *   ),
     *  @OA\Parameter(
     *     name="user_code",
     *     description = "User id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="department_id",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="name",
     *     in="query",
     *     required=false,
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="sortby",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *     ),
     *     ),
     *   @OA\Parameter(
     *     name="sorttype",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Parameter(
     *     name="per_page",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *     ),
     *     ),
     *  @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Wrong account or password"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Deny access",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRequest $request)
    {
        $users = $this->userRepository->getPagination($request);
        return $this->responseJson(200, UserResource::collection($users));
    }

    public function all(Request $request)
    {
        $users = $this->userRepository->getAll($request);
        return $this->responseJson(200, UserResource::collection($users));
    }

    /**
     * @OA\Get(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="User detail",
     *   operationId="user_show",
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
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *       mediaType="application/json",
     *     example={"code": 200,"data": {"id": 1,"user_name": "Ha Thai Viet","user_code": 111111,"roles": {"admin"},"department_id": 1}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Not login"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Deny access",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Access deny permission"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($id)
    {
        try {
            $user = $this->userRepository->getOne($id);
            return $this->responseJson(CODE_SUCCESS, new UserResource($user));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @OA\Put(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Update user",
     *   operationId="user_update",
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=false,
     *     @OA\Schema(
     *      type="integer",
     *     ),
     *   ),
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"user_name": "Ha Thai Viet","user_code": 111111,"password": null,"current_password": null,"roles": 1,"department_id": 1},
     *          @OA\Schema(
     *            required={"user_name"},
     *            @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *       example={"code":200,"message": "i18n"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Unauthorized",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Chưa đăng nhập"}
     *     )
     *   ),
     *   @OA\Response(
     *     response=403,
     *     description="Từ chối quyền truy cập",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":403,"message":"Từ chối quyền truy cập"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, $id)
    {
        $r = ['id' => $id];
        $validator = Validator::make($r, ['id' => 'required|exists:users,id',]);
        if ($validator->fails()) {
            return $this->responseJsonError(Response::HTTP_UNPROCESSABLE_ENTITY, '[Error] User not found.');
        }

        if ($this->userRepository->update($request->all(), $id)) {
            return $this->responseJson(CODE_SUCCESS, null, 'Update user successfully');
        } else {
            return $this->responseJson(CODE_CREATE_FAILED, null, 'Update user failed');
        }
    }
    /**
     * @OA\Post(
     *   path="/api/user",
     *   tags={"User"},
     *   summary="Add create",
     *   operationId="user_register",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={"user_name": "Ha Thai Viet","user_code": 111111,"password": "123@123a","roles": 1,"department_id": 1},
     *          @OA\Schema(
     *            required={"user_name"},
     *            @OA\Property(
     *              property="name",
     *              format="string",
     *            ),
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"","profile":{"id":1,
     *     "role":null,
     *     "name":null,
     *     "id":"example@gmail.com",
     *     "created_at":1570031021}}}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(UserRequest $request)
    {
        if ($this->userRepository->create($request->all())) {
            return $this->responseJson(CODE_SUCCESS, null, 'Create user successfully');
        } else {
            return $this->responseJson(CODE_CREATE_FAILED, null, 'Create user failed');
        }
    }


    /**
     * @OA\Delete(
     *   path="/api/user/{id}",
     *   tags={"User"},
     *   summary="Delete ..............",
     *   operationId="user_delete",
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
     *     description="Send request Success",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":"Send request Success"}
     *     )
     *   ),
     *   security={{"auth": {}}},
     * )
     * */
    public function destroy($id)
    {
        if($this->userRepository->destroy($id)) {
            return $this->responseJson(CODE_SUCCESS, null, 'Delete user successfully');
        } else {
            return $this->responseJson(CODE_SUCCESS, null, 'Delete user failed');
        }
    }
}

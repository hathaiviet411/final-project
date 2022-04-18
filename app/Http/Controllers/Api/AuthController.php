<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends BaseController
{
    protected $authRepository;
    protected $userRepository;

    public function __construct(AuthRepositoryInterface $authRepository, UserRepositoryInterface $userRepository)
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @OA\Post(
     *   path="/api/auth/login",
     *   tags={"Web-App Auth"},
     *   summary="Login",
     *   operationId="user_login",
     *   @OA\Parameter(
     *     name="user_code",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *     example="111111",
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     required=true,
     *     @OA\Schema(
     *      type="string",
     *     ),
     *     example="123456789",
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"Bearer ...",
     *     "profile":{"id":121232,
     *     "name":null,
     *     "role":null,
     *     "created_at":null
     *     }}}
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Login failed",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":401,"message":"Wrong account or password"}
     *     )
     *   ),
     *   security={},
     * )
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authRepository->doLogin($request, 'api');
        if ($result['attempt']) {
            $user = $result['user'];
            $token =  "Bearer " .$result['attempt'];
            $user->current_year = date('Y', strtotime(Carbon::now()));
            $user->current_year_month =  date('Y-m', strtotime(Carbon::now()));
            return $this->responseJson(Response::HTTP_OK, [
                'access_token' => $token,
                'profile' => new UserResource($user),
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()
            ]);
        }
        return $this->responseJsonError(Response::HTTP_UNAUTHORIZED, $result['mes']);
    }

    /**
     * @OA\Post(
     *   path="/api/auth/refresh",
     *   tags={"Web-App Auth"},
     *   summary="User register",
     *   operationId="user_reset_token",
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"data":{"access_token":"...."}}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function refresh()
    {
        return $this->responseJson(200, ['access_token' => auth()->refresh()]);
    }

    /**
     * @OA\Get(
     *   path="/api/auth/user",
     *   tags={"Web-App Auth"},
     *   summary="Detail User authenticated",
     *   operationId="Auth",
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

    public function user(Request $request) {
        return $request->user();
    }

    /**
     * @OA\Post(
     *   path="/api/auth/reset",
     *   tags={"Mobile-app Auth"},
     *   summary="User reset password",
     *   operationId="user_reset_password",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "employee_code": "LMH110011",
     *   },
     *        @OA\Schema(
     *            required={},
     *            @OA\Property(
     *              property="employee_code",
     *              format="string",
     *            )
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"message": "i18n.reset.success"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function resetPassword(Request $request) {
        return [];
    }

    /**
     * @OA\Post(
     *   path="/api/auth/register",
     *   tags={"Mobile-app Auth"},
     *   summary="User register account",
     *   operationId="user_register_account",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "employee_code": "LMH110011",
     *       "email": "namnt@gmail.com"
     *   },
     *        @OA\Schema(
     *            required={},
     *            @OA\Property(
     *              property="employee_code",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="email",
     *              format="string",
     *            )
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"message": "i18n.register.success"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registerAccount(Request $request) {
        return [];
    }


    /**
     * @OA\Post(
     *   path="/api/auth/password",
     *   tags={"Mobile-app Auth"},
     *   summary="User valid password",
     *   operationId="user_valid_password",
     * @OA\RequestBody(
     *       @OA\MediaType(
     *          mediaType="application/json",
     *          example={
     *       "password": "only_need_the_light_when_its_burnin_low",
     *       "confirm_password": "only_miss_the_sun_when_its_start_to_snow"
     *   },
     *        @OA\Schema(
     *            required={},
     *            @OA\Property(
     *              property="password",
     *              format="string",
     *            ),
     *            @OA\Property(
     *              property="confirm_password",
     *              format="string",
     *            )
     *         )
     *      )
     *   ),
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"message": "i18n.confirm_password.success"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function validPassword(Request $request) {

    }


    /**
     * @OA\Post(
     *   path="/api/auth/logout",
     *   tags={"Mobile-app Auth"},
     *   summary="User valid password",
     *   operationId="user_auth_logout",
     *   @OA\Response(
     *
     *     response=200,
     *     description="Submit request successfully",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *      example={"code":200,"message": "i18n.confirm_password.success"}
     *     )
     *   ),
     *   security={},
     * )
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function logout() {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }
}


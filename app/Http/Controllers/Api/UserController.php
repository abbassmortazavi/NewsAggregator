<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\PasswordReset\ResetPasswordRequest;
use App\Http\Requests\PasswordReset\SendPasswordResetRequest;
use App\Http\Requests\PasswordReset\VerifyPasswordResetRequest;
use App\Http\Resources\SendResetPasswordCodeResource;
use App\Services\Auth\AuthServiceInterface;
use App\Services\VerificationCode\VerificationCodeServiceInterface;
use App\Traits\UtilityResources\UtilityResources;
use App\Transformers\ApiResponseResource;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use UtilityResources;

    /**
     * @param AuthServiceInterface $service
     * @param VerificationCodeServiceInterface $verificationCodeService
     */
    public function __construct(protected AuthServiceInterface $service, protected VerificationCodeServiceInterface $verificationCodeService)
    {
    }

    /**
     * @OA\Post(
     *       path="/api/login",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="User Email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          description="User Password",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @param LoginRequest $request
     * @return ApiResponseResource
     */
    public function login(LoginRequest $request)
    {
        try {
            return $this->success($this->service->login($request->validated()), Response::HTTP_OK, 'User Login Successfully!!');
        } catch (Exception $exception) {
            return $this->error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/register",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="User Email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          description="User Password",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *           @OA\Parameter(
     *           name="name",
     *           in="query",
     *           required=true,
     *           description="User name",
     *           @OA\Schema(
     *               type="string"
     *           )
     *      ),
     *
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @param UserRegisterRequest $request
     * @return ApiResponseResource
     */
    public function register(UserRegisterRequest $request)
    {
        try {
            return $this->success($this->service->register($request->validated()), Response::HTTP_OK, 'User Register Successfully!!');
        } catch (Exception $exception) {
            return $this->error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/register",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *       security={{"bearerAuth":{}}},
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @return ApiResponseResource
     */
    public function logout(Request $request)
    {
        try {
            return $this->success($request->user()->currentAccessToken()->delete(), Response::HTTP_OK, 'User Logout Successfully!!');
        } catch (Exception $exception) {
            return $this->error($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/password/send-code",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="User Email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @param SendPasswordResetRequest $request
     * @return ApiResponseResource
     */
    public function sendCode(SendPasswordResetRequest $request)
    {
        try {
            return $this->success(new SendResetPasswordCodeResource($this->verificationCodeService->sendCode($request->only('email'))), Response::HTTP_OK, 'Send Verification Code Successfully!!');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/verifyCode",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="User Email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *           name="code",
     *           in="query",
     *           required=true,
     *           description="Verification Code",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @param VerifyPasswordResetRequest $request
     * @return ApiResponseResource
     */
    public function verifyCode(VerifyPasswordResetRequest $request)
    {
        try {
            return $this->success($this->verificationCodeService->verifyCode($request->only('email', 'code')), Response::HTTP_OK, 'Verify Code Successfully!!');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/password/reset-password",
     *       summary="Athentication",
     *       tags={"Athentication"},
     *
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true,
     *          description="User Email",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *
     *      @OA\Parameter(
     *           name="password_confirmation",
     *           in="query",
     *           required=true,
     *           description="Password Confirmation",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *        @OA\Parameter(
     *            name="password",
     *            in="query",
     *            required=true,
     *            description="Password",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *
     * @OA\Response(
     *       response=200,
     *        description="Success",
     *       @OA\MediaType(
     *            mediaType="application/json",
     *       )
     *    ),
     * @OA\Response(
     *       response=401,
     *        description="Unauthenticated"
     *    ),
     * @OA\Response(
     *       response=404,
     *       description="not found"
     *    ),
     * @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     )
     * )
     * @param ResetPasswordRequest $request
     * @return ApiResponseResource
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            return $this->success($this->verificationCodeService->resetPassword($request->only('email', 'password')), Response::HTTP_OK, 'Password Reset Successfully!!');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }
}

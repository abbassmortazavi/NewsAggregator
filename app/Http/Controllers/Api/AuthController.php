<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\Auth\AuthServiceInterface;
use App\Traits\UtilityResources\UtilityResources;
use App\Transformers\ApiResponseResource;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use UtilityResources;

    public function __construct(protected AuthServiceInterface $service)
    {
    }

    /**
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
     * @param UserRegisterRequest $request
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
     * @param UserRegisterRequest $request
     * @return ApiResponseResource
     */
    public function sendResetCode(Request $request)
    {
        try {
            return $this->success($this->service->sendResetCode($request->all()), Response::HTTP_OK, 'User Logout Successfully!!');
        } catch (Exception $exception) {
            return $this->error($exception->getCode(), $exception->getMessage());
        }
    }
}

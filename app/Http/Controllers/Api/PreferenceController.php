<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Preference\PreferenceService;
use App\Services\Preference\PreferenceServiceInterface;
use App\Traits\UtilityResources\UtilityResources;
use App\Transformers\ApiResponseResource;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreferenceController extends Controller
{
    use UtilityResources;

    /**
     * @param PreferenceServiceInterface $service
     */
    public function __construct(protected PreferenceServiceInterface $service)
    {
    }

    /**
     * @param Request $request
     * @return ApiResponseResource
     */
    public function userPreference(Request $request)
    {
        try {
            return $this->success($this->service->userPreference(), Response::HTTP_OK, 'List All User Preferences');
        }catch (Exception $exception){
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function personalizedFeed(Request $request)
    {
        try {
            return $this->success($this->service->personalizedFeed(), Response::HTTP_OK, 'List All User Personalized Feed');
        }catch (Exception $exception){
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

}

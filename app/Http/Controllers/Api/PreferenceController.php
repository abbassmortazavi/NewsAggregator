<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Preference\PreferenceStoreRequest;
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
     * @OA\Patch(
     *     path="/api/preferences",
     *     summary="Update or create user preferences",
     *     tags={"Preferences"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"authors", "categories", "sources"},
     *             @OA\Property(property="authors", type="array", @OA\Items(type="string"), description="List of preferred authors"),
     *             @OA\Property(property="categories", type="array", @OA\Items(type="string"), description="List of preferred categories"),
     *             @OA\Property(property="sources", type="array", @OA\Items(type="string"), description="List of preferred news sources"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User preferences updated or created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", @OA\Property(property="authors", type="array", @OA\Items(type="string")), @OA\Property(property="categories", type="array", @OA\Items(type="string")), @OA\Property(property="sources", type="array", @OA\Items(type="string"))),
     *             @OA\Property(property="message", type="string", example="List All User Preferences")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     *
     * @param PreferenceStoreRequest $request
     * @return ApiResponseResource
     */
    public function updateOrCreate(PreferenceStoreRequest $request)
    {
        try {
            return $this->success($this->service->updateOrCreate($request->only('authors', 'categories', 'sources')), Response::HTTP_OK, 'List All User Preferences');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/preferences",
     *     summary="Get user preferences",
     *     tags={"Preferences"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     * @param Request $request
     * @return ApiResponseResource
     */
    public function userPreference(Request $request)
    {
        try {
            return $this->success($this->service->userPreference(), Response::HTTP_OK, 'List All User Preferences');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/feed",
     *     summary="Get user preferences",
     *     tags={"Preferences"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     * @param Request $request
     * @return ApiResponseResource
     */
    public function personalizedFeed(Request $request)
    {
        try {
            return $this->success($this->service->personalizedFeed(), Response::HTTP_OK, 'List All User Personalized Feed');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

}

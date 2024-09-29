<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleSearchRequest;
use App\Http\Resources\Article\ArticleSearchResource;
use App\Models\Article;
use App\Services\Article\ArticleServiceInterface;
use App\Traits\UtilityResources\UtilityResources;
use App\Transformers\ApiResponseResource;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    use UtilityResources;

    /**
     * @param ArticleServiceInterface $service
     */
    public function __construct(protected ArticleServiceInterface $service)
    {
    }

    /**
     * @OA\Get(
     *       path="/api/articles?page={page}&per_page={per_page}",
     *       summary="Article",
     *       tags={"Article"},
     *
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Article Page",
     *          @OA\Schema(
     *              type="int"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          required=false,
     *          description="Article Per Page",
     *          @OA\Schema(
     *              type="int"
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
     * @param Request $request
     * @return ApiResponseResource
     */
    public function index(Request $request)
    {
        try {
            return $this->success($this->service->index($request->only('page', 'per_page')), Response::HTTP_OK, 'List All Articles');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/articles/{id}",
     *       summary="Article",
     *       tags={"Article"},
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          required=false,
     *          description="Article Id",
     *          @OA\Schema(
     *              type="int"
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
     * @param Article $article
     * @return ApiResponseResource
     */
    public function show(Article $article)
    {
        try {
            return $this->success($article, Response::HTTP_OK, 'Article Details');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *       path="/api/articles/search",
     *       summary="Article",
     *       tags={"Article"},
     *
     *     @OA\Parameter(
     *          name="category",
     *          in="query",
     *          required=false,
     *          description="Article Category",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="source",
     *          in="query",
     *          required=false,
     *          description="Article Per Source",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *           name="date",
     *           in="query",
     *           required=false,
     *           description="Article Date",
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
     * @param ArticleSearchRequest $request
     * @return ApiResponseResource
     */
    public function search(ArticleSearchRequest $request)
    {
        try {
            $result = ArticleSearchResource::collection($this->service->search($request->only('keyword', 'category', 'source', 'date')));


            return $this->success($result, Response::HTTP_OK, 'Search Article Successfully!');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }
}

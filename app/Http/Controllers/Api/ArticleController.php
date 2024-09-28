<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleIndexRequest;
use App\Models\Article;
use App\Services\Article\ArticleService;
use App\Services\Article\ArticleServiceInterface;
use App\Traits\UtilityResources\UtilityResources;
use App\Transformers\ApiResponseResource;
use Exception;
use Illuminate\Http\Request;
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
     * @param ArticleIndexRequest $request
     * @return ApiResponseResource
     */
    public function index(ArticleIndexRequest $request)
    {
        try {
            return $this->success($this->service->index($request->only('limit', 'page', 'per_page','keyword','category','source','date')), Response::HTTP_OK, 'List All Articles');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    /**
     * @param Article $article
     * @return ApiResponseResource
     */
    public function show(Article $article)
    {
        try {
            return $this->success($article, Response::HTTP_OK, 'List All Articles');
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }
}

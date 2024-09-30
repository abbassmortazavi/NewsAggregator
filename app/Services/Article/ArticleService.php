<?php

namespace App\Services\Article;

use App\Base\BaseService;
use App\Repositories\Article\ArticleRepositoryInterface;

class ArticleService extends BaseService implements ArticleServiceInterface
{
    /**
     * @param ArticleRepositoryInterface $repository
     */
    public function __construct(ArticleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function index(array $attributes): mixed
    {
        $attributes['limit'] = $attributes['limit'] ?? 10;
        $attributes['per_page'] = $attributes['per_page'] ?? 5;
        $attributes['page'] = $attributes['page'] ?? 1;
        return $this->repository->index($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function search(array $attributes): mixed
    {
        return $this->repository->search($attributes);
    }
}

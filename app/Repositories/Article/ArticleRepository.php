<?php

namespace App\Repositories\Article;

use App\Base\BaseRepository;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redis;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    /**
     * @param Article $model
     */
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function index(array $attributes): mixed
    {
        $cacheKey = $this->buildCacheKey($attributes);
        $cacheTTL = 5 * 60; // Time to live in seconds (5 minutes)
        $cachedResult = Redis::get($cacheKey);
        if ($cachedResult) {
            // If the result exists in Redis, return it
            return json_decode($cachedResult, true);
        }
        $result = $this->model->query()
            ->paginate($attributes['per_page'], $columns = ['*'], $pageName = 'page', $attributes['page']);
        // Cache the result in Redis
        Redis::setex($cacheKey, $cacheTTL, json_encode($result));
        return $result;
    }

    /**
     * Generate a unique cache key based on the query attributes.
     *
     * @param array $attributes
     * @return string
     */
    protected function buildCacheKey(array $attributes): string
    {
        return 'articles_' . md5(json_encode($attributes));
    }

    /**
     * @param object $preference
     * @return LengthAwarePaginator
     */
    public function getUserPreference(object $preference): LengthAwarePaginator
    {
        return $preference->query()
            ->whereIn('source', $preference->sources)
            ->orWhereIn('category', $preference->categories)
            ->orWhereIn('author', $preference->authors)
            ->paginate(10);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator
     */
    public function search(array $attributes): LengthAwarePaginator
    {
        return $this->model->query()
            ->when(isset($attributes['keyword']), fn(Builder $query) => $query->where('title', 'like', '%' . $attributes['keyword'] . '%'))
            ->when(isset($attributes['category']), fn(Builder $query) => $query->where('category', 'like', '%' . $attributes['category'] . '%'))
            ->when(isset($attributes['source']), fn(Builder $query) => $query->where('source', 'like', '%' . $attributes['source'] . '%'))
            ->when(isset($attributes['date']), fn(Builder $query) => $query->where('published_at', 'like', '%' . $attributes['date'] . '%'))
            ->paginate(50);
    }
}

<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function __construct(protected Article $article)
    {
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator
     */
    public function index(array $attributes): LengthAwarePaginator
    {
        return $this->article->query()
            ->when($attributes['keyword'], function ($query) use ($attributes) {
                return $query->where('title', 'like', '%' . $attributes['keyword'] . '%');
            })
            ->when($attributes['category'], function ($query) use ($attributes) {
                return $query->where('category', $attributes['category']);
            })
            ->when($attributes['source'], function ($query) use ($attributes) {
                return $query->where('source', $attributes['source']);
            })
            ->when($attributes['date'], function ($query) use ($attributes) {
                return $query->whereDate('published_at', $attributes['date']);
            })
            ->paginate($attributes['per_page'], $columns = ['*'], $pageName = 'page', $attributes['page'], $attributes['limit']);
    }
}

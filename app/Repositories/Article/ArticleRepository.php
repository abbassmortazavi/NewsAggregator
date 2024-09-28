<?php

namespace App\Repositories\Article;

use App\Base\BaseRepository;
use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository extends BaseRepository implements ArticleRepositoryInterface
{
    public function __construct(Article $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator
     */
    public function index(array $attributes): LengthAwarePaginator
    {
        return $this->model->query()
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
            ->paginate($attributes['per_page'], $columns = ['*'], $pageName = 'page', $attributes['page']);
    }

    /**
     * @param object $preference
     * @return LengthAwarePaginator
     */
    public function getUserPreference(object $preference): LengthAwarePaginator
    {
        return $this->article->query()
            ->whereIn('source', $preference->sources)
            ->orWhereIn('category', $preference->categories)
            ->orWhereIn('author', $preference->authors)
            ->paginate(10);
    }
}

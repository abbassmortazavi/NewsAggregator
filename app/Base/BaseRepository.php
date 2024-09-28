<?php

namespace App\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function store(array $attributes): Model
    {
        return $this->model->query()->create($attributes);
    }

    /**
     * @param array $attributes
     * @param Model $model
     * @return int
     */
    public function update(array $attributes, Model $model): int
    {
        return $model->query()->update($attributes);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->query()->delete();
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->query()->find($id);
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator
     */
    public function index(array $attributes): LengthAwarePaginator
    {
        return $this->model->query()->paginate($attributes['per_page'], $columns = ['*'], $pageName = 'page', $attributes['page'], $attributes['limit']);
    }

    /**
     * @param Model $model
     * @return Model
     */
    public function show(Model $model): Model
    {
        return $model;
    }
}

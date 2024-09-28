<?php

namespace App\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    /**
     * @var mixed
     */
    protected mixed $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $attributes
     * @return LengthAwarePaginator
     */
    public function index(array $attributes): LengthAwarePaginator
    {
        return $this->repository->index($attributes);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function store(array $attributes): Model
    {
        return $this->repository->store($attributes);
    }

    /**
     * @param array $attributes
     * @param Model $model
     * @return bool
     */
    public function update(array $attributes, Model $model): bool
    {
        return $this->repository->update($attributes, $model);
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $this->repository->delete($model);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }
}

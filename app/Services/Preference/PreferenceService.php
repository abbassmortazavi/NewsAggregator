<?php

namespace App\Services\Preference;

use App\Base\BaseService;
use App\Repositories\Preference\PreferenceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PreferenceService extends BaseService implements PreferenceServiceInterface
{
    /**
     * @param PreferenceRepositoryInterface $repository
     */
    public function __construct(PreferenceRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function updateOrCreate(array $attributes): Model
    {
        $attributes['user_id'] = auth()->id();
        return $this->repository->store($attributes);
    }

    /**
     * @return mixed
     */
    public function userPreference(): mixed
    {
        return $this->repository->userPreference();
    }

    /**
     * @return mixed
     */
    public function personalizedFeed(): mixed
    {
        return $this->repository->personalizedFeed();
    }
}

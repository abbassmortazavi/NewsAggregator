<?php

namespace App\Services\Preference;

use App\Base\BaseService;

class PreferenceService extends BaseService implements PreferenceServiceInterface
{
    public function __construct($repository)
    {
        parent::__construct($repository);
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

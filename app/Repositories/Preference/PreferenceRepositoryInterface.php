<?php

namespace App\Repositories\Preference;

interface PreferenceRepositoryInterface
{
    /**
     * @return mixed
     */
    public function userPreference(): mixed;

    /**
     * @return mixed
     */
    public function personalizedFeed(): mixed;
}

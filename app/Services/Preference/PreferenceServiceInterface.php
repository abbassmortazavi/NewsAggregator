<?php

namespace App\Services\Preference;

interface PreferenceServiceInterface
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

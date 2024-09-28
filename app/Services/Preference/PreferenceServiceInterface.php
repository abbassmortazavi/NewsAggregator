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

    /**
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $attributes): mixed;
}

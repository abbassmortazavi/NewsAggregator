<?php

namespace App\Repositories\Preference;

use App\Base\BaseRepository;
use App\Models\Preference;
use App\Repositories\Article\ArticleRepositoryInterface;

class PreferenceRepository extends BaseRepository implements PreferenceRepositoryInterface
{
    public function __construct(Preference $model)
    {
        parent::__construct($model);
    }

    /**
     * @return mixed
     */
    public function userPreference(): mixed
    {

        return $this->getUserPreference();
    }

    /**
     * @return mixed
     */
    public function personalizedFeed(): mixed
    {
        $userPreference = $this->getUserPreference();
        return app(ArticleRepositoryInterface::class)->getUserPreference($userPreference);
    }

    /**
     * @return mixed|null
     */
    private function getUserPreference(): mixed
    {
        $user = auth()->user();
        return $user->preference ?? null;
    }
}

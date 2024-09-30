<?php

namespace App\Repositories\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param object $preference
     * @return mixed
     */
    public function getUserPreference(object $preference): mixed;

    /**
     * @param array $attributes
     * @return mixed
     */
    public function search(array $attributes): mixed;
}

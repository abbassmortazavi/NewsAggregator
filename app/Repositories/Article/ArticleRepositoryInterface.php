<?php

namespace App\Repositories\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function index(array $attributes): mixed;

    /**
     * @param object $preference
     * @return mixed
     */
    public function getUserPreference(object $preference): mixed;
}

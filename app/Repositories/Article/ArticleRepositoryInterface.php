<?php

namespace App\Repositories\Article;

interface ArticleRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function index(array $attributes): mixed;
}

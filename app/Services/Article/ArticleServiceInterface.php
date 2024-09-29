<?php

namespace App\Services\Article;

interface ArticleServiceInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function search(array $attributes): mixed;
}

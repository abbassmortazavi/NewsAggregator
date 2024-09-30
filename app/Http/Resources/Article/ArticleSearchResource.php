<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleSearchResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'description' => $this->description,
            'author' => $this->author,
            'source' => $this->source,
            'category' => $this->category,
            'url' => $this->url,
            'published_at' => $this->published_at,
        ];
    }

    /**
     * Add pagination data to the response.
     *
     * @param Request $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'meta' => [
                'total' => $this->total(), // total number of items
                'per_page' => $this->perPage(), // items per page
                'current_page' => $this->currentPage(), // current page number
                'last_page' => $this->lastPage(), // last page number
                'from' => $this->firstItem(), // starting item number
                'to' => $this->lastItem(), // ending item number
            ],
        ];
    }
}

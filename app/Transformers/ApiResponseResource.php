<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponseResource extends JsonResource
{
    protected int $statusCode;

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        if (isset($this->resource['success']) && $this->resource['success']) {
            return [
                'success' => $this->resource['success'],
                'message' => $this->resource['message'],
                'data' => $this->resource['data'],
            ];
        }
        return [
            'success' => false,
            'error' => $this->resource['error'],
        ];
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function withStatusCode($statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'status' => $this->statusCode,
        ];
    }

    /**
     * @param Request $request
     * @param $response
     * @return void
     */
    public function withResponse(Request $request, $response): void
    {
        $response->setStatusCode($this->statusCode);
    }
}

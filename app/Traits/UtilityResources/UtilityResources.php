<?php

namespace App\Traits\UtilityResources;

use App\Transformers\ApiResponseResource;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

trait UtilityResources
{
    /**
     * @param $data
     * @param $status
     * @param string|null $message
     * @return ApiResponseResource
     */
    public function success($data, $status, string $message = null): ApiResponseResource
    {
        return (new ApiResponseResource([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ]))->withStatusCode($status);
    }


    /**
     * @param $status
     * @param string|null $message
     * @return ApiResponseResource
     */
    public function error($status, string $message = null): ApiResponseResource
    {
        return (new ApiResponseResource([
            'success' => false,
            'error' => $message,
        ]))->withStatusCode($status);
    }

    /**
     * @param $data
     * @param $paginate
     * @param $status
     * @return ApiResponseResource
     */
    public function paginate($data, $paginate, $status): ApiResponseResource
    {
        return $this->success($data->paginate($paginate), $status);
    }


}

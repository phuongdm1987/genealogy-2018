<?php
declare(strict_types=1);

namespace Genealogy\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * Trait JsonResponseHandler
 * @package Genealogy\Helpers
 */
trait JsonResponseHandler
{
    /**
     * @param $data
     * @param bool $transform
     * @return JsonResponse
     */
    protected function successResponse($data, $transform = true): JsonResponse
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => $transform ? $this->transform($data) : $data,
            'message' => 'Success'
        ];

        return response()->json($response, $response['code']);
    }

    /**
     * @return JsonResponse
     */
    protected function notFoundResponse(): JsonResponse
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * @return JsonResponse
     */
    public function deleteResponse(): JsonResponse
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource Deleted'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function errorResponse($data): JsonResponse
    {
        $response = [
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable Entity'
        ];
        return response()->json($response, $response['code']);
    }
}

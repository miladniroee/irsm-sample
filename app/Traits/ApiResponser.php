<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    protected function successResponse(array|string|null $message = null, $data = null, int $code = 200): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'status' => $code,
                'data' => $data
            ], $code);
    }

    protected function errorResponse(array|string $message, int $code): JsonResponse
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'status' => $code,
                'data' => null
            ], $code);
    }
}

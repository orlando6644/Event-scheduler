<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

/**
 * In order to keep the response format consistent, we can create a helper class that will handle the response format.
 */
class ApiResponse
{
    /**
     * success
     *
     * @param  mixed $data
     * @param  string $message
     * @param  int $status
     * @return JsonResponse
     */
    public static function success($data = [], string $message = 'success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * error
     *
     * @param  string $message
     * @param  array $errors
     * @param  int $status
     * @return JsonResponse
     */
    public static function error(string $message = 'An error has occurred', array $errors = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}

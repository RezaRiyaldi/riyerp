<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{

    // for success response
    protected function success($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // for created response
    protected function created(mixed $data = null, string $message = 'Created', int $status = 201): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    // for error response
    protected function error(string $message = 'Error', int $status = 500, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    // for not found
    protected function notFound(string $message = 'Resource Not Found'): JsonResponse
    {
        return $this->error($message, 404);
    }

    // for unauthorized
    protected function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->error($message, 401);
    }

    // for forbidden
    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->error($message, 403);
    }

    // for validation error
    protected function validationError($errors, string $message = 'Validation Error'): JsonResponse
    {
        return $this->error($message, 422, $errors);
    }
}
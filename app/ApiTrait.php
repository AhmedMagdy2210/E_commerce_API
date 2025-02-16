<?php

namespace App;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiTrait {
    public function successResponse($data = [], $message = '', $status = 200) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }
    public function errorResponse($message = '', $status = 200) {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
    public function failedValidationResponse($errors = '') {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $errors,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY) // 422 status code
        );
    }
}

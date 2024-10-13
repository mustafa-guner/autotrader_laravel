<?php

namespace App\Services;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{

    static public function success($data, string|null $message, int $status = Response::HTTP_OK): JsonResponse
    {
        $message = $message ?? trans('commons.success');
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $status);
    }

    static public function fail(string|null $message, $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $message = $message ?? trans('commons.fail');
        return response()->json([
            'message' => $message
        ], $status);
    }
}

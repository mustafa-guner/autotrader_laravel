<?php

namespace App\Exceptions;

use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    public function __construct(string $message = 'Not Found', int $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }

    public function render(): JsonResponse
    {
        return ResponseService::fail($this->getMessage(), $this->getCode());
    }
}

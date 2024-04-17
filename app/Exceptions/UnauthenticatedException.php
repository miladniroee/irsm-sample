<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\JsonResponse;

class UnauthenticatedException extends Exception
{
    use ApiResponser;

    public function render($request): JsonResponse
    {
        return $this->errorResponse('شما وارد حساب کاربری خود نشده اید.', 401);
    }
}

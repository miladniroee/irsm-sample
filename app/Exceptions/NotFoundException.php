<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;

class NotFoundException extends Exception
{
    use ApiResponser;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */


    /**
     * Register the exception handling callbacks for the application.
     */

    public function render(): \Illuminate\Http\JsonResponse
    {
        return $this->errorResponse('یافت نشد.', 404);
    }
}

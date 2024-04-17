<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Throwable;

class PermissionDoesNotExistException extends Exception
{
    use ApiResponser;

    private string $messageText;
    public function __construct(Throwable $e)
    {
        parent::__construct();
        $this->messageText = $e->getMessage();
    }

    public function render()
    {
        return $this->errorResponse($this->messageText, 404);
    }

}

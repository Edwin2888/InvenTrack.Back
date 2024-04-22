<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\Request;

class InvenTrackException extends Exception
{
    public function __construct($message = 'Error no controlado', int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?Throwable $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request)
    {
        return response()->json($this->message, $this->code);
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\Request;

class InvenTrackException extends Exception
{
    protected bool $messageIsArray = false;
    public function __construct($message = 'Error no controlado', int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?Throwable $previous = null)
    {
        if (is_array($message)) {
            $this->messageIsArray = true;
            $message = json_encode($message);
        }

        parent::__construct($message, $code, $previous);
    }

    public function render(Request $request)
    {
        if (!!$this->messageIsArray) {
            $message = json_decode($this->message);
        } else {
            $message = $this->message;
        }

        return response()->json($message, $this->code);
    }
}

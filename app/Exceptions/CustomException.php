<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{

    protected $statusCode;

    public function __construct($message = "Custom Error", $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    // This method will define the response when this exception is thrown
    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], $this->getStatusCode());
    }
}

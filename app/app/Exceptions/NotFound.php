<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\ErrorCode;

class NotFound extends Exception
{
    public function render() {
        return response()->json([
            'message' => "Not found",
            'error' => ErrorCode::NOT_FOUND
        ], 404);
    }
}

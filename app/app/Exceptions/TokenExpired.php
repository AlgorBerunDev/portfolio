<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\ErrorCode;

class TokenExpired extends Exception
{
    public function render() {
        return response()->json([
            'message' => 'Token expired',
            'error' => ErrorCode::TOKEN_EXPIRED
        ], 403);
    }
}

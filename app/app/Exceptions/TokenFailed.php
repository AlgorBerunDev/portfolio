<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\StatusCode;
use Firebase\JWT\SignatureInvalidException;

class TokenFailed extends SignatureInvalidException
{
    public function render() {
        return response()->json([
            'message' => 'Token failed',
            'error' => ErrorCode::TOKEN_FAILED
        ], 401);
    }
}

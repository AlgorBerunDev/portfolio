<?php

namespace App\Exceptions;

use Exception;

class RenderableException extends Exception {

    public function render() {
        return response()->json([
            'message' => $this->getMessage(),
            'code' => $this->getCode()
        ], 400);
    }
}


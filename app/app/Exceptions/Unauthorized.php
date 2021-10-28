<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\ErrorCode;

class Unauthorized extends Exception
{
    private $options;

    public function __construct($options = []){
        $this->options = $options;
    }

    public function render(){
        $result = array_merge([
            'message' => 'Unauthorized',
            'error' => ErrorCode::ACCESS_DENIED,
        ], $this->options);

        return response()->json($result, 401);
    }
}
